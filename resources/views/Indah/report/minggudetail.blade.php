@include('indah.layouts.header')
@include('indah.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        
            <div class="form-group">
                    <label>Arsip Vote 1 Minggu Periode Tanggal</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal" value="{{$tanggal}}"  placeholder="Pilih Tanggal"  readonly/>
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
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Rank</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>✔</th>
                            <th>❌</th>
                            <th>⭐</th>
                            
                        </tr>
                  </thead>
                  <tbody>
                  <?php $no=0;?>
                @foreach ($test2 as $key => $value)
                <?php $no++;?>
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{ $value['nik'] }}</td>
                        <td>{{ $value['nama'] }}</td>
                        <td>{{ $value['bagian'] }}</td>
                        <td>{{ $value['like'] }} </td>
                        <td>{{ $value['dislike'] }}</td>
                        <td>{{ $value['bintang'] }}</td>
                        
                    </tr>
                                    
                @endforeach  
                  </tbody>
                  <tfoot>
                        <tr>
                        <th>Rank</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>✔</th>
                            <th>❌</th>
                            <th>⭐</th>
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
  @include('indah.layouts.footer')
<script>
$(document).ready(function() {
    $('#example1').DataTable(
        {
             "pageLength": 25,
             "responsive": true, "lengthChange": true, "autoWidth": false,
             //"order": [[ 3, "desc" ]]
             "order": [[ 4, "desc" ], [ 5, "asc" ]],

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