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
                {{-- <form action="{{ route('harian.get') }}" method="post" enctype="multipart/form-data"> --}}

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
                            {{-- @php dd($avgAllDataPerLineAndDate,$sumAllDataPerLineAndDate, $pemenuhanRequest) @endphp --}}
                            <center><h1 style="font-weight:bold;font-size:20px;">PERFORMANCE PARAMETER</h1></center>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td style="font-weight:bold;">Date</td>
                                        <td style="font-weight:bold;">Qty Request</td>
                                        <td style="font-weight:bold;">Avr Respon Time (Min)</td>
                                        <td style="font-weight:bold;">Jml. Losstime </td>
                                        <td style="font-weight:bold;">Avr Delivery Time </td>
                                        <td style="font-weight:bold;">Total Waktu Delivery (Min)</td>
                                        <td style="font-weight:bold;">Qty Req/Day (Pc)</td>
                                        <td style="font-weight:bold;">Qty Aktual/Day (Pc)</td>
                                        <td style="font-weight:bold;">% Pemenuhan Request</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($stowers->groupBy('tanggal')->values() as $keyDate => $stowersByDate)
                                        @foreach($stowersByDate->sortBy('namaline')->groupBy('namaline')->values() as $keyName => $stowersByDateAndName)
                                        <tr>
                                        @if($keyName === 0)
                                            <td>{{ $stowersByDate->first()->tanggal }}</td>
                                            <td>{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalRequest'],1) }}</td>
                                            <td>{{ round($avgAllDataPerLineAndDate[$keyDate]['avgAvgResponTime'],2 )}}</td>
                                            <td>{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalLossTime'],2) }}</td>
                                            <td>{{ round($avgAllDataPerLineAndDate[$keyDate]['avgAvgDeliveryTime'],2) }}</td>
                                            <td>{{ round($avgAllDataPerLineAndDate[$keyDate]['avgTotalDeliveryTime'],2) }}</td>
                                            <td>{{ round($sumAllDataPerLineAndDate[$keyDate]['sumTotalRequestPerDay'],2) }}</td>
                                            <td>{{ ($sumAllDataPerLineAndDate[$keyDate]['sumTotalActualPerDay']) }}</td>
                                            <td>{{ round($pemenuhanRequest[$keyDate][$keyName],2) }} %</td>
                                        @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
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

<script>

$('#tanggal').datetimepicker({
    format: 'Y-MM-DD'
    });
</script>
@include('production.layouts.footer')
