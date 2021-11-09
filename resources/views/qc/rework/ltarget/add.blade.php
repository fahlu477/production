@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add Target Line</h3>
                            </div>
                            <div class="card-body">
                                @foreach($dataWo as $d)
                                <form action="{{ route('ltarget.store', $mline->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('qc.rework.ltarget.partials.form-control', ['submit' => 'Create'])
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('qc.rework.layouts.footer')
<script>
$(document).ready(function() {
    $('.select3').select2({
        placeholder:"Select Line",
        theme: 'bootstrap4'
    });
});
$(document).ready(function() {
    $('.select4').select2({
        placeholder:"Select Member",
        theme: 'bootstrap4'
    });
});
</script>