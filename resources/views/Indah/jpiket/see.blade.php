@include('Indah.layouts.header')
@include('Indah.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-1">
            <a href="{{ route('satgas.create')}}" class="btn btn-block btn-info btn-sm"><i class="fas fa-plus"></i> Add New</a>
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
                <h3 class="card-title">Jadwal Piket</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            
                            <th>Hari</th>
                            <th>Petugas 1</th>
                            <th>Petugas 2</th>
                            <th>Petugas 3</th>
                            <th>Petugas 4</th>
                            <th>Petugas 5</th>
                            <th>Petugas 6</th>
                            <th>Petugas 7</th>
                            <th>Petugas 8</th>
                            <th>Petugas 9</th>
                            <th>Petugas 10</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                        <tr>
                           
                             <th>Hari</th>
                            <th>Petugas 1</th>
                            <th>Petugas 2</th>
                            <th>Petugas 3</th>
                            <th>Petugas 4</th>
                            <th>Petugas 5</th>
                            <th>Petugas 6</th>
                            <th>Petugas 7</th>
                            <th>Petugas 8</th>
                            <th>Petugas 9</th>
                            <th>Petugas 10</th>
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
@include('Indah.layouts.footer')
<script type="text/javascript">
  $(function () {
    var table = $('#example1').DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        processing: true,
        serverSide: true,
        ajax: "{{ route('Jindah.index') }}",
        columns: [
            
            {data: 'hari', name: 'hari', orderable: false},
            {data: 'petugas1', name: 'petugas1', orderable: false},
            {data: 'petugas2', name: 'petugas2', orderable: false},
            {data: 'petugas3', name: 'petugas3', orderable: false},
            {data: 'petugas4', name: 'petugas4', orderable: false},
            {data: 'petugas5', name: 'petugas5', orderable: false},
            {data: 'petugas6', name: 'petugas6', orderable: false},
            {data: 'petugas7', name: 'petugas7', orderable: false},
            {data: 'petugas8', name: 'petugas8', orderable: false},
            {data: 'petugas9', name: 'petugas9', orderable: false},
            {data: 'petugas10', name: 'petugas10', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  });
  $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example1 tfoot th').each( function () {
        var title = $('#example1 thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    });
 
    // DataTable
    var table = $('#example1').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            that
                .search( this.value )
                .draw();
        });
    });
  });
</script>