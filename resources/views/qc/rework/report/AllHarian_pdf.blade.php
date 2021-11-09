<!DOCTYPE html>
<html lang="en" style="overflow:scroll;">
<style>
	table, td, th {
  border: 1px solid black;
  text-align:center;
  font-size:9px;
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
.tables { display: table; width: 100%;}
.tables-row { display: table-row; }
.tables-cell { display: table-cell; padding: 1em; }
.page_break { page-break-before: always; }
</style>
</head>
    <body> 
        <center><font style="font-weight:bold;font-size:20px;">REPORT TAHUNAN QC REWORK</font></center>
        <center><font style="font-weight:bold;font-size:15px;">SEMUA PABRIK GISTEX</font></center>
        <center><font style="font-weight:bold;font-size:13px;">TANGGAL {{$tanggal_depan}}</font></center>
        <br>
        <table style="width:1260px">
            <tr>
                <td style="font-weight:bold;">NO</td>
                <td style="font-weight:bold;">PABRIK</td>
                <td style="font-weight:bold;">LINE</td>
                <td style="font-weight:bold;">QTY REJECT</td>
                <td style="font-weight:bold;">CHECKED</td>
                <td style="font-weight:bold;">%</td>
            </tr>
            <tr>
                <td rowspan="{{$jumlahLineCileunyi +1}}" scope="row">1</td>
                <td rowspan="{{$jumlahLineCileunyi +1}}">CILEUNYI</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td rowspan="{{$jumlahLineMAJA2 + 1}}">MAJALENGKA 2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
        @if($fotoCLN != null)
        @foreach($fotoCLN as $fc)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>{{$fc['line']}}</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$fc['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endforeach
        @endif

        @if($fotoMAJA1 != null)
        @foreach($fotoMAJA1 as $fgm1)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>{{$fgm1['line']}}</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$fgm1['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endforeach
        @endif

        @if($fotoMAJA2 != null)
        @foreach($fotoMAJA2 as $fgm2)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>{{$fgm2['line']}}</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$fgm2['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endforeach
        @endif
    </body>
</html>