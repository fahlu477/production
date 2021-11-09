@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <a href="{{ route('report.done', $line->id)}}" class="btn btn-block btn-info btn-sm"><i class="fas fa-paste"></i> Final Report</a>
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
                <h3 class="card-title">Target Line Table [ {{$line->string1}} ]</h3>
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
                            <th>Detail</th>
                            <th>SPV_APP</th>
                        </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $dt)
                    <tr>
                      <td>{{$dt['tgl_pengerjaan']}}</td>
                      <td>{{$dt['tgl_pengerjaan2']}}</td>
                      <td>{{$dt['no_wo']}}</td>
                      <td>{{$dt['order_quantity']}}</td>
                      <td><a href="{{ route('spv.show', $dt['id'])}}" class="btn btn-info btn-sm" title="Show Report"><i class="far fa-eye"></i></a></td>
                      @if($dt['spv_app'] == 0)
                      <td>
                        <form class="form-horizontal row-fluid" action="{{route('spv.approve')}}" method="post">
                                @csrf
                                <input type="hidden" id="id" class="span10" name="id" value="{{ $dt['id'] }}">
                                <input type="hidden" id="spv_app" class="span10" name="spv_app" value="1">
                                <input type="hidden" id="spv_name" class="span10" name="spv_name" value="{{ Auth::user()->nama }}">
                                <button type="submit"  class="btn btn-primary btn-sm" title="OK?"><i class="far fa-check-square"></i></button>
                        </form>
                      </td>
                      @elseif($dt['spv_app'] == 1)
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
                            <th>Detail</th>
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