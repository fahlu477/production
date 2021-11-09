@include('qc.rework.layouts.header')
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <a href="{{ route('ltarget.see', $target->id_line)}}" class="btn btn-info btn-sm col-2"><i class="fas fa-home"></i> Index</a>
        <a href="{{ route('ltarget.tambah', $target->id)}}" class="btn btn-primary btn-sm" title="Tambah Hari"><i class="fas fa-plus-circle"></i> Tambah Hari</a>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">NO WO [ {{$target->no_wo}} ]</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Target_WO</th>
                            <th>Target_Terpenuhi</th>
                            <th>Sisa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1;?>
                    @foreach($data as $dt)
                        <tr>
                            <td  scope="row">{{ $no }}</td>
                            <td>{{$dt['tgl_pengerjaan']}}</td>
                            <td>{{$dt['target_wo']}}</td>
                            <td>{{$dt['target_terpenuhi']}}</td>
                            <td>{{$dt['sisa']}}</td>
                            <td><a href="{{ route('summary.detail', $dt['detail_id'])}}" class="btn btn-info btn-sm" title="Detail"><i class="far fa-eye"></i></a></td>
                        </tr>
                    <?php $no++ ;?>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Target_WO</th>
                            <th>Target_Terpenuhi</th>
                            <th>Sisa</th>
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