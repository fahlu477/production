@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <a href="{{ route('all.tahunan')}}" class="btn btn-block btn-info btn-sm"><i class="fas fa-book"></i>  Report Tahunan All Fasilitas</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">Report Tahunan</h3>
              </div>
              <div class="card-body">
                <form action="{{route('rtahunan.get')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        @include('qc.rework.report.partials.form-tahunan', ['submit' => 'Get'])
                </form>
              </div>
              <!-- /.card-body -->
            </div>
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
<script>
    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'Y'
    });
</script>