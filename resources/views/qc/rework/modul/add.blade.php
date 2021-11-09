@include('rework.layouts.header')
@include('rework.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create New Modul</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('modul.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('rework.modul.partials.form-control', ['submit' => 'Create'])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('rework.layouts.footer')