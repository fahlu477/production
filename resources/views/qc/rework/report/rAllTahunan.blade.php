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
                                <center><h4>REPORT TAHUNAN QC REWORK</h4></center>
                                <center><h6>SEMUA PABRIK GISTEX</H6></CENTER>
                                <center><h6>TAHUN {{$tahun}} </h6></center>
                                <br>
                                <table style="width:1200px">
                                    <tr>
                                        <td style="font-weight:bold;">NO</td>
                                        <td style="font-weight:bold;padding:15px">BULAN</td>
                                        <td style="font-weight:bold;"></td>
                                        <td style="font-weight:bold;">CILEUNYI</td>
                                        <td style="font-weight:bold;">MAJALENGKA 1</td>
                                        <td style="font-weight:bold;">MAJALENGKA 2</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>1</td>
                                        <td rowspan='2'>Jan</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['janReject'] }}</td>
                                        <td>{{ $FinalDataGM1['janReject'] }}</td>
                                        <td>{{ $FinalDataGM2['janReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['janCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['janGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['janGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>2</td>
                                        <td rowspan='2'>Feb</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['febReject'] }}</td>
                                        <td>{{ $FinalDataGM1['febReject'] }}</td>
                                        <td>{{ $FinalDataGM2['febReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['febCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['febGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['febGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>3</td>
                                        <td rowspan='2'>Mar</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['marReject'] }}</td>
                                        <td>{{ $FinalDataGM1['marReject'] }}</td>
                                        <td>{{ $FinalDataGM2['marReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['marCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['marGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['marGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>4</td>
                                        <td rowspan='2'>Apr</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['aprReject'] }}</td>
                                        <td>{{ $FinalDataGM1['aprReject'] }}</td>
                                        <td>{{ $FinalDataGM2['aprReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['aprCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['aprGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['aprGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>5</td>
                                        <td rowspan='2'>Mei</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['meiReject'] }}</td>
                                        <td>{{ $FinalDataGM1['meiReject'] }}</td>
                                        <td>{{ $FinalDataGM2['meiReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['meiCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['meiGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['meiGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>6</td>
                                        <td rowspan='2'>Jun</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['junReject'] }}</td>
                                        <td>{{ $FinalDataGM1['junReject'] }}</td>
                                        <td>{{ $FinalDataGM2['junReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['junCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['junGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['junGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>7</td>
                                        <td rowspan='2'>Jul</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['julReject'] }}</td>
                                        <td>{{ $FinalDataGM1['julReject'] }}</td>
                                        <td>{{ $FinalDataGM2['julReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['julCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['julGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['julGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>8</td>
                                        <td rowspan='2'>Ags</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['agsReject'] }}</td>
                                        <td>{{ $FinalDataGM1['agsReject'] }}</td>
                                        <td>{{ $FinalDataGM2['agsReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['agsCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['agsGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['agsGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>9</td>
                                        <td rowspan='2'>Sep</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['sepReject'] }}</td>
                                        <td>{{ $FinalDataGM1['sepReject'] }}</td>
                                        <td>{{ $FinalDataGM2['sepReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['sepCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['sepGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['sepGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>10</td>
                                        <td rowspan='2'>Okt</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['oktReject'] }}</td>
                                        <td>{{ $FinalDataGM1['oktReject'] }}</td>
                                        <td>{{ $FinalDataGM2['oktReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['oktCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['oktGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['oktGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>11</td>
                                        <td rowspan='2'>Nov</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['novReject'] }}</td>
                                        <td>{{ $FinalDataGM1['novReject'] }}</td>
                                        <td>{{ $FinalDataGM2['novReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['novCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['novGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['novGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td rowspan='2'>12</td>
                                        <td rowspan='2'>Des</td>
                                        <td>Qty</td>
                                        <td>{{ $FinalDataCLN['desReject'] }}</td>
                                        <td>{{ $FinalDataGM1['desReject'] }}</td>
                                        <td>{{ $FinalDataGM2['desReject'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>%</td>
                                        <td>{{ $FinalDataCLN['desCLNTOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM1['desGM1TOTReject'] }} %</td>
                                        <td>{{ $FinalDataGM2['desGM2TOTReject'] }} %</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" rowspan="2" style="background-color:#C0C0C0;">TOTAL ALL LINE</td>
                                        <td style="background-color:#C0C0C0;">Qty</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataCLN['totalRejectCLN'] }}</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataGM1['totalRejectGM1'] }}</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataGM2['totalRejectGM2'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#C0C0C0;">%</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataCLN['totalTOTCLN'] }}  %</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataGM1['totalTOTGM1'] }}  %</td>
                                        <td style="background-color:#C0C0C0;">{{ $FinalDataGM2['totalTOTGM2'] }}  %</td>
                                    </tr>
                                </table>
                                <br>
                                <h4>File</h4>
                                <div class="row">
                                  @if($FinalFotoCLN['file'] != null)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$FinalFotoCLN['file']) }}" data-toggle="lightbox" data-title="Agustus" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$FinalFotoCLN['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endif
                                  @if($FinalFotoGM1['file'] != null)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$FinalFotoGM1['file']) }}" data-toggle="lightbox" data-title="Agustus" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$FinalFotoGM1['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endif
                                  @if($FinalFotoGM2['file'] != null)
                                  <div class="div3 col-sm-2">
                                    <a href="{{ url('/rework/qc/images/'.$FinalFotoGM2['file']) }}" data-toggle="lightbox" data-title="Agustus" data-gallery="gallery">
                                      <img src="{{ url('/rework/qc/images/'.$FinalFotoGM2['file']) }}" class="img-fluid mb-2" alt="white sample"/>
                                    </a>
                                  </div>
                                  @endif
                                </div>
                                <br>
                                <form action="{{ route('AllTahunan.pdf')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                      <input type="hidden" name="tahun" id="tahun" value="{{$tahun}}">
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
