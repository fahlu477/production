 
@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
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
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_Admin' || auth()->user()->role == 'QCR_PIC' )
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>
                <p>Master WO</p>
              </div>
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <a href="{{ route('wo.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_Admin' || auth()->user()->role == 'QCR_PIC')
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>
                <p>Master Line</p>
              </div>
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <a href="{{ route('mline.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_Admin' || auth()->user()->role == 'QCR_OP' )
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>
                <p>Operator QC-Rework</p>
              </div>
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <a href="{{ route('rework.master')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_Admin' || auth()->user()->role == 'QCR_Report' || auth()->user()->role == 'QCR_SPV' || auth()->user()->role == 'QCR_PIC' )
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3></h3>
                <p>Report QC</p>
              </div>
              <div class="icon">
                <i class="fas fa-file"></i>
              </div>
              <a href="{{ route('rharian.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          @endif
          @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_SPV')
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>
                <p>SPV QC-Rework</p>
              </div>
              <div class="icon">
                <i class="fas fa-cogs"></i>
              </div>
              <a href="{{ route('spv.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
@include('qc.rework.layouts.footer')