@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">QC Rework Table</h3>
              </div>
              <div class="card-body">
              <a href="{{ route('detail.manual', $kerjakan->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Input Manual </a>
              <a href="{{ route('detail.auto', $kerjakan->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> Input Auto</a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@include('qc.rework.layouts.footer')