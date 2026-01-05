<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $pending_orders_count }}</h3>

          <p>Pending Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-help-circled"></i>
        </div>
        <a href="{{ route('admin.orders.index', ['filter' => 'pending']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $online_orders_count }}</h3>

          <p>Online Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-globe"></i>
        </div>
        <a href="{{ route('admin.orders.index', ['filter' => 'online']) }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>

          <p>Total Pendapatan</p>
        </div>
        <div class="icon">
          <i class="ion ion-cash"></i>
        </div>
        <a href="#" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $all_orders_count }}</h3>

          <p>All Orders</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
 