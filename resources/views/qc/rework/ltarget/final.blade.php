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
              <div class="card-header">
                <h3 class="card-title">Final Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                        <tr>
                            <th>Kode_Line</th>
                            <th>Tgl_Pengerjaan</th>
                            <th>NO_WO</th>
                            <th>Order_quantity</th>
                            <th>Country</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Target_WO</th>
                            <th>Detail</th>
                            <th>SPV_APP</th>
                            <th>Tanggal_Input</th>
                            <th>Created_by</th>
                            <th>Edited_by</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                        <tr>
                            <th>Kode_Line</th>
                            <th>Tgl_Pengerjaan</th>
                            <th>NO_WO</th>
                            <th>Order_quantity</th>
                            <th>Country</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Target_WO</th>
                            <th>Detail</th>
                            <th>SPV_APP</th>
                            <th>Tanggal_Input</th>
                            <th>Created_by</th>
                            <th>Edited_by</th>
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
<script type="text/javascript">
  $(function () {
    var table = $('#example1').DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        processing: true,
        serverSide: true,
        ajax: "{{ route('ltarget.final') }}",
        columns: [
            {data: 'id_line', name: 'id_line'},
            {data: 'tgl_pengerjaan', name: 'tgl_pengerjaan'},
            {data: 'no_wo', name: 'no_wo'},
            {data: 'order_quantity', name: 'order_quantity'},
            {data: 'country', name: 'country'},
            {data: 'color', name: 'color'},
            {data: 'size', name: 'size'},
            {data: 'quantity', name: 'quantity'},
            {data: 'target_wo', name: 'target_wo'},
            {data: 'detail_id', name: 'detai_id'},
            {data: 'spv_app', name: 'spv_app'},
            {data: 'tgl_input', name: 'tgl_input'},
            {data: 'created_by', name: 'created_by'},
            {data: 'edited_by', name: 'edited_by'},
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