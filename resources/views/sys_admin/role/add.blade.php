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
                                <h3 class="card-title">Add New Role</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('role.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('sys_admin.role.partials.form-control', ['submit' => 'Create'])
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