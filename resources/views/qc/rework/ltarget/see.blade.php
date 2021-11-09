@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-1">
            <a href="{{ route('mline.index')}}" class="btn btn-block btn-primary btn-sm"><i class="fas fa-home"></i> Index </a>
          </div>
          <div class="col-sm-1">
            <a href="{{ route('ltarget.search', $line->id)}}" class="btn btn-block btn-info btn-sm"><i class="fas fa-plus"></i> Target</a>
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
              <div class="card-header">
                <h3 class="card-title">Target Table [ {{$line->string1}} ]</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Pengerjaan_Awal</th>
                            <th>Pengerjaan_Akhir</th>
                            <th>NO_WO</th>
                            <th>Order_quantity</th>
                            <th>Target_WO</th>
                            <th>Terpenuhi</th>
                            <th>Proses</th>
                            <th>Action_List</th>
                            <th>SPV_APP</th>
                        </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $d)
                  <tr>
                    <td>{{$d['tgl_pengerjaan']}}</td>
                    <td>{{$d['tgl_pengerjaan2']}}</td>
                    <td>{{$d['no_wo']}}</td>
                    <td>{{$d['order_quantity']}}</td>
                    <td>{{$d['target_wo']}}</td>
                    <td>{{$d['target_terpenuhi']}}</td>
                    @if($d['proses'] == 0)
                    <td>
                      <a href="" class="btn btn-secondary btn-sm" title="Belum Dikerjakan"><i class="fas fa-spinner"></i></a>
                    </td>
                    @elseif($d['proses'] == 1)
                    <td>
                      <a href="" class="btn btn-info btn-sm" title="Sedang Dikerjakan"><i class="fas fa-chalkboard-teacher"></i></a>
                    </td>
                    @elseif($d['proses'] == 2)
                    <td>
                      <a href="" class="btn btn-success btn-sm" title="Selesai"><i class="far fa-check-circle"></i></a>
                    </td>
                    @endif
                    <td>
                      @if($d['proses'] == 0)
                      <a href="{{ route('ltarget.edit', $d['id'])}}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                      @endif
                      @if($d['target_terpenuhi'] == 0)
                      <a href="{{ route('ltarget.delete', $d['id'])}}" class="btn btn-danger btn-sm" title="Delete"><i class="far fa-trash-alt"></i></a>
                      @endif
                        <a href="{{ route('ltarget.summary', $d['id'])}}" class="btn btn-warning btn-sm" title="History"><i class="fas fa-star"></i></i></a>
                    </td>
                    @if($d['spv_app'] == 0)
                    <td>
                      <a href="" class="btn btn-secondary btn-sm" title="Waiting"><i class="fas fa-spinner"></i></a>
                    </td>
                    @elseif($d['spv_app'] == 1)
                    <td>
                      <a href="" class="btn btn-success btn-sm" title="Reviewed"><i class="fas fa-user-check"></i></a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>Pengerjaan_Awal</th>
                            <th>Pengerjaan_Akhir</th>
                            <th>NO_WO</th>
                            <th>Order_quantity</th>
                            <th>Target_WO</th>
                            <th>Terpenuhi</th>
                            <th>Proses</th>
                            <th>Action_List</th>
                            <th>SPV_APP</th>
                        </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
    $('#example1').DataTable(
        {
             "pageLength": 25,
             "responsive": true, "lengthChange": true, "autoWidth": false,
             "order": [[ 0, "desc" ]]
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
</script>