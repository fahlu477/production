
@include('Indah.layouts.header')
@include('Indah.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          @if(auth()->user()->role == 'SYS_ADMIN')
           <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3></h3>
                <p>Vote</p>
              </div>
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <a href="{{ route('indah.cari')}}" class="small-box-footer">Vote <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif

          @if(auth()->user()->role == 'SYS_ADMIN')
           <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3></h3>
                <p>Repot Votes</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <a href="{{ route('indah.report')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@include('Indah.layouts.footer')