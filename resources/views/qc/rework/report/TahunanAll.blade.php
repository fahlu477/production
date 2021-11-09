@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Report Tahunan All Fasilitas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('get.AllTahunan')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    @include('qc.rework.report.partials.form-Alltahunan', ['submit' => 'Get'])
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