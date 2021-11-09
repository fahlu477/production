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
                <a class="dropdown-item" href="{{ route('wo.excel')}}">PDF</a>
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
                    <div class="container"  style="vertical-align : middle;text-align:center;" >
                        <h4 > REPORT RESUME SIGNAL TOWER CUTTING-SEWING</h4>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Performance Parameter</th>
                                <th scope="col">LINE 1</th>
                                <th scope="col">LINE 2</th>
                                <th scope="col">LINE 3</th>
                                <th scope="col">LINE 4</th>
                                <th scope="col">LINE 5</th>
                                <th scope="col">LINE 6</th>
                                <th scope="col">LINE 7</th>
                                <th scope="col">TOTAL</th>
                              </tr>

                              @foreach($d as $item)
                              <tr >
                                <th scope="col"  rowspan="8" style="vertical-align : middle;text-align:center;" > {{$item['date']}}</th>
                                <tr>
                                      <td>Frequensi request</td>
                                      <td>{{$item['line1']}}</td>
                                      <td>{{$item['line2']}}</td>
                                      <td>{{$item['line3']}}</td>
                                      <td>{{$item['line4']}}</td>
                                      <td>{{$item['line5']}}</td>
                                      <td>{{$item['line6']}}</td>
                                      <td>{{$item['line7']}}</td>
                                      <td>{{$item['totalwaktu']}}</td>

                                  </tr>
                                  <tr>
                                      <td>Perf. Respon Time (Avg / Min)</td>
                                      <td> </td>
                                      <td>{{$item['getline2']}}</td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> {{$item['totalresline']}}</td>
                                  </tr>
                                  <tr>
                                      <td>Freq. Losstime</td>
                                      <td>{{$item['totallostim']}}</td>
                                      <td>{{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                      <td> {{$item['totallostim']}}</td>
                                  </tr>
                                  <tr>
                                      <td>Perf.Losstime  (Avg / Min)</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                      <td> {{$item['totallost_time']}}</td>
                                  </tr>
                                  <tr>
                                      <td>Perf. Waktu Delivery  (Avg / Min)</td>
                                      <td> </td>
                                      <td></td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> {{$item['totaldeli']}}</td>
                                  </tr>
                                  <tr>
                                      <td>Perf. Total Waktu  (Avg / Min)</td>
                                      <td> </td>
                                      <td>{{$item['deliline2']}}</td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td> </td>
                                      <td></td>
                                      <td> {{$item['totwaktu']}}</td>
                                  </tr>
                                  <tr>
                                      <td>Qty Req/Day</td>
                                      <td> {{$item['Targetline1']}}</td>
                                      <td> {{$item['Targetline2']}}</td>
                                      <td> {{$item['Targetline3']}}</td>
                                      <td> {{$item['Targetline4']}}</td>
                                      <td> {{$item['Targetline5']}}</td>
                                      <td> {{$item['Targetline6']}}</td>
                                      <td> {{$item['Targetline7']}}</td>
                                      <td> {{$item['totaltarget']}}</td>
                                  </tr>
@endforeach
                              </thead>
                            </table>
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
