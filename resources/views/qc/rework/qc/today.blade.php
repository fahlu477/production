@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">Tugas Hari Ini [ {{$kode_line}} ]</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Tgl_Awal</th>
                            <th>Tgl_Akhir</th>
                            <th>No_WO</th>
                            <th>Order_Quan</th>
                            <th>Target_WO</th>
                            <th>Proses</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                    @foreach($dataTarget as $dg)
                    <tr>
                      <td>{{$dg['tgl_pengerjaan']}}</td>
                      @if($dg['tgl_pengerjaan2'] != null)
                      <td>{{$dg['tgl_pengerjaan2']}}</td>
                      @endif
                      @if($dg['tgl_pengerjaan3'] != null)
                      <td>{{$dg['tgl_pengerjaan3']}}</td>
                      @endif
                      <td>{{$dg['no_wo']}}</td>
                      <td>{{$dg['order_quantity']}}</td>
                      <td>{{$dg['target_wo']}}</td>
                      @if($dg['proses'] == 0)
                      <td><a href="" class="btn btn-secondary btn-sm" title="Belum Dikerjakan"><i class="fas fa-spinner"></i></a></td>
                      @elseif($dg['proses'] == 1)
                      <td><a href="" class="btn btn-warning btn-sm" title="Belum Selesai"><i class="fas fa-exclamation-circle"></i></a></td>
                      @elseif($dg['proses'] == 2)
                      <td><a href="" class="btn btn-success btn-sm" title="Selesai"><i class="far fa-check-circle"></i></a></td>
                      @endif
                      @if($dg['proses'] == 0)
                      <td>
                        <form action="{{ route('rework.kerjakan', $dg['id'])}}" method="post">
                        @csrf
                            <input type="hidden" id="id" name="id" value="{{$dg['id']}}">
                            <input type="hidden" id="target_id" name="target_id" value="{{$dg['id']}}">
                            <input type="hidden" id="tgl_pengerjaan" name="tgl_pengerjaan" value="{{$dg['tgl_pengerjaan']}}">
                            <input type="hidden" id="no_wo" name="no_wo" value="{{$dg['no_wo']}}">
                            <input type="hidden" id="id_line" name="id_line" value="{{$dg['line']}}">
                            <input type="hidden" id="target_wo" name="target_wo" value="{{$dg['target_wo']}}">
                            <input type="hidden" id="proses" name="proses" value="1">
                            <button type="submit" class="btn btn-primary btn-sm" title="Kerjakan"><i class="fas fa-edit"></i></a></button>
                        </form>
                      </td>
                      @elseif($dg['proses'] == 1)
                      <td><a href="{{ route('rework.lanjutkan', $dg['id'])}}" class="btn btn-info btn-sm" title="Lanjutkan"><i class="fas fa-chalkboard-teacher"></i></a></td>
                      @elseif($dg['proses'] == 2)
                      <td><a href="{{ route('ltarget.show', $dg['id'])}}" class="btn btn-info btn-sm" title="Selesai"><i class="far fa-eye"></i></a></td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>Tgl_Awal</th>
                            <th>Tgl_Akhir</th>
                            <th>No_WO</th>
                            <th>Order_Quan</th>
                            <th>Target_WO</th>
                            <th>Proses</th>
                            <th>Action</th>
                        </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">History [ {{$kode_line}} ]</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Tgl_Awal</th>
                            <th>Tgl_Akhir</th>
                            <th>No_WO</th>
                            <th>Order_Quantity</th>
                            <th>Target_WO</th>
                            <th>Proses</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                  @foreach($dataHistory as $dg)
                    <tr>
                      <td>{{$dg['tgl_pengerjaan']}}</td>
                      <td>{{$dg['tgl_pengerjaan2']}}</td>
                      <td>{{$dg['no_wo']}}</td>
                      <td>{{$dg['order_quantity']}}</td>
                      <td>{{$dg['target_wo']}}</td>
                      @if($dg['proses'] == 0)
                      <td><a href="" class="btn btn-secondary btn-sm" title="Belum Dikerjakan"><i class="fas fa-spinner"></i></a></td>
                      @elseif($dg['proses'] == 1)
                      <td><a href="" class="btn btn-info btn-sm" title="Belum Selesai"><i class="fas fa-chalkboard-teacher"></i></a></td>
                      @elseif($dg['proses'] == 2)
                      <td><a href="" class="btn btn-success btn-sm" title="Selesai"><i class="far fa-check-circle"></i></a></td>
                      @endif
                      @if($dg['proses'] == 1)
                      <td><a href="" class="btn btn-info btn-sm" title="Lanjutkan"><i class="fas fa-chalkboard-teacher"></i></a></td>
                      @elseif($dg['proses'] == 2)
                      <td><a href="{{ route('ltarget.show', $dg['id'])}}" class="btn btn-info btn-sm" title="Selesai"><i class="far fa-eye"></i></a></td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>Tgl_Awal</th>
                            <th>Tgl_Akhir</th>
                            <th>No_WO</th>
                            <th>Order_Quantity</th>
                            <th>Target_WO</th>
                            <th>Proses</th>
                            <th>Action</th>
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