@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row mb-2" style="padding:10px">
                <div class="col-sm-1">
                    <a href="{{ route('mline.index')}}" class="btn btn-block btn-secondary btn-sm"><i class="fas fa-home"></i> Index</a>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if($person != 2)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">ADD NEW USER TO LINE {{$mline->string1}}</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('luser.store', $mline->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        @include('qc.rework.luser.partials.form-control', ['submit' => 'Create'])
                                </form>
                            </div>
                        </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Line User Table {{$mline->string1}}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                        <tr>
                                            <th>Kode Line</th>
                                            <th>Member</th>
                                            <th>Pabrik</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataLuser as $p)
                                    @if($p['branch'] == Auth::user()->branch && $p['branch_detail'] == Auth::user()->branchdetail )
                                    <tr>
                                    <td>{{$p['line']}}</td>
                                    @foreach($member as $m)
                                        @if($m->nik == $p['anggota'])
                                        <td>{{$m->nama}}</td>
                                        @endif
                                    @endforeach
                                    @if($p['branch'] == 'CLN' && $p['branch_detail'] == 'CLN')
                                    <td>Gistex Cileunyi</td> 
                                    @elseif($p['branch'] == 'MAJA' && $p['branch_detail'] == 'GM1')
                                    <td>Gistex Majalengka 1</td> 
                                    @elseif($p['branch'] == 'MAJA' && $p['branch_detail'] == 'GM2')
                                    <td>Gistex Majalengka 2</td> 
                                    @elseif($p['branch'] == 'GS' && $p['branch_detail'] == 'GS')
                                    <td>Gistex Solo</td> 
                                    @elseif($p['branch'] == 'GK' && $p['branch_detail'] == 'GK')
                                    <td>Gistex Kalibenda</td> 
                                    @elseif($p['branch'] == 'WG' && $p['branch_detail'] == 'WG')
                                    <td>Gistex Wonogiri</td> 
                                    @elseif($p['branch'] == 'GB' && $p['branch_detail'] == 'GB')
                                    <td>Gistex Banjarnegara</td> 
                                    @elseif($p['branch'] == 'GC' && $p['branch_detail'] == 'GC')
                                    <td>Gistex Cawan</td> 
                                    @endif
                                    <td>{{$p['created']}}</td>
                                    <td>
                                        <div class="btn-group">
                                        <a href="{{ route('luser.delete', $p['id'])}}" class="btn btn-danger btn-sm ">
                                            <i class="far fa-trash-alt"></i> Hapus
                                        </a>
                                        </div>
                                    </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                        <tr>
                                            <th>Kode Line</th>
                                            <th>Member</th>
                                            <th>Pabrik</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('qc.rework.layouts.footer')
<script>
$(document).ready(function() {
    $('#example1').DataTable(
        {
             "pageLength": 25,
             "responsive": true, "lengthChange": true, "autoWidth": false,
        } 
    );
} );
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 tfoot th').each( function () {
        var title = $('#example1 thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" style="height:2em;" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example1').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            that
                .search( this.value )
                .draw();
        } );
    } );
} );
$('.select2bs4').select2({
      theme: 'bootstrap4'
    })
</script>