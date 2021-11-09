@include('qc.rework.layouts.header')
<style>
	table, td, th {
  border: 1px solid black;
  text-align:center;
  font-size:13px;
  padding:3px;
  }
  table {
    border-collapse: collapse;
  }
			#box1{
				width:180px;
				height:180px;
        padding:10px;
        border: 2px solid grey;
				background:white;
			}
      #tabel{
				width:100%;
				height: auto;
        padding:10px;
        border: 2px solid grey;
				background:white;
			}
      #tab{
        width:100%;
				height: auto;
        border: 1px solid grey;
				background:white;
			}
      #tbl{
        width:100%;
				height: 200px;
        border: 1px solid grey;
				background:white;
			}
      h7 {
        text-decoration: overline;
      }
      input[type=text] {
        width: 100%;
      box-sizing: border-box;
      border: none;
      border-bottom: 2px solid black;
}
.dit {
  width: 180px;
  padding: 3px;
  border: 1px solid black;
  margin: 0;
}
.div3 {
  width: auto;
  height: auto;  
  padding: 5px;
  border: 1px solid black;
}
</style>
@include('qc.rework.layouts.navbar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="overflow:scroll;">
                                <center><h4>REPORT HARIAN QC REWORK</h4></center>
                                <center><h6>SEMUA PARBIK GISTEX</h6></center>
                                <center><h6>TANGGAL {{$tanggal_depan}}</h6></center>
                                <br>
                                <table style="width:1200px">
                                    <tr>
                                        <td style="font-weight:bold;">NO</td>
                                        <td style="font-weight:bold;">PABRIK</td>
                                        <td style="font-weight:bold;">LINE</td>
                                        <td style="font-weight:bold;">QTY REJECT</td>
                                        <td style="font-weight:bold;">CHECKED</td>
                                        <td style="font-weight:bold;">%</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="{{$jumlahLineCileunyi + 1}} " scope="row">1</td>
                                        <td rowspan="{{$jumlahLineCileunyi + 1}} ">CILEUNYI</td>
                                    </tr>
                                    @foreach($finalCLN as $dp)
                                    <tr>
                                        <td>{{$dp['line']}}</td>
                                        <td>{{$dp['tot_reject']}}</td>
                                        <td>{{$dp['tot_terpenuhi']}}</td>
                                        <td>{{$dp['p_reject']}} %</td>
                                    </tr>
                                    @endforeach
                                    @if($finalMAJA1 != null)
                                    <tr>
                                        <td rowspan="{{$jumlahLineMAJA1 + 1}}" scope="row">2</td>
                                        <td rowspan="{{$jumlahLineMAJA1 + 1}}">MAJALENGKA 1</td>
                                    </tr>
                                    @endif
                                    @if($finalMAJA1 != null)
                                      @foreach($finalMAJA1 as $dp)
                                      <tr>
                                          <td>{{$dp['line']}}</td>
                                          <td>{{$dp['tot_reject']}}</td>
                                          <td>{{$dp['tot_terpenuhi']}}</td>
                                          <td>{{$dp['p_reject']}} %</td>
                                      </tr>
                                      @endforeach
                                    @endif
                                    @if($finalMAJA2 != null)
                                    <tr>
                                        <td rowspan="{{$jumlahLineMAJA2 + 1}}" scope="row">3</td>
                                        <td rowspan="{{$jumlahLineMAJA2 + 1}}">MAJALENGKA 3</td>
                                    </tr>
                                    @endif
                                    @if($finalMAJA2 != null)
                                      @foreach($finalMAJA2 as $dp)
                                      <tr>
                                          <td>{{$dp['line']}}</td>
                                          <td>{{$dp['tot_reject']}}</td>
                                          <td>{{$dp['tot_terpenuhi']}}</td>
                                          <td>{{$dp['p_reject']}} %</td>
                                      </tr>
                                      @endforeach
                                    @endif
                                    <tr>
                                      <td colspan="3" style="background-color:#DCDCDC;">TOTAL</td>
                                      <td style="background-color:#DCDCDC;">{{$totalAllTerpenuhi}}</td>
                                      <td style="background-color:#DCDCDC;">{{$totalAllReject}}</td>
                                      <td style="background-color:#DCDCDC;">{{$totalAll_P_Reject}} %</td>
                                    </tr>
                                </table>
                                <br>
                                <h4>File</h4>
                                <div class="row">
                                  @if($fotoCLN != null)
                                  @foreach($fotoCLN as $fc)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$fc['file']) }}" data-toggle="lightbox" data-title="{{$fc['line']}}" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$fc['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endforeach
                                  @endif

                                  @if($fotoMAJA1 != null)
                                  @foreach($fotoMAJA1 as $fgm1)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$fgm1['file']) }}" data-toggle="lightbox" data-title="{{$fgm1['line']}}" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$fgm1['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endforeach
                                  @endif

                                  @if($fotoMAJA2 != null)
                                  @foreach($fotoMAJA2 as $fgm2)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$fgm2['file']) }}" data-toggle="lightbox" data-title="{{$fgm2['line']}}" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$fgm2['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endforeach
                                  @endif
                                </div>
                                <br>
                                <form action="{{ route('AllHarian.pdf')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                      <input type="hidden" name="tanggal" id="tanggal" value="{{$tanggal}}">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="far fa-file-pdf"></i> Download PDF</button> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
    </div>
<!-- /.Content Wrapper. Contains page content -->
@include('qc.rework.layouts.footer')
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
