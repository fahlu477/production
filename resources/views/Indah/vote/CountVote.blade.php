@include('indah.layouts.header')
@include('indah.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-2">
            <div class="btn-group">
              <a href="" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>  Add New</a>
            </div>
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
                <h3 class="card-title">Report Kain</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>Like</th>
                            <th>DisLike</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Bagian</th>
                            <th>Like</th>
                            <th>DisLike</th>
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
<script type="text/javascript">
  $(function () {
    var table = $('#example1').DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        processing: true,
        serverSide: true,
        ajax: "{{ route('indah.countvote') }}",
        columns: [
            {data: 'nik', name: 'nik'},
            {data: 'nama', name: 'nama'},
            {data: 'bagian', name: 'bagian'},
            {data: 'like', name: 'like'},
            {data: 'dislike', name: 'dislike'},
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