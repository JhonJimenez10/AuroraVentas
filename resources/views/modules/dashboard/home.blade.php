@extends('layouts.main')

@section('content')
    <main id="main" class="main modern-dashboard" style="background: #f8fafc;">

        <!-- Encabezado -->
        <div class="pagetitle mb-4">
            <h1 class="fw-bold text-dark">📊 Panel de Control</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row g-4">

                <!-- Cards principales -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card gradient-blue shadow-lg border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Ventas</h6>
                                    <h3 class="fw-bold text-white mb-0">145</h3>
                                    <small class="text-white-50">+12% este mes</small>
                                </div>
                                <div class="icon-box">
                                    <i class="bi bi-cart3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card gradient-green shadow-lg border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Facturación</h6>
                                    <h3 class="fw-bold text-white mb-0">$3,264</h3>
                                    <small class="text-white-50">+8% ingresos</small>
                                </div>
                                <div class="icon-box">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card gradient-orange shadow-lg border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Proveedores</h6>
                                    <h3 class="fw-bold text-white mb-0">1,244</h3>
                                    <small class="text-white-50">-12% cambio</small>
                                </div>
                                <div class="icon-box">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card gradient-purple shadow-lg border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase fw-bold text-white-50 mb-2">Usuarios activos</h6>
                                    <h3 class="fw-bold text-white mb-0">512</h3>
                                    <small class="text-white-50">+5 nuevos hoy</small>
                                </div>
                                <div class="icon-box">
                                    <i class="bi bi-person-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico principal -->
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mb-0 fw-bold">📈 Reporte General</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle"
                                        data-bs-toggle="dropdown">Filtrar</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Hoy</a></li>
                                        <li><a class="dropdown-item" href="#">Este mes</a></li>
                                        <li><a class="dropdown-item" href="#">Este año</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="reportsChart" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Estilos personalizados -->
    <style>
        .modern-dashboard .pagetitle h1 {
            font-size: 1.8rem;
        }

        .stat-card {
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            font-size: 2rem;
            color: white;
            opacity: 0.85;
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .gradient-green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .card-title span {
            color: #6b7280;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #9ca3af;
        }
    </style>

    <!-- Scripts gráficos -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // Gráfico principal (ApexCharts)
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                        name: 'Ventas',
                        data: [31, 40, 28, 51, 42, 82, 56]
                    },
                    {
                        name: 'Ingresos',
                        data: [11, 32, 45, 32, 34, 52, 41]
                    },
                    {
                        name: 'Clientes',
                        data: [15, 11, 32, 18, 9, 24, 11]
                    }
                ],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                markers: {
                    size: 4
                },
                colors: ['#3b82f6', '#22c55e', '#f59e0b'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
                }
            }).render();
        });
    </script>
@endsection
