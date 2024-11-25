<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetMail;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Models\User;
use App\Models\ContactInfo;
use Exception;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        $contacts = ContactInfo::first();

        return view('auth.login', compact('contacts'));
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        $contacts = ContactInfo::first();

        return view('auth.register', compact('contacts'));
    }

    // Handle the registration process
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Gunakan email lain atau login.',
            'password.confirmed' => 'Password tidak cocok. Pastikan password dan konfirmasi password sesuai.',
        ]);

        // Simpan pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password, // Simpan password asli
            'verification_token' => Str::random(60), // Generate token acak
        ]);

        // Otentikasi pengguna
        Auth::login($user);

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerificationEmail($user));

        // Alihkan ke halaman verifikasi email
        return redirect()->route('verification.notice');
    }

    // Show the email verification notice
    public function showRegistrationSuccess()
    {
        return view('auth.register-success');
    }

    public function showVerificationNotice()
    {
        $contacts = ContactInfo::first();

        return view('auth.verify-email', compact('contacts'));
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::user();
        $key = 'verification-sent-' . $user->id;

        // Cek apakah pengiriman ulang dilakukan dalam 5 detik terakhir
        if (Cache::has($key)) {
            return redirect()->route('verification.notice')
                ->with('status', 'Please wait before requesting another verification link.');
        }

        // Generate token baru dan simpan
        $user->verification_token = Str::random(60);
        $user->save();

        // Kirim email verifikasi ulang
        Mail::to($user->email)->send(new VerificationEmail($user));
        Cache::put($key, true, 5); // Simpan dalam cache selama 5 detik

        return redirect()->route('verification.notice')
            ->with('status', 'A new verification link has been sent to your email address.');
    }
    // Verify the email address
    // Verify the email address
    public function verifyEmail(Request $request, $token)
    {
        // Temukan pengguna berdasarkan token
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid verification token.']);
        }

        // Update status email verified
        $user->email_verified_at = now();
        $user->verification_token = null; // Hapus token setelah verifikasi
        $user->save();

        return view('auth.verify-success'); // Tampilkan halaman sukses verifikasi
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba untuk mendapatkan user berdasarkan email
        $user = User::where('email', $request->input('email'))->first();

        // Cek apakah user dengan email tersebut ada
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        // Cek apakah password sesuai
        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Cek apakah email sudah diverifikasi
        if (!$user->email_verified_at) {
            return redirect()->route('verification.notice')
            ->with('status', 'Silakan verifikasi email Anda sebelum melanjutkan.');
        }

        try {
            // Generate OTP dan set waktu expired
            $otpCode = rand(100000, 999999);
            $otpExpiresAt = now()->addMinutes(5);

            // Mulai transaksi database
            DB::beginTransaction();

            // Update kode OTP dan waktu expired di database
            DB::table('users')
                ->where('email', $request->email)
                ->update([
                    'otp_code' => $otpCode,
                    'otp_expires_at' => $otpExpiresAt,
                ]);

            // Kirim email OTP
            Mail::to($user->email)->send(new OtpMail($otpCode));

            // Commit transaksi
            DB::commit();

            // Redirect ke form OTP
            return redirect()->route('otp.form')->with('email', $user->email);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }
    }

    public function showChangePasswordForm()
    {
        $contacts = ContactInfo::first();

        return view('auth.change-password', compact('contacts'));
    }

    // Handle the change password request
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password Yang Anda Masukan Salah.']);
        }

        // Update the password
        $user->password = Hash::make($request->input('new_password'));
        $user->plain_password = $request->input('new_password'); // Simpan plain_password
        $user->save();

        return redirect()->route('profile')->with('status', 'Password changed successfully!');
    }


    // Show the password reset request form
    public function showResetRequestForm()
    {
        $contacts = ContactInfo::first();

        return view('auth.passwords.email', compact('contacts'));
    }

    // Send the password reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            $token = Str::random(60); // Generate a random token
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->input('email')],
                ['token' => $token, 'created_at' => now()]
            );

            // Store the email in session
            session(['reset_email' => $request->input('email')]);

            try {
                // Send password reset email
                Mail::to($request->input('email'))->send(new PasswordResetMail($token, $request->input('email')));

                return back()->with('status', 'Email terkirim! Tolong Cek Email Anda.');
            } catch (Exception $e) {
                return back()->withErrors(['email' => 'Failed to send reset link. Please try again.']);
            }
        }

        return back()->withErrors(['email' => 'Email Yang Anda Masukan Belum Terdaftar.']);
    }

    // Show the password reset form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Reset the password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Retrieve email from the session
        $email = session('reset_email');

        $reset = DB::table('password_resets')
        ->where('email', $email)
        ->where('token', $request->token)
        ->where('created_at', '>', now()->subHours(2)) // Token expired after 2 hours
        ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can’t find a user with that email address.']);
        }

        // Update the password and plain_password
        $user->password = Hash::make($request->password);
        $user->plain_password = $request->password; // Simpan plain_password
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();

        Auth::loginUsingId($user->id);

        return redirect()->route('login')->with('status', 'Password has been reset! You can now log in.');
    }


    // Show the OTP form
    public function showOtpForm(Request $request)
    {
        $contacts = ContactInfo::first();

        return view('auth.otp', ['email' => $request->query('email')], compact('contacts'));
    }

    // Verify the OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|integer',
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user && $user->otp_code == $request->input('otp_code') && $user->otp_expires_at > now()) {
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();

            // OTP tetap ada di database

            return redirect()->route('welcome')->with('status', 'Login successful!');
        }

        // OTP code is incorrect or expired
        return redirect()->route('otp.form')
            ->with('email', $email)
            ->with('otp_failed', 'Kode OTP salah. Tolong Coba Lagi.');
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            DB::beginTransaction();

            try {
                // Generate a new OTP code and set its expiration
                $otpCode = rand(100000, 999999);
                $otpExpiresAt = now()->addMinutes(5);

                // Update the OTP and expiration time in the database
                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'otp_code' => $otpCode,
                        'otp_expires_at' => $otpExpiresAt,
                    ]);

                // Send the new OTP code via email
                Mail::to($user->email)->send(new OtpMail($otpCode));

                DB::commit();

                return redirect()->route('otp.form')
                    ->with('email', $email)
                    ->with('status', 'Kode OTP Terkirim. Tolong Cek Email Anda.');
            } catch (Exception $e) {
                DB::rollBack();
                return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
            }
        }

        return back()->withErrors(['email' => 'Email not registered.']);
    }
}
