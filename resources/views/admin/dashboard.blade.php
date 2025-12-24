@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/admin_resources/css/small-box.css">
@endpush

@push('scripts')
<script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
<script src="/admin_resources/js/off-canvas.js"></script>
<script src="/admin_resources/js/hoverable-collapse.js"></script>
<script src="/admin_resources/js/template.js"></script>
<script src="/admin_resources/js/settings.js"></script>
<script src="/admin_resources/js/todolist.js"></script>
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<script src="/admin_resources/js/dashboard.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var ctxSales = document.getElementById('salesBarChart').getContext('2d');
        var salesData = {!! json_encode($formattedSalesData->values()->toArray()) !!}; 
        var salesLabels = {!! json_encode($formattedSalesData->keys()->toArray()) !!}; 

        new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: salesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Warna Biru
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });

        var ctxRevenue = document.getElementById('revenueBarChart').getContext('2d');
        var revenueData = {!! json_encode($formattedRevenueData->values()->toArray()) !!}; 
        var revenueLabels = {!! json_encode($formattedRevenueData->keys()->toArray()) !!}; 

        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: revenueData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: { 
                    y: { 
                        beginAtZero: true, // Wajib true
                        suggestedMin: 0,   // Paksa mulai dari 0
                        ticks: {
                            callback: function(value) {
                                // Format Rupiah yang lebih rapi
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

    });
</script>
@endpush

@section('title', 'Admin - Dashboard')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      @include('partials.message-bag')
      @include('partials.order-stats')

      <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-3">Grafik Jumlah Transaksi ({{ date('Y') }})</h4>
              <hr/>
              <canvas id="salesBarChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title mb-3">Grafik Pendapatan ({{ date('Y') }})</h4>
              <hr/>
              <canvas id="revenueBarChart"></canvas>
            </div>
          </div>
        </div>
    </div> 

    <div class="row mt-4">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Transaksi Terakhir</h4>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th> </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                  <tr>
                    <td class="font-weight-bold text-secondary">#{{ $order->order_no }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        {{ $order->customer->name ?? 'Guest' }}
                    </td>
                    <td class="font-weight-bold">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                      @if($order->status == 'completed')
                        <label class="badge badge-success">Selesai</label>
                      @elseif($order->status == 'pending')
                        <label class="badge badge-warning">Pending</label>
                      @elseif($order->status == 'delivered')
                        <label class="badge badge-info">Diantar</label>
                      @else
                        <label class="badge badge-danger">Batal</label>
                      @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-sm btn-outline-secondary icon-btn">
                            <i class="ion ion-eye"></i> Detail
                        </a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    </div>
    @include('partials.admin.footer')
</div>
@endsection