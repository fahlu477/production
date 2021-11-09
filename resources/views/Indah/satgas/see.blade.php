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
                <h3 class="card-title">Satgas Vote</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kuota ✔</th>
                            <th>Kuota ❌</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                        <tr>
                           
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kuota </th>
                            <th>Kuota </th>
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
        ajax: "{{ route('Pindah.index') }}",
        columns: [
            
            {data: 'nama', name: 'nama'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'kuota_like', name: 'kuota_like'},
            {data: 'kuota_dislike', name: 'kuota_dislike'},
           // {data: 'a', name: 'a'},
            //{data: 'nik', name: 'nik'},
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