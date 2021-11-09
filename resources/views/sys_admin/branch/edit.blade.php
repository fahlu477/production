@include('layouts.header')
@include('layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Branch</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('branch.update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('sys_admin.branch.partials.form-edit', ['submit' => 'Save'])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('layouts.footer')