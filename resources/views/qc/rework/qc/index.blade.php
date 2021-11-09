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
                <h3 class="card-title">QC Rework Table</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Kode Line</th>
                            <th>Nama Line</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                    @foreach($dataLuser as $p)
                    @if(Auth::user()->nik == $p['anggota'])
                    <tr>
                      <td>{{$p['line']}}</td>
                      <td>{{$p['nama_line']}}</td>
                      @if(Auth::user()->nik == $p['anggota'])
                      <td>
                        <div class="btn-group">
                          <a href="{{ route('rework.take', $p['id_line'])}}" class="btn btn-primary btn-sm ">
                            <i class="fas fa-edit"></i> Masuk
                          </a>
                        </div>
                      </td>
                      @else
                      <td></td>
                      @endif
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>Kode Line</th>
                            <th>Nama Line</th>
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
             "pageLength": 25
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