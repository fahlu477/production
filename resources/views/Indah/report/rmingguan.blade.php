@include('indah.layouts.header')
@include('indah.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
      

            <div class="btn-group">
            <form action="{{ route('indah.harian')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                <label>Tanggal Vote</label>
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal"  placeholder="Pilih Tanggal"  required/>
          
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Arsip Harian</button>
              </div>
            </form>
            </div>


            <div class="btn-group">
            <form action="{{ route('indah.Mdetail')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                <label>Vote Per Minggu</label>
                <div class="input-group date" id="reservationdate4" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate4" name="tanggal" value="{{$tanggal}}" placeholder="Pilih Tanggal"  required/>
          
                    <div class="input-group-append" data-target="#reservationdate4" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-info btn-sm">Show Detail</button>
               
              </div>
            </form>
            </div>


            <div class="btn-group">
            <form action="{{ route('indah.bulanan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                <label>Bulan Vote</label>
                <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" name="bulan" required
                    placeholder="Pilih bulan" />
          
                    <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Arsip Bulanan</button>
              </div>
            </form>
            </div>

            <div class="btn-group">
            <form action="{{ route('indah.tahunan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                <label>Tahun Vote</label>
                <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" name="tahun" placeholder="Pilih tahun" required/>
          
                    <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Arsip Tahunan</button>
              </div>
            </form>
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
            <h3 class="card-title">Report Vote</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Rank</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>✔</th>
                            
                        </tr>
                  </thead>
                  <tbody>
                <?php $no=0;?>
                @foreach ($test1 as $key => $value)
                <?php $no++;?>
                    <tr>
                         <td>{{$no}}</td>
                        <td>{{ $value['nik'] }}</td>
                        <td>{{ $value['nama'] }}</td>
                        <td>{{ $value['bagian'] }}</td>
                        <td>{{ $value['like'] }} {{ $value['bintang'] }}</td>
                        
                    </tr>
                                    
                @endforeach  
                  </tbody>

                  <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            
                        </tr>
                  </thead>
                  <tbody>
                  <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            
                        </tr>
                  </thead>
                  <tbody>

                  <thead>
                        <tr>
                            <th>Rank</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>❌</th>
                            
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
                        <td>{{ $value['dislike'] }}</td>
                        
                    </tr>
                                    
                @endforeach  
                  </tbody>
                  
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



  </div>
  @include('indah.layouts.footer')
<script>
$(document).ready(function() {
    $('#example1').DataTable(
        {
             "pageLength": 5,
             "responsive": true, "lengthChange": true, "autoWidth": false,
             "order": [[ 3, "desc" ]]
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
    
} );


//datatable 2
$(document).ready(function() {
    $('#example2').DataTable(
        {
             "pageLength": 5,
             "responsive": true, "lengthChange": true, "autoWidth": false,
             "order": [[ 3, "desc" ]]
        } 
    );
} );
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example2 tfoot th').each( function () {
        var title = $('#example2 thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" style="height:2em;" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example2').DataTable();
 
    // Apply the search
} );

$('#reservationdate').datetimepicker({
    format: 'Y-MM-DD'
    });
    $('#reservationdate1').datetimepicker({
    format: 'Y-MM'
    });
    $('#reservationdate2').datetimepicker({
    format: 'Y'
    });
    $('#reservationdate4').datetimepicker({
    format: 'Y-MM-DD'
    });
</script>