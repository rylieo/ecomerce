<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Produk Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dailySales as $sale)
            <tr>
                <td>{{ $sale->sale_date }}</td>
                <td>{{ $sale->total_sold }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h4>Penjualan Bulanan</h4>
<table>
    <thead>
        <tr>
            <th>Bulan</th>
            <th>Jumlah Produk Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($monthlySales as $sale)
            <tr>
                <td>{{ $sale->sale_month }}</td>
                <td>{{ $sale->total_sold }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h4>Penjualan Tahunan</h4>
<table>
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Jumlah Produk Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($yearlySales as $sale)
            <tr>
                <td>{{ $sale->sale_year }}</td>
                <td>{{ $sale->total_sold }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
