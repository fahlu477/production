@include('production.layouts.header')
@include('production.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
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
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title">Report Signal Tower</h3>
                        </div>
                        <div class="card-body" style="overflow:auto">
						    <center><h1 style="text-align:center; font-weight:bold; font-size:20px;">REPORT SIGNAL TOWER CUTING KE SEWING</h1></center>
							<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td style="font-weight:bold;">Date</td>
                                        <td style="font-weight:bold;">Name Line</td>
                                        <td style="font-weight:bold;">Qty Request</td>
                                        <td style="font-weight:bold;">Avr Respon Time (Min)</td>
                                        <td style="font-weight:bold;">Jml. Losstime </td>
                                        <td style="font-weight:bold;">Avr Delivery Time </td>
                                        <td style="font-weight:bold;">Total Waktu Delivery (Min)</td>
                                        <td style="font-weight:bold;">Qty Req/Day (Pc)</td>
                                        <td style="font-weight:bold;">Qty Act/Day (Pc)</td>
							        </tr>
                                </thead>
                                
                                    @foreach($stowers->groupBy('tanggal')->values() as $keyDate => $stowersByDate)
                                    @foreach($stowersByDate->sortBy('namaline')->groupBy('namaline')->values() as $keyName => $stowersByDateAndName)
                                    {{-- @php dump($stowersByDate)@endphp --}}
                                            {{-- @foreach($stowersByDateAndName as $stower) --}}
                                            {{-- @php dump($stowersByDateAndName)@endphp --}}
                                            <tr>
                                                @if($keyName === 0)
                                                <td rowspan="{{$stowersByDate->groupBy('namaline')->count()+2}}">{{ $stowersByDateAndName->first()->tanggal }}</td>
                                                @endif
                                                <td>{{ $stowersByDateAndName->first()->namaline }}</td>
                                                <td>{{ $stowersByDateAndName->count() }}</td>
                                                <td>{{ round($rataRataResponTime[$keyDate][$keyName],2) }}</td>
                                                <td>{{ round($jumlahLosTime[$keyDate][$keyName],2) }}</td>
                                                <td>{{ round($rataRataDeliEndTime[$keyDate][$keyName],2) }}</td>
                                                <td>{{ round($totWaktuDeliveryTime[$keyDate][$keyName],2) }}</td>
                                                <td>{{ $jumlahTargetPerHari[$keyDate][$keyName] }}</td>
                                                <td>{{ $jumlahRemarkPerHari[$keyDate][$keyName] }}</td>
                                            </tr>
											{{-- @php dump($jumlahLosTime)@endphp --}}
                                            {{-- <td>{{$item['totwaktu']}}</td>
                                            <td >{{$item['target']}}</td> --}}
                                            {{-- @endforeach --}}
                                        @endforeach
                                        <tr>
                                            <td style="background-color:#DCDCDC;">TOTAL ALL LINE</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalRequest'],1) }}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumResponTime'],2 )}}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalLossTime'],2) }}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumDeliveryTime'],2) }}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalDeliveryTime'],2) }}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalRequestPerDay'],2) }}</td>
                                            <td style="background-color:#DCDCDC;">{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalActualPerDay'],2) }}</td>
                                        </tr>
    
                                        <tr>
                                            <td style="background-color:#d0eef7;">AVERAGE ALL LINE</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalRequest'],1) }}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgAvgResponTime'],2 )}}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalLossTime'],2) }}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgAvgDeliveryTime'],2) }}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalDeliveryTime'],2) }}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalRequestPerDay'],2) }}</td>
                                            <td style="background-color:#d0eef7;">{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalActualPerDay'],2) }}</td>
                                        </tr>
                                      @endforeach
                                            {{-- @php dd(1111)@endphp --}}
                                </tbody>
                            </table>
                        </div>
                    <!-- /.card-body -->
                    </div>
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
