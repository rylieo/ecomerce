@extends('layouts.sidebar')

@section('content')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Charts</title>

    <div class="export-buttons d-flex justify-content-start mb-4">
        <a href="{{ route('admin.export.sales') }}" class="btn btn-success btn-icon-split mr-3">
            <span class="icon text-white-50">
                <i class="fas fa-file-excel"></i>
            </span>
            <span class="text">Export Penjualan ke Excel</span>
        </a>

        <a href="{{ route('admin.export.pdf') }}" class="btn btn-danger btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf"></i>
            </span>
            <span class="text">Export PDF</span>
        </a>
    </div>





    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

        <style>
            .chart-container {
                position: relative;
                height: 450px;
                padding: 15px;
                background-color: #f8f9fc;
                border-radius: 15px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            }

            .canvas-container {
                padding: 20px;
                background-color: #ffffff;
                border-radius: 15px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .chartjs-render-monitor {
                font-family: 'Nunito', sans-serif;
                color: #5a5c69;
            }

            .btn {
                margin: 10px 0;
                padding: 10px 20px;
                font-size: 16px;
                border-radius: 50px;
            }

            /* Animasi saat chart muncul */
            canvas {
                animation: fadeIn 1s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
        </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Donut Chart -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Donut Chart - Total Orders per Category</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container canvas-container">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Line Chart for Daily Sales -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Line Chart - Total Products Sold per Day</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container canvas-container">
                                        <canvas id="myLineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Monthly Sales Row -->
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Line Chart - Total Products Sold per Month</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container canvas-container">
                                        <canvas id="myMonthlyLineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Yearly Sales Row -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Line Chart - Total Products Sold per Year</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container canvas-container">
                                        <canvas id="myYearlyLineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        // Donut Chart Data
        var categoryNames = {!! json_encode($categoryNames) !!};
        var orderCounts = {!! json_encode($orderCounts) !!};
        var categoryColors = {!! json_encode($categories->pluck('color')) !!};

        var ctxPie = document.getElementById('myPieChart');
var myPieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: categoryNames,
        datasets: [{
            data: orderCounts,
            backgroundColor: categoryColors,
            hoverBackgroundColor: categoryColors.map(color => color.replace(/[^,]+(?=\))/, '0.8')),
            hoverBorderColor: "#fff",
            borderWidth: 2,
            borderColor: '#fff'
        }],
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        animation: {
            animateScale: true,
            animateRotate: true
        },
        plugins: {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    font: {
                        size: 14,
                        family: 'Nunito, sans-serif' /* Font sesuai SB Admin 2 */
                    },
                    padding: 20,
                    boxWidth: 20
                }
            }
        }
    }
});


        // Line Chart Data for Daily Sales
        var days = {!! json_encode($days) !!};
        var productSoldCounts = {!! json_encode($productSoldCounts) !!};

        var ctxLine = document.getElementById('myLineChart');
        var myLineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: days,
                datasets: [{
                    label: 'Jumlah Produk Terjual per Hari',
                    data: productSoldCounts,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        }
                    }
                }
            }
        });

        // Line Chart Data for Monthly Sales
        var months = {!! json_encode($months) !!};
        var monthlySoldCounts = {!! json_encode($monthlySoldCounts) !!};

        var ctxMonthlyLine = document.getElementById('myMonthlyLineChart');
        var myMonthlyLineChart = new Chart(ctxMonthlyLine, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Produk Terjual per Bulan',
                    data: monthlySoldCounts,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        }
                    }
                }
            }
        });

        // Line Chart Data for Yearly Sales
        var years = {!! json_encode($years) !!};
        var yearlySoldCounts = {!! json_encode($yearlySoldCounts) !!};

        var ctxYearlyLine = document.getElementById('myYearlyLineChart');
        var myYearlyLineChart = new Chart(ctxYearlyLine, {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Jumlah Produk Terjual per Tahun',
                    data: yearlySoldCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        }
                    }
                }
            }
        });
    </script>
</body>

@endsection
