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
                            <h3 class="card-title">Report Harian All Fasilitas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('get.AllHarian')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    @include('qc.rework.report.partials.form-Allharian', ['submit' => 'Get'])
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
$(document).ready(function() {
    $('.select3').select2({
        placeholder:"Select Branch",
        theme: 'bootstrap4'
    });
});
$(document).ready(function() {
    $('.select4').select2({
        placeholder:"Select Branch Detail",
        theme: 'bootstrap4'
    });
});
$('#reservationdate').datetimepicker({
    format: 'Y-MM-DD'
    });
</script>