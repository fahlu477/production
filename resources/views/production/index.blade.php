
@include('production.layouts.header')
@include('production.layouts.navbar')
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
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_OP' ||
          auth()->user()->role == 'QCR_Report' || auth()->user()->role == 'QCR_PIC' || auth()->user()->role == 'QCR_Admin'
          || auth()->user()->role == 'QCR_SPV')
           <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3></h3>
                <p>Tower Signal Report</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
              <a href="{{ route('production.andon')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
        </div>
      </div><!-- /.container-fluid -->
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 


  </div>
  <!-- /.content-wrapper -->
@include('production.layouts.footer')