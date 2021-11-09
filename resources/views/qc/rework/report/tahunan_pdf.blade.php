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
        <center><font style="font-weight:bold;font-size:15px;">PABRIK : 
                                @if($branch == 'CLN' && $branch_detail = 'CLN')
                                GISTEX CILEUNYI
                                @elseif($branch == 'MAJA' && $branch_detail = 'GM1')  
                                GISTEX MAJALENGKA 1
                                @elseif($branch == 'MAJA' && $branch_detail = 'GM2')  
                                GISTEX MAJALENGKA 2
                                @elseif($branch == 'GK' && $branch_detail = 'GK')  
                                GISTEX KALIBENDA
                                @elseif($branch == 'GS' && $branch_detail = 'GS')  
                                GISTEX SOLO 
                                @endif
                                [ {{$branch_detail}} ]
                </font></center>
        <center><font style="font-weight:bold;font-size:13px;">TAHUN {{$tahun}}</font></center>
        <br>
        <table style="width:1260px">
            <tr>
                  <td rowspan="2" style="font-weight:bold;">NO</td>
                  <td rowspan="2" style="font-weight:bold;padding:15px">BULAN</td>
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
            <tr>
                  <td rowspan='2'>1</td>
                  <td rowspan='2'>Jan</td>
                  <td>Qty</td>
                  <td>{{$totalJanuari['fg']}}</td>
                  <td>{{$totalJanuari['broken']}}</td>
                  <td>{{$totalJanuari['skip']}}</td>
                  <td>{{$totalJanuari['pktw']}}</td>
                  <td>{{$totalJanuari['crooked']}}</td>
                  <td>{{$totalJanuari['pleated']}}</td>
                  <td>{{$totalJanuari['ros']}}</td>
                  <td>{{$totalJanuari['htl']}}</td>
                  <td>{{$totalJanuari['button']}}</td>
                  <td>{{$totalJanuari['print']}}</td>
                  <td>{{$totalJanuari['bs']}}</td>
                  <td>{{$totalJanuari['unb']}}</td>
                  <td>{{$totalJanuari['shading']}}</td>
                  <td>{{$totalJanuari['dof']}}</td>
                  <td>{{$totalJanuari['dirty']}}</td>
                  <td>{{$totalJanuari['shiny']}}</td>
                  <td>{{$totalJanuari['sticker']}}</td>
                  <td>{{$totalJanuari['trimming']}}</td>
                  <td>{{$totalJanuari['ip']}}</td>
                  <td>{{$totalJanuari['meas']}}</td>
                  <td>{{$totalJanuari['other']}}</td>
                  <td>{{$totalJanuari['total_reject']}}</td>
                  <td rowspan="2">{{$totalJanuari['total_check']}}</td>
                  <td rowspan="2">{{$JanRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalJanuari['tot_fg']}} % </td>
                  <td>{{$totalJanuari['tot_broken']}} % </td>
                  <td>{{$totalJanuari['tot_skip']}} % </td>
                  <td>{{$totalJanuari['tot_pktw']}} % </td>
                  <td>{{$totalJanuari['tot_crooked']}} % </td>
                  <td>{{$totalJanuari['tot_pleated']}} % </td>
                  <td>{{$totalJanuari['tot_ros']}} % </td>
                  <td>{{$totalJanuari['tot_htl']}} % </td>
                  <td>{{$totalJanuari['tot_button']}} % </td>
                  <td>{{$totalJanuari['tot_print']}} % </td>
                  <td>{{$totalJanuari['tot_bs']}} % </td>
                  <td>{{$totalJanuari['tot_unb']}} % </td>
                  <td>{{$totalJanuari['tot_shading']}} % </td>
                  <td>{{$totalJanuari['tot_dof']}} % </td>
                  <td>{{$totalJanuari['tot_dirty']}} % </td>
                  <td>{{$totalJanuari['tot_shiny']}} % </td>
                  <td>{{$totalJanuari['tot_sticker']}} % </td>
                  <td>{{$totalJanuari['tot_trimming']}} % </td>
                  <td>{{$totalJanuari['tot_ip']}} % </td>
                  <td>{{$totalJanuari['tot_meas']}} % </td>
                  <td>{{$totalJanuari['tot_other']}} % </td>
                  <td>{{$totalJanuari['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>2</td>
                  <td rowspan='2'>Feb</td>
                  <td>Qty</td>
                  <td>{{$totalFebruari['fg']}}</td>
                  <td>{{$totalFebruari['broken']}}</td>
                  <td>{{$totalFebruari['skip']}}</td>
                  <td>{{$totalFebruari['pktw']}}</td>
                  <td>{{$totalFebruari['crooked']}}</td>
                  <td>{{$totalFebruari['pleated']}}</td>
                  <td>{{$totalFebruari['ros']}}</td>
                  <td>{{$totalFebruari['htl']}}</td>
                  <td>{{$totalFebruari['button']}}</td>
                  <td>{{$totalFebruari['print']}}</td>
                  <td>{{$totalFebruari['bs']}}</td>
                  <td>{{$totalFebruari['unb']}}</td>
                  <td>{{$totalFebruari['shading']}}</td>
                  <td>{{$totalFebruari['dof']}}</td>
                  <td>{{$totalFebruari['dirty']}}</td>
                  <td>{{$totalFebruari['shiny']}}</td>
                  <td>{{$totalFebruari['sticker']}}</td>
                  <td>{{$totalFebruari['trimming']}}</td>
                  <td>{{$totalFebruari['ip']}}</td>
                  <td>{{$totalFebruari['meas']}}</td>
                  <td>{{$totalFebruari['other']}}</td>
                  <td>{{$totalFebruari['total_reject']}}</td>
                  <td rowspan="2">{{$totalFebruari['total_check']}}</td>
                  <td rowspan="2">{{$FebRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalFebruari['tot_fg']}} % </td>
                  <td>{{$totalFebruari['tot_broken']}} % </td>
                  <td>{{$totalFebruari['tot_skip']}} % </td>
                  <td>{{$totalFebruari['tot_pktw']}} % </td>
                  <td>{{$totalFebruari['tot_crooked']}} % </td>
                  <td>{{$totalFebruari['tot_pleated']}} % </td>
                  <td>{{$totalFebruari['tot_ros']}} % </td>
                  <td>{{$totalFebruari['tot_htl']}} % </td>
                  <td>{{$totalFebruari['tot_button']}} % </td>
                  <td>{{$totalFebruari['tot_print']}} % </td>
                  <td>{{$totalFebruari['tot_bs']}} % </td>
                  <td>{{$totalFebruari['tot_unb']}} % </td>
                  <td>{{$totalFebruari['tot_shading']}} % </td>
                  <td>{{$totalFebruari['tot_dof']}} % </td>
                  <td>{{$totalFebruari['tot_dirty']}} % </td>
                  <td>{{$totalFebruari['tot_shiny']}} % </td>
                  <td>{{$totalFebruari['tot_sticker']}} % </td>
                  <td>{{$totalFebruari['tot_trimming']}} % </td>
                  <td>{{$totalFebruari['tot_ip']}} % </td>
                  <td>{{$totalFebruari['tot_meas']}} % </td>
                  <td>{{$totalFebruari['tot_other']}} % </td>
                  <td>{{$totalFebruari['p_total_reject']}} %</td>
              </tr>
              <tr>
                  <td rowspan='2'>3</td>
                  <td rowspan='2'>Mar</td>
                  <td>Qty</td>
                  <td>{{$totalMaret['fg']}}</td>
                  <td>{{$totalMaret['broken']}}</td>
                  <td>{{$totalMaret['skip']}}</td>
                  <td>{{$totalMaret['pktw']}}</td>
                  <td>{{$totalMaret['crooked']}}</td>
                  <td>{{$totalMaret['pleated']}}</td>
                  <td>{{$totalMaret['ros']}}</td>
                  <td>{{$totalMaret['htl']}}</td>
                  <td>{{$totalMaret['button']}}</td>
                  <td>{{$totalMaret['print']}}</td>
                  <td>{{$totalMaret['bs']}}</td>
                  <td>{{$totalMaret['unb']}}</td>
                  <td>{{$totalMaret['shading']}}</td>
                  <td>{{$totalMaret['dof']}}</td>
                  <td>{{$totalMaret['dirty']}}</td>
                  <td>{{$totalMaret['shiny']}}</td>
                  <td>{{$totalMaret['sticker']}}</td>
                  <td>{{$totalMaret['trimming']}}</td>
                  <td>{{$totalMaret['ip']}}</td>
                  <td>{{$totalMaret['meas']}}</td>
                  <td>{{$totalMaret['other']}}</td>
                  <td>{{$totalMaret['total_reject']}}</td>
                  <td rowspan="2">{{$totalMaret['total_check']}}</td>
                  <td rowspan="2">{{$MarRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalMaret['tot_fg']}} % </td>
                  <td>{{$totalMaret['tot_broken']}} % </td>
                  <td>{{$totalMaret['tot_skip']}} % </td>
                  <td>{{$totalMaret['tot_pktw']}} % </td>
                  <td>{{$totalMaret['tot_crooked']}} % </td>
                  <td>{{$totalMaret['tot_pleated']}} % </td>
                  <td>{{$totalMaret['tot_ros']}} % </td>
                  <td>{{$totalMaret['tot_htl']}} % </td>
                  <td>{{$totalMaret['tot_button']}} % </td>
                  <td>{{$totalMaret['tot_print']}} % </td>
                  <td>{{$totalMaret['tot_bs']}} % </td>
                  <td>{{$totalMaret['tot_unb']}} % </td>
                  <td>{{$totalMaret['tot_shading']}} % </td>
                  <td>{{$totalMaret['tot_dof']}} % </td>
                  <td>{{$totalMaret['tot_dirty']}} % </td>
                  <td>{{$totalMaret['tot_shiny']}} % </td>
                  <td>{{$totalMaret['tot_sticker']}} % </td>
                  <td>{{$totalMaret['tot_trimming']}} % </td>
                  <td>{{$totalMaret['tot_ip']}} % </td>
                  <td>{{$totalMaret['tot_meas']}} % </td>
                  <td>{{$totalMaret['tot_other']}} % </td>
                  <td>{{$totalMaret['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>4</td>
                  <td rowspan='2'>Apr</td>
                  <td>Qty</td>
                  <td>{{$totalApril['fg']}}</td>
                  <td>{{$totalApril['broken']}}</td>
                  <td>{{$totalApril['skip']}}</td>
                  <td>{{$totalApril['pktw']}}</td>
                  <td>{{$totalApril['crooked']}}</td>
                  <td>{{$totalApril['pleated']}}</td>
                  <td>{{$totalApril['ros']}}</td>
                  <td>{{$totalApril['htl']}}</td>
                  <td>{{$totalApril['button']}}</td>
                  <td>{{$totalApril['print']}}</td>
                  <td>{{$totalApril['bs']}}</td>
                  <td>{{$totalApril['unb']}}</td>
                  <td>{{$totalApril['shading']}}</td>
                  <td>{{$totalApril['dof']}}</td>
                  <td>{{$totalApril['dirty']}}</td>
                  <td>{{$totalApril['shiny']}}</td>
                  <td>{{$totalApril['sticker']}}</td>
                  <td>{{$totalApril['trimming']}}</td>
                  <td>{{$totalApril['ip']}}</td>
                  <td>{{$totalApril['meas']}}</td>
                  <td>{{$totalApril['other']}}</td>
                  <td>{{$totalApril['total_reject']}}</td>
                  <td rowspan="2">{{$totalApril['total_check']}}</td>
                  <td rowspan="2">{{$AprRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalApril['tot_fg']}} % </td>
                  <td>{{$totalApril['tot_broken']}} % </td>
                  <td>{{$totalApril['tot_skip']}} % </td>
                  <td>{{$totalApril['tot_pktw']}} % </td>
                  <td>{{$totalApril['tot_crooked']}} % </td>
                  <td>{{$totalApril['tot_pleated']}} % </td>
                  <td>{{$totalApril['tot_ros']}} % </td>
                  <td>{{$totalApril['tot_htl']}} % </td>
                  <td>{{$totalApril['tot_button']}} % </td>
                  <td>{{$totalApril['tot_print']}} % </td>
                  <td>{{$totalApril['tot_bs']}} % </td>
                  <td>{{$totalApril['tot_unb']}} % </td>
                  <td>{{$totalApril['tot_shading']}} % </td>
                  <td>{{$totalApril['tot_dof']}} % </td>
                  <td>{{$totalApril['tot_dirty']}} % </td>
                  <td>{{$totalApril['tot_shiny']}} % </td>
                  <td>{{$totalApril['tot_sticker']}} % </td>
                  <td>{{$totalApril['tot_trimming']}} % </td>
                  <td>{{$totalApril['tot_ip']}} % </td>
                  <td>{{$totalApril['tot_meas']}} % </td>
                  <td>{{$totalApril['tot_other']}} % </td>
                  <td>{{$totalApril['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>5</td>
                  <td rowspan='2'>Mei</td>
                  <td>Qty</td>
                  <td>{{$totalMei['fg']}}</td>
                  <td>{{$totalMei['broken']}}</td>
                  <td>{{$totalMei['skip']}}</td>
                  <td>{{$totalMei['pktw']}}</td>
                  <td>{{$totalMei['crooked']}}</td>
                  <td>{{$totalMei['pleated']}}</td>
                  <td>{{$totalMei['ros']}}</td>
                  <td>{{$totalMei['htl']}}</td>
                  <td>{{$totalMei['button']}}</td>
                  <td>{{$totalMei['print']}}</td>
                  <td>{{$totalMei['bs']}}</td>
                  <td>{{$totalMei['unb']}}</td>
                  <td>{{$totalMei['shading']}}</td>
                  <td>{{$totalMei['dof']}}</td>
                  <td>{{$totalMei['dirty']}}</td>
                  <td>{{$totalMei['shiny']}}</td>
                  <td>{{$totalMei['sticker']}}</td>
                  <td>{{$totalMei['trimming']}}</td>
                  <td>{{$totalMei['ip']}}</td>
                  <td>{{$totalMei['meas']}}</td>
                  <td>{{$totalMei['other']}}</td>
                  <td>{{$totalMei['total_reject']}}</td>
                  <td rowspan="2">{{$totalMei['total_check']}}</td>
                  <td rowspan="2">{{$MeiRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalMei['tot_fg']}} % </td>
                  <td>{{$totalMei['tot_broken']}} % </td>
                  <td>{{$totalMei['tot_skip']}} % </td>
                  <td>{{$totalMei['tot_pktw']}} % </td>
                  <td>{{$totalMei['tot_crooked']}} % </td>
                  <td>{{$totalMei['tot_pleated']}} % </td>
                  <td>{{$totalMei['tot_ros']}} % </td>
                  <td>{{$totalMei['tot_htl']}} % </td>
                  <td>{{$totalMei['tot_button']}} % </td>
                  <td>{{$totalMei['tot_print']}} % </td>
                  <td>{{$totalMei['tot_bs']}} % </td>
                  <td>{{$totalMei['tot_unb']}} % </td>
                  <td>{{$totalMei['tot_shading']}} % </td>
                  <td>{{$totalMei['tot_dof']}} % </td>
                  <td>{{$totalMei['tot_dirty']}} % </td>
                  <td>{{$totalMei['tot_shiny']}} % </td>
                  <td>{{$totalMei['tot_sticker']}} % </td>
                  <td>{{$totalMei['tot_trimming']}} % </td>
                  <td>{{$totalMei['tot_ip']}} % </td>
                  <td>{{$totalMei['tot_meas']}} % </td>
                  <td>{{$totalMei['tot_other']}} % </td>
                  <td>{{$totalMei['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>6</td>
                  <td rowspan='2'>Jun</td>
                  <td>Qty</td>
                  <td>{{$totalJuni['fg']}}</td>
                  <td>{{$totalJuni['broken']}}</td>
                  <td>{{$totalJuni['skip']}}</td>
                  <td>{{$totalJuni['pktw']}}</td>
                  <td>{{$totalJuni['crooked']}}</td>
                  <td>{{$totalJuni['pleated']}}</td>
                  <td>{{$totalJuni['ros']}}</td>
                  <td>{{$totalJuni['htl']}}</td>
                  <td>{{$totalJuni['button']}}</td>
                  <td>{{$totalJuni['print']}}</td>
                  <td>{{$totalJuni['bs']}}</td>
                  <td>{{$totalJuni['unb']}}</td>
                  <td>{{$totalJuni['shading']}}</td>
                  <td>{{$totalJuni['dof']}}</td>
                  <td>{{$totalJuni['dirty']}}</td>
                  <td>{{$totalJuni['shiny']}}</td>
                  <td>{{$totalJuni['sticker']}}</td>
                  <td>{{$totalJuni['trimming']}}</td>
                  <td>{{$totalJuni['ip']}}</td>
                  <td>{{$totalJuni['meas']}}</td>
                  <td>{{$totalJuni['other']}}</td>
                  <td>{{$totalJuni['total_reject']}}</td>
                  <td rowspan="2">{{$totalJuni['total_check']}}</td>
                  <td rowspan="2">{{$JunRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalJuni['tot_fg']}} % </td>
                  <td>{{$totalJuni['tot_broken']}} % </td>
                  <td>{{$totalJuni['tot_skip']}} % </td>
                  <td>{{$totalJuni['tot_pktw']}} % </td>
                  <td>{{$totalJuni['tot_crooked']}} % </td>
                  <td>{{$totalJuni['tot_pleated']}} % </td>
                  <td>{{$totalJuni['tot_ros']}} % </td>
                  <td>{{$totalJuni['tot_htl']}} % </td>
                  <td>{{$totalJuni['tot_button']}} % </td>
                  <td>{{$totalJuni['tot_print']}} % </td>
                  <td>{{$totalJuni['tot_bs']}} % </td>
                  <td>{{$totalJuni['tot_unb']}} % </td>
                  <td>{{$totalJuni['tot_shading']}} % </td>
                  <td>{{$totalJuni['tot_dof']}} % </td>
                  <td>{{$totalJuni['tot_dirty']}} % </td>
                  <td>{{$totalJuni['tot_shiny']}} % </td>
                  <td>{{$totalJuni['tot_sticker']}} % </td>
                  <td>{{$totalJuni['tot_trimming']}} % </td>
                  <td>{{$totalJuni['tot_ip']}} % </td>
                  <td>{{$totalJuni['tot_meas']}} % </td>
                  <td>{{$totalJuni['tot_other']}} % </td>
                  <td>{{$totalJuni['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>7</td>
                  <td rowspan='2'>Jul</td>
                  <td>Qty</td>
                  <td>{{$totalJuli['fg']}}</td>
                  <td>{{$totalJuli['broken']}}</td>
                  <td>{{$totalJuli['skip']}}</td>
                  <td>{{$totalJuli['pktw']}}</td>
                  <td>{{$totalJuli['crooked']}}</td>
                  <td>{{$totalJuli['pleated']}}</td>
                  <td>{{$totalJuli['ros']}}</td>
                  <td>{{$totalJuli['htl']}}</td>
                  <td>{{$totalJuli['button']}}</td>
                  <td>{{$totalJuli['print']}}</td>
                  <td>{{$totalJuli['bs']}}</td>
                  <td>{{$totalJuli['unb']}}</td>
                  <td>{{$totalJuli['shading']}}</td>
                  <td>{{$totalJuli['dof']}}</td>
                  <td>{{$totalJuli['dirty']}}</td>
                  <td>{{$totalJuli['shiny']}}</td>
                  <td>{{$totalJuli['sticker']}}</td>
                  <td>{{$totalJuli['trimming']}}</td>
                  <td>{{$totalJuli['ip']}}</td>
                  <td>{{$totalJuli['meas']}}</td>
                  <td>{{$totalJuli['other']}}</td>
                  <td>{{$totalJuli['total_reject']}}</td>
                  <td rowspan="2">{{$totalJuli['total_check']}}</td>
                  <td rowspan="2">{{$JulRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalJuli['tot_fg']}} % </td>
                  <td>{{$totalJuli['tot_broken']}} % </td>
                  <td>{{$totalJuli['tot_skip']}} % </td>
                  <td>{{$totalJuli['tot_pktw']}} % </td>
                  <td>{{$totalJuli['tot_crooked']}} % </td>
                  <td>{{$totalJuli['tot_pleated']}} % </td>
                  <td>{{$totalJuli['tot_ros']}} % </td>
                  <td>{{$totalJuli['tot_htl']}} % </td>
                  <td>{{$totalJuli['tot_button']}} % </td>
                  <td>{{$totalJuli['tot_print']}} % </td>
                  <td>{{$totalJuli['tot_bs']}} % </td>
                  <td>{{$totalJuli['tot_unb']}} % </td>
                  <td>{{$totalJuli['tot_shading']}} % </td>
                  <td>{{$totalJuli['tot_dof']}} % </td>
                  <td>{{$totalJuli['tot_dirty']}} % </td>
                  <td>{{$totalJuli['tot_shiny']}} % </td>
                  <td>{{$totalJuli['tot_sticker']}} % </td>
                  <td>{{$totalJuli['tot_trimming']}} % </td>
                  <td>{{$totalJuli['tot_ip']}} % </td>
                  <td>{{$totalJuli['tot_meas']}} % </td>
                  <td>{{$totalJuli['tot_other']}} % </td>
                  <td>{{$totalJuli['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>8</td>
                  <td rowspan='2'>Ags</td>
                  <td>Qty</td>
                  <td>{{$totalAgustus['fg']}}</td>
                  <td>{{$totalAgustus['broken']}}</td>
                  <td>{{$totalAgustus['skip']}}</td>
                  <td>{{$totalAgustus['pktw']}}</td>
                  <td>{{$totalAgustus['crooked']}}</td>
                  <td>{{$totalAgustus['pleated']}}</td>
                  <td>{{$totalAgustus['ros']}}</td>
                  <td>{{$totalAgustus['htl']}}</td>
                  <td>{{$totalAgustus['button']}}</td>
                  <td>{{$totalAgustus['print']}}</td>
                  <td>{{$totalAgustus['bs']}}</td>
                  <td>{{$totalAgustus['unb']}}</td>
                  <td>{{$totalAgustus['shading']}}</td>
                  <td>{{$totalAgustus['dof']}}</td>
                  <td>{{$totalAgustus['dirty']}}</td>
                  <td>{{$totalAgustus['shiny']}}</td>
                  <td>{{$totalAgustus['sticker']}}</td>
                  <td>{{$totalAgustus['trimming']}}</td>
                  <td>{{$totalAgustus['ip']}}</td>
                  <td>{{$totalAgustus['meas']}}</td>
                  <td>{{$totalAgustus['other']}}</td>
                  <td>{{$totalAgustus['total_reject']}}</td>
                  <td rowspan="2">{{$totalAgustus['total_check']}}</td>
                  <td rowspan="2">{{$AgsRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalAgustus['tot_fg']}} % </td>
                  <td>{{$totalAgustus['tot_broken']}} % </td>
                  <td>{{$totalAgustus['tot_skip']}} % </td>
                  <td>{{$totalAgustus['tot_pktw']}} % </td>
                  <td>{{$totalAgustus['tot_crooked']}} % </td>
                  <td>{{$totalAgustus['tot_pleated']}} % </td>
                  <td>{{$totalAgustus['tot_ros']}} % </td>
                  <td>{{$totalAgustus['tot_htl']}} % </td>
                  <td>{{$totalAgustus['tot_button']}} % </td>
                  <td>{{$totalAgustus['tot_print']}} % </td>
                  <td>{{$totalAgustus['tot_bs']}} % </td>
                  <td>{{$totalAgustus['tot_unb']}} % </td>
                  <td>{{$totalAgustus['tot_shading']}} % </td>
                  <td>{{$totalAgustus['tot_dof']}} % </td>
                  <td>{{$totalAgustus['tot_dirty']}} % </td>
                  <td>{{$totalAgustus['tot_shiny']}} % </td>
                  <td>{{$totalAgustus['tot_sticker']}} % </td>
                  <td>{{$totalAgustus['tot_trimming']}} % </td>
                  <td>{{$totalAgustus['tot_ip']}} % </td>
                  <td>{{$totalAgustus['tot_meas']}} % </td>
                  <td>{{$totalAgustus['tot_other']}} % </td>
                  <td>{{$totalAgustus['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>9</td>
                  <td rowspan='2'>Sep</td>
                  <td>Qty</td>
                  <td>{{$totalSeptember['fg']}}</td>
                  <td>{{$totalSeptember['broken']}}</td>
                  <td>{{$totalSeptember['skip']}}</td>
                  <td>{{$totalSeptember['pktw']}}</td>
                  <td>{{$totalSeptember['crooked']}}</td>
                  <td>{{$totalSeptember['pleated']}}</td>
                  <td>{{$totalSeptember['ros']}}</td>
                  <td>{{$totalSeptember['htl']}}</td>
                  <td>{{$totalSeptember['button']}}</td>
                  <td>{{$totalSeptember['print']}}</td>
                  <td>{{$totalSeptember['bs']}}</td>
                  <td>{{$totalSeptember['unb']}}</td>
                  <td>{{$totalSeptember['shading']}}</td>
                  <td>{{$totalSeptember['dof']}}</td>
                  <td>{{$totalSeptember['dirty']}}</td>
                  <td>{{$totalSeptember['shiny']}}</td>
                  <td>{{$totalSeptember['sticker']}}</td>
                  <td>{{$totalSeptember['trimming']}}</td>
                  <td>{{$totalSeptember['ip']}}</td>
                  <td>{{$totalSeptember['meas']}}</td>
                  <td>{{$totalSeptember['other']}}</td>
                  <td>{{$totalSeptember['total_reject']}}</td>
                  <td rowspan="2">{{$totalSeptember['total_check']}}</td>
                  <td rowspan="2">{{$SepRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalSeptember['tot_fg']}} % </td>
                  <td>{{$totalSeptember['tot_broken']}} % </td>
                  <td>{{$totalSeptember['tot_skip']}} % </td>
                  <td>{{$totalSeptember['tot_pktw']}} % </td>
                  <td>{{$totalSeptember['tot_crooked']}} % </td>
                  <td>{{$totalSeptember['tot_pleated']}} % </td>
                  <td>{{$totalSeptember['tot_ros']}} % </td>
                  <td>{{$totalSeptember['tot_htl']}} % </td>
                  <td>{{$totalSeptember['tot_button']}} % </td>
                  <td>{{$totalSeptember['tot_print']}} % </td>
                  <td>{{$totalSeptember['tot_bs']}} % </td>
                  <td>{{$totalSeptember['tot_unb']}} % </td>
                  <td>{{$totalSeptember['tot_shading']}} % </td>
                  <td>{{$totalSeptember['tot_dof']}} % </td>
                  <td>{{$totalSeptember['tot_dirty']}} % </td>
                  <td>{{$totalSeptember['tot_shiny']}} % </td>
                  <td>{{$totalSeptember['tot_sticker']}} % </td>
                  <td>{{$totalSeptember['tot_trimming']}} % </td>
                  <td>{{$totalSeptember['tot_ip']}} % </td>
                  <td>{{$totalSeptember['tot_meas']}} % </td>
                  <td>{{$totalSeptember['tot_other']}} % </td>
                  <td>{{$totalSeptember['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>10</td>
                  <td rowspan='2'>Okt</td>
                  <td>Qty</td>
                  <td>{{$totalOktober['fg']}}</td>
                  <td>{{$totalOktober['broken']}}</td>
                  <td>{{$totalOktober['skip']}}</td>
                  <td>{{$totalOktober['pktw']}}</td>
                  <td>{{$totalOktober['crooked']}}</td>
                  <td>{{$totalOktober['pleated']}}</td>
                  <td>{{$totalOktober['ros']}}</td>
                  <td>{{$totalOktober['htl']}}</td>
                  <td>{{$totalOktober['button']}}</td>
                  <td>{{$totalOktober['print']}}</td>
                  <td>{{$totalOktober['bs']}}</td>
                  <td>{{$totalOktober['unb']}}</td>
                  <td>{{$totalOktober['shading']}}</td>
                  <td>{{$totalOktober['dof']}}</td>
                  <td>{{$totalOktober['dirty']}}</td>
                  <td>{{$totalOktober['shiny']}}</td>
                  <td>{{$totalOktober['sticker']}}</td>
                  <td>{{$totalOktober['trimming']}}</td>
                  <td>{{$totalOktober['ip']}}</td>
                  <td>{{$totalOktober['meas']}}</td>
                  <td>{{$totalOktober['other']}}</td>
                  <td>{{$totalOktober['total_reject']}}</td>
                  <td rowspan="2">{{$totalOktober['total_check']}}</td>
                  <td rowspan="2">{{$OktRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalOktober['tot_fg']}} % </td>
                  <td>{{$totalOktober['tot_broken']}} % </td>
                  <td>{{$totalOktober['tot_skip']}} % </td>
                  <td>{{$totalOktober['tot_pktw']}} % </td>
                  <td>{{$totalOktober['tot_crooked']}} % </td>
                  <td>{{$totalOktober['tot_pleated']}} % </td>
                  <td>{{$totalOktober['tot_ros']}} % </td>
                  <td>{{$totalOktober['tot_htl']}} % </td>
                  <td>{{$totalOktober['tot_button']}} % </td>
                  <td>{{$totalOktober['tot_print']}} % </td>
                  <td>{{$totalOktober['tot_bs']}} % </td>
                  <td>{{$totalOktober['tot_unb']}} % </td>
                  <td>{{$totalOktober['tot_shading']}} % </td>
                  <td>{{$totalOktober['tot_dof']}} % </td>
                  <td>{{$totalOktober['tot_dirty']}} % </td>
                  <td>{{$totalOktober['tot_shiny']}} % </td>
                  <td>{{$totalOktober['tot_sticker']}} % </td>
                  <td>{{$totalOktober['tot_trimming']}} % </td>
                  <td>{{$totalOktober['tot_ip']}} % </td>
                  <td>{{$totalOktober['tot_meas']}} % </td>
                  <td>{{$totalOktober['tot_other']}} % </td>
                  <td>{{$totalOktober['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>11</td>
                  <td rowspan='2'>Nov</td>
                  <td>Qty</td>
                  <td>{{$totalNovember['fg']}}</td>
                  <td>{{$totalNovember['broken']}}</td>
                  <td>{{$totalNovember['skip']}}</td>
                  <td>{{$totalNovember['pktw']}}</td>
                  <td>{{$totalNovember['crooked']}}</td>
                  <td>{{$totalNovember['pleated']}}</td>
                  <td>{{$totalNovember['ros']}}</td>
                  <td>{{$totalNovember['htl']}}</td>
                  <td>{{$totalNovember['button']}}</td>
                  <td>{{$totalNovember['print']}}</td>
                  <td>{{$totalNovember['bs']}}</td>
                  <td>{{$totalNovember['unb']}}</td>
                  <td>{{$totalNovember['shading']}}</td>
                  <td>{{$totalNovember['dof']}}</td>
                  <td>{{$totalNovember['dirty']}}</td>
                  <td>{{$totalNovember['shiny']}}</td>
                  <td>{{$totalNovember['sticker']}}</td>
                  <td>{{$totalNovember['trimming']}}</td>
                  <td>{{$totalNovember['ip']}}</td>
                  <td>{{$totalNovember['meas']}}</td>
                  <td>{{$totalNovember['other']}}</td>
                  <td>{{$totalNovember['total_reject']}}</td>
                  <td rowspan="2">{{$totalNovember['total_check']}}</td>
                  <td rowspan="2">{{$NovRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalNovember['tot_fg']}} % </td>
                  <td>{{$totalNovember['tot_broken']}} % </td>
                  <td>{{$totalNovember['tot_skip']}} % </td>
                  <td>{{$totalNovember['tot_pktw']}} % </td>
                  <td>{{$totalNovember['tot_crooked']}} % </td>
                  <td>{{$totalNovember['tot_pleated']}} % </td>
                  <td>{{$totalNovember['tot_ros']}} % </td>
                  <td>{{$totalNovember['tot_htl']}} % </td>
                  <td>{{$totalNovember['tot_button']}} % </td>
                  <td>{{$totalNovember['tot_print']}} % </td>
                  <td>{{$totalNovember['tot_bs']}} % </td>
                  <td>{{$totalNovember['tot_unb']}} % </td>
                  <td>{{$totalNovember['tot_shading']}} % </td>
                  <td>{{$totalNovember['tot_dof']}} % </td>
                  <td>{{$totalNovember['tot_dirty']}} % </td>
                  <td>{{$totalNovember['tot_shiny']}} % </td>
                  <td>{{$totalNovember['tot_sticker']}} % </td>
                  <td>{{$totalNovember['tot_trimming']}} % </td>
                  <td>{{$totalNovember['tot_ip']}} % </td>
                  <td>{{$totalNovember['tot_meas']}} % </td>
                  <td>{{$totalNovember['tot_other']}} % </td>
                  <td>{{$totalNovember['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td rowspan='2'>12</td>
                  <td rowspan='2'>Des</td>
                  <td>Qty</td>
                  <td>{{$totalDesember['fg']}}</td>
                  <td>{{$totalDesember['broken']}}</td>
                  <td>{{$totalDesember['skip']}}</td>
                  <td>{{$totalDesember['pktw']}}</td>
                  <td>{{$totalDesember['crooked']}}</td>
                  <td>{{$totalDesember['pleated']}}</td>
                  <td>{{$totalDesember['ros']}}</td>
                  <td>{{$totalDesember['htl']}}</td>
                  <td>{{$totalDesember['button']}}</td>
                  <td>{{$totalDesember['print']}}</td>
                  <td>{{$totalDesember['bs']}}</td>
                  <td>{{$totalDesember['unb']}}</td>
                  <td>{{$totalDesember['shading']}}</td>
                  <td>{{$totalDesember['dof']}}</td>
                  <td>{{$totalDesember['dirty']}}</td>
                  <td>{{$totalDesember['shiny']}}</td>
                  <td>{{$totalDesember['sticker']}}</td>
                  <td>{{$totalDesember['trimming']}}</td>
                  <td>{{$totalDesember['ip']}}</td>
                  <td>{{$totalDesember['meas']}}</td>
                  <td>{{$totalDesember['other']}}</td>
                  <td>{{$totalDesember['total_reject']}}</td>
                  <td rowspan="2">{{$totalDesember['total_check']}}</td>
                  <td rowspan="2">{{$DesRemark}}</td>
              </tr>
              <tr>
                  <td>%</td>
                  <td>{{$totalDesember['tot_fg']}} % </td>
                  <td>{{$totalDesember['tot_broken']}} % </td>
                  <td>{{$totalDesember['tot_skip']}} % </td>
                  <td>{{$totalDesember['tot_pktw']}} % </td>
                  <td>{{$totalDesember['tot_crooked']}} % </td>
                  <td>{{$totalDesember['tot_pleated']}} % </td>
                  <td>{{$totalDesember['tot_ros']}} % </td>
                  <td>{{$totalDesember['tot_htl']}} % </td>
                  <td>{{$totalDesember['tot_button']}} % </td>
                  <td>{{$totalDesember['tot_print']}} % </td>
                  <td>{{$totalDesember['tot_bs']}} % </td>
                  <td>{{$totalDesember['tot_unb']}} % </td>
                  <td>{{$totalDesember['tot_shading']}} % </td>
                  <td>{{$totalDesember['tot_dof']}} % </td>
                  <td>{{$totalDesember['tot_dirty']}} % </td>
                  <td>{{$totalDesember['tot_shiny']}} % </td>
                  <td>{{$totalDesember['tot_sticker']}} % </td>
                  <td>{{$totalDesember['tot_trimming']}} % </td>
                  <td>{{$totalDesember['tot_ip']}} % </td>
                  <td>{{$totalDesember['tot_meas']}} % </td>
                  <td>{{$totalDesember['tot_other']}} % </td>
                  <td>{{$totalDesember['p_total_reject']}} % </td>
              </tr>
              <tr>
                  <td colspan="2" rowspan="2" style="background-color:#C0C0C0;">TOTAL ALL LINE</td>
                  <td style="background-color:#C0C0C0;">Qty</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['fg']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['broken']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['skip']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['pktw']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['crooked']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['pleated']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['ros']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['htl']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['button']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['print']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['bs']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['unb']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['shading']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['dof']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['dirty']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['shiny']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['sticker']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['trimming']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['ip']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['meas']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['other']}}</td>
                  <td style="background-color:#C0C0C0;">{{$totalData['total_reject']}}</td>
                  <td rowspan="2" style="background-color:#C0C0C0;">{{$totalData['total_check']}}</td>
                  <td rowspan="2" style="background-color:#C0C0C0;"></td>
              </tr>
              <tr>
                <td style="background-color:#C0C0C0;">%</td>
                <td style="background-color:#C0C0C0;">{{$totalData['tot_fg']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_broken']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_skip']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_pktw']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_crooked']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_pleated']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_ros']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_htl']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_button']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_print']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_bs']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_unb']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_shading']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_dof']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_dirty']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_shiny']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_sticker']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_trimming']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_ip']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_meas']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['tot_other']}} % </td>
                  <td style="background-color:#C0C0C0;">{{$totalData['p_total_reject']}} % </td>
              </tr>
        </table>
        <br>
        @if($totalAgustus['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>Agustus</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$totalAgustus['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
        @if($totalSeptember['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>September</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$totalSeptember['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
        @if($totalOktober['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>Oktober</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$totalOktober['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
        @if($totalNovember['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>November</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$totalNovember['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
        @if($totalDesember['file'] != null)
        <div class="page_break"></div>
        <div class="tables">
        <div class="tables-row">
            <div class="tables-cell">
                <h3>Desember</h3>
                <center><img class="span12" style="height:600px;width:800px"src="{{ public_path('rework/qc/images/'.$totalDesember['file']) }}"> </center>
            </div>
        </div>
        </div>
        @endif
    </body>
</html>