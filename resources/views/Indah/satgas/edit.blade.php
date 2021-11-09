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
                                <h3 class="card-title">Edit Kuota VOTE Satgas</h3>
                            </div>
                            <div class="card-body">
                            <form action="{{ route('satgas.update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('indah.satgas.partials.form-edit',['submit' => 'Submit'])
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