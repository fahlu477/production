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
        <center><font style="font-weight:bold;font-size:20px;">REPORT BULANAN QC REWORK</font></center>
        <center><font style="font-weight:bold;font-size:15px;">PABRIK : {{$dataBranch->nama_branch}}</font></center>
        <center><font style="font-weight:bold;font-size:13px;">BULAN {{$kodeBulan}}</font></center>
        <br>
        <table style="width:1260px">
            <tr>
                <td rowspan="2" style="font-weight:bold;">NO</td>
                <td rowspan="2" style="font-weight:bold;padding:15px">TANGGAL</td>
                <td rowspan="2" style="font-weight:bold;"></td>
                <td rowspan="2" style="font-weight:bold;">FINISH GOOD</td>
                <td colspan="6" style="font-weight:bold;">STITCHING</td>
                <td colspan="3" style="font-weight:bold;">ATTACHMENT</td>
                <td colspan="6" style="font-weight:bold;">APPERANCE</td>
                <td rowspan="2" style="font-weight:bold;">STICKER</td>
                <td rowspan="2" style="font-weight:bold;">TRIMMING</td>
                <td rowspan="2" style="font-weight:bold;">IRON PROBLEM</td>
                <td rowspan="2" style="font-weight:bold;padding:13px">MEAS</td>
                <td rowspan="2" style="font-weight:bold;padding:13px">OTHER</td>
                <td rowspan="2" style="font-weight:bold;">TOTAL REJECT</td>
                <td rowspan="2" style="font-weight:bold;">TOTAL CHECK</td>
                <td rowspan="2" style="font-weight:bold;">REMARK</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">BAD SHAPE</td>
                <td style="font-weight:bold;padding:13px">SKIP</td>
                <td style="font-weight:bold;">PUCKERING /TWISTING</td>
                <td style="font-weight:bold;">CROOKED</td>
                <td style="font-weight:bold;">PLEATED</td>
                <td style="font-weight:bold;">RUN OF STICH</td>
                <td style="font-weight:bold;">HTL /LABEL</td>
                <td style="font-weight:bold;">BUTTON (HOLE)</td>
                <td style="font-weight:bold;">PRINT, EMBRO</td>
                <td style="font-weight:bold;">BAD SHAPE</td>
                <td style="font-weight:bold;">UN-BALANCE</td>
                <td style="font-weight:bold;">SHADING</td>
                <td style="font-weight:bold;">DEFECT ON FAB</td>
                <td style="font-weight:bold;">DIRTY, OIL</td>
                <td style="font-weight:bold;padding:13px">SHINY</td>
            </tr>
            <?php $no=1;?>
            @foreach($TotalResult as $key => $dp)
            <tr>
              <td rowspan='2' scope="row">{{ $no }}</td>
              <td rowspan='2'>{{$dp['tgl_pengerjaan']}}</td>
              <td>Qty</td>
              <td>{{$dp['fg']}}</td>
              <td>{{$dp['broken']}}</td>
              <td>{{$dp['skip']}}</td>
              <td>{{$dp['pktw']}}</td>
              <td>{{$dp['crooked']}}</td>
              <td>{{$dp['pleated']}}</td>
              <td>{{$dp['ros']}}</td>
              <td>{{$dp['htl']}}</td>
              <td>{{$dp['button']}}</td>
              <td>{{$dp['print']}}</td>
              <td>{{$dp['bs']}}</td>
              <td>{{$dp['unb']}}</td>
              <td>{{$dp['shading']}}</td>
              <td>{{$dp['dof']}}</td>
              <td>{{$dp['dirty']}}</td>
              <td>{{$dp['shiny']}}</td>
              <td>{{$dp['sticker']}}</td>
              <td>{{$dp['trimming']}}</td>
              <td>{{$dp['ip']}}</td>
              <td>{{$dp['meas']}}</td>
              <td>{{$dp['other']}}</td>
              <td>{{$dp['total_reject']}}</td>
              <td rowspan="2">{{$dp['total_check']}}</td>
              <td rowspan="2">{{$dp['remark']}}</td>
            </tr>
            <tr>
              <td>%</td>
              <td>{{$dp['tot_fg']}} %</td>
              <td>{{$dp['tot_broken']}} %</td>
              <td>{{$dp['tot_skip']}} %</td>
              <td>{{$dp['tot_pktw']}} %</td>
              <td>{{$dp['tot_crooked']}} %</td>
              <td>{{$dp['tot_pleated']}} %</td>
              <td>{{$dp['tot_ros']}} %</td>
              <td>{{$dp['tot_htl']}} %</td>
              <td>{{$dp['tot_button']}} %</td>
              <td>{{$dp['tot_print']}} %</td>
              <td>{{$dp['tot_bs']}} %</td>
              <td>{{$dp['tot_unb']}} %</td>
              <td>{{$dp['tot_shading']}} %</td>
              <td>{{$dp['tot_dof']}} %</td>
              <td>{{$dp['tot_dirty']}} %</td>
              <td>{{$dp['tot_shiny']}} %</td>
              <td>{{$dp['tot_sticker']}} %</td>
              <td>{{$dp['tot_trimming']}} %</td>
              <td>{{$dp['tot_ip']}} %</td>
              <td>{{$dp['tot_meas']}} %</td>
              <td>{{$dp['tot_other']}} %</td>
              <td>{{$dp['p_total_reject']}} %</td>
            </tr>
            <?php $no++ ;?>
            @endforeach
            <tr>
              <td colspan="2" rowspan="2">TOTAL ALL LINE</td>
              <td>Qty</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['fg']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['broken']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['skip']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['pktw']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['crooked']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['pleated']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['ros']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['htl']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['button']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['print']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['bs']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['unb']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['shading']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['dof']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['dirty']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['shiny']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['sticker']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['trimming']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['ip']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['meas']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['other']}}</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['total_reject']}}</td>
              <td style="background-color:#C0C0C0;" rowspan="2">{{$totalLine['total_check']}}</td>
              <td style="background-color:#C0C0C0;" rowspan="2">{{$dataRemark}}</td>
            </tr>
            <tr>
              <td>%</td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_fg']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_broken']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_skip']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_pktw']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_crooked']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_pleated']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_ros']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_htl']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_button']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_print']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_bs']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_unb']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_shading']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_dof']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_dirty']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_shiny']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_sticker']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_trimming']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_ip']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_meas']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['tot_other']}} % </td>
              <td style="background-color:#C0C0C0;">{{$totalLine['p_total_reject']}} % % </td>
            </tr>
        </table>
        <br>
        @foreach($dataResult as $df)
        @if($df['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>NO WO : {{$df['no_wo']}} </h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$df['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
        @endforeach
        
    </body>
</html>