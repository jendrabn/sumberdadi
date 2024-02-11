@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Seller Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pesanan</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_orders }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Produk</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_products }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Acara Komunitas</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_events }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Member Komunitas</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_members }}
                        </div>
                    </div>
                </div>
            </div>
            @if($balance_histories->isNotEmpty())
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary pt-3 px-2">
                        <h6 class="text-white">Rp</h6>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Saldo</h4>
                        </div>
                        <div class="card-body">
                            @priceIDR($balance)
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @if($community->is_active === 0)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="hero bg-primary text-white">
                    <div class="hero-inner">
                        <h2>Selamat Datang, {{auth()->user()->first_name}}!</h2>
                        <p class="lead">Anda telah menjadi seller di {{config('app.name')}}. Anda dapat mulai dengan menambahkan informasi untuk komunitas dan toko Anda.</p>
                        <div class="mt-4">
                            <a href="{{route('seller.community.edit')}}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="fas fa-edit"></i> Ubah Informasi Komunitas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Pesanan Terbaru</h4>
                        <div class="card-header-action">
                            <a href="{{route('seller.orders.index')}}" class="btn btn-danger">Lihat Semua <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive table-orders">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Tanggal Pesan</th>
                                <th>Action</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>#{{$order->id}}</td>
                                    <td class="font-weight-600">{{$order->user->full_name}}</td>
                                    <td>{{$order->status}}</td>
                                    <td>{{$order->created_at->format('d F Y')}}</td>
                                    <td>
                                        <a href="{{route('seller.orders.show', $order->id)}}" class="btn btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script>
        $(function() {
            let balance_chart = document.getElementById("balance-chart").getContext('2d');

            let balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
            balance_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
            balance_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

            let myChart = new Chart(balance_chart, {
                type: 'line',
                data: {
                    labels: [@foreach($balance_histories->values() as $date) '{{$date->format('d-m-Y')}}' @if(!$loop->last) , @endif @endforeach],
                    datasets: [{
                        label: 'Saldo',
                        data: [@foreach($balance_histories->keys() as $balance) {{$balance}} @if(!$loop->last) , @endif @endforeach],
                        backgroundColor: balance_chart_bg_color,
                        borderWidth: 3,
                        borderColor: 'rgba(63,82,227,1)',
                        pointBorderWidth: 0,
                        pointBorderColor: 'transparent',
                        pointRadius: 3,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            bottom: -1,
                            left: -1
                        }
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display: false,
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    },
                }
            });
        })
    </script>
@endpush
