@include('indah.layouts.header')
@include('indah.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Jadwal Piket Satgas</h3>
                            </div>
                            <div class="card-body">
                            <form action="{{ route('piket.update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('indah.jpiket.partials.form-edit',['submit' => 'Submit'])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('indah.layouts.footer')

<script>
$(document).ready(function() {
    $('.select1').select2({
        placeholder:"Select Petugas",
        theme: 'bootstrap4'
    });
});
$(document).ready(function() {
    $('.select2').select2({
        placeholder:"Select Petugas2",
        theme: 'bootstrap4'
    });
});
</script>