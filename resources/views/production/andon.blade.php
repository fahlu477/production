@include('production.layouts.header')
@include('production.layouts.navbar')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid" >
        <div class="row mb-2">
          <div class="col-sm-2">
            <div class="btn-group">
              <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-download"></i>  Export</button>
              <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="{{ route('wo.excel')}}">excel</a>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class=".col-sm-*">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <a href="{{ route('production.reporttower') }}" class="btn btn-md btn-success mb-3">REKAPITULASI DATA</a>
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">date</th>
                                <th scope="col">Nama Line</th>
                                <th scope="col">Request Line</th>
                                <th scope="col">Respond Line</th>
                                <th scope="col">Lost Time</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Proses end</th>
                                <th scope="col">Delivere</th>
                                <th scope="col">Deliveri End</th>
                                <th scope="col">Total Waktu</th>
                                <th scope="col">Total Waktu Berakhir</th>
                                <th scope="col">PIC</th>
                                <th scope="col">Buyer</th>
                                <th scope="col">Style</th>
                                <th scope="col">WO</th>
                                <th scope="col">Size</th>
                                <th scope="col">Color</th>
                                <th scope="col">Target perhari</th>
                                <th scope="col">Remark</th>

                              </tr>
                              @foreach($data as $item)
                              <tr>
                                  <td>{{$item['id']}}</td>
                                  <td>{{$item['date']}}</td>
                                  <td>{{$item['namaline']}}</td>
                                  <td>{{$item['reqlin']}}</td>
                                  <td>{{$item['resline']}}</td>
                                  <td>{{$item['lostim']}}</td>
                                  <td>{{$item['proses']}}</td>
                                  <td>{{$item['prosesend']}}</td>
                                  <td>{{$item['deli']}}</td>
                                  <td>{{$item['deliend']}}</td>
                                  <td>{{$item['totwaktu']}}</td>
                                  <td>{{$item['T_Lost_Time']}}</td>
                                  <td>{{$item['PIC']}}</td>
                                  <td>{{$item['buyer']}}</td>
                                  <td>{{$item['style']}}</td>
                                  <td>{{$item['wo']}}</td>
                                  <td>{{$item['size']}}</td>
                                  <td>{{$item['color']}}</td>
                                  <td>{{$item['target_perday']}}</td>
                                  <td>{{$item['Remark']}}</td>
                              </tr>
                              @endforeach
                            </thead>
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
  @include('production.layouts.footer')
                 
  