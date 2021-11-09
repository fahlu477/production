@include('layouts.header')
@include('layouts.navbar2')
<style>
#example2 {
  border: 1px #888888 solid;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="content-header">
          <div class="row">
            <div class="col-lg-3 col-6" style="padding:2px">
              <a href="{{ route('cc.level2', $dataBranch->id) }}" class="btn btn-block btn-secondary btn-sm">{{$dataBranch->nama_branch}}</a>
            </div>
            <div class="col-lg-3 col-6">
              <a href="{{ route('cc.qc', $dataBranch->id) }}" class="btn btn-block btn-secondary btn-sm">QUALITY CONTROL</a>
            </div>
            <div class="col-lg-3 col-6">
              <a href="{{ route('cc.rework', $dataBranch->id) }}" class="btn btn-block btn-secondary btn-sm">REWORK LINE</a>
            </div>
            <div class="col-lg-3 col-6">
              <form action="{{ route('harian.get')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="branch" id="branch" value="{{$dataBranch->id}}">
                  <input type="hidden" name="tanggal" id="tanggal" value="{{$tanggal}}"/>
                  <button type="submit" class="btn btn-block btn-secondary btn-sm">DETAIL</button>
              </form>
            </div>
          </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <label for="">LINES</label>
                <div class="row">
                  <a href="{{route('cc.rework', $dataBranch->id)}}" class="card col-lg-3"  style="padding-top:13px" id="example2">
                    @if($totalSemuaLine['p_total_reject'] < 5)
                    <div class="info-box bg-gradient-success">
                    @elseif($totalSemuaLine['p_total_reject'] >= 5 && $totalSemuaLine['p_total_reject'] <= 10)
                    <div class="info-box bg-gradient-warning">
                    @elseif($totalSemuaLine['p_total_reject'] > 10 )
                    <div class="info-box bg-gradient-danger">
                    @endif
                      <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text" style="font-weight:bold;">ALL LINE</span>
                        <span class="info-box-number">TOT Reject : {{$totalSemuaLine['p_total_reject']}}</span>
                        <div class="progress">
                          <div class="progress-bar" style="width: {{$totalSemuaLine['p_total_reject']}}%">
                        </div>
                        </div>
                        <span class="progress-description" style="font-weight:bold;">
                          Jumlah WO : {{$jum_wo}}
                        </span>
                      </div>
                    </div>
                  </a>
                  @foreach($mline as $ml)
                  <a href="{{route('cc.lines', $ml['id_line'])}}" class="col-lg-3">
                    @if($ml['p_reject'] < 5)
                    <div class="info-box bg-gradient-success">
                    @elseif($ml['p_reject'] >= 5 && $ml['p_reject'] <= 10)
                    <div class="info-box bg-gradient-warning">
                    @elseif($ml['p_reject'] > 10 )
                    <div class="info-box bg-gradient-danger">
                    @endif
                      <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text" style="font-weight:bold;">{{$ml['line']}}</span>
                        <span class="info-box-number">TOT Reject : {{$ml['p_reject']}}</span>
                        <div class="progress">
                          <div class="progress-bar" style="width: {{$ml['p_reject']}}%">
                        </div>
                        </div>
                        <span class="progress-description" style="font-weight:bold;">
                          Jumlah WO : {{$ml['jumlah_wo']}}
                        </span>
                      </div>
                    </div>
                  </a>
                  @endforeach
                </div>
                <div class="row">
                  <div class="col-lg-7">
                    <label for="">INDIKATOR REWORK LINE</label>
                    <div class="card">
                      <div class="row">
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_fg'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_fg']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_fg'] >= 5 && $totalSemuaLine['tot_fg'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_fg']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_fg'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_fg']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">FINISH GOOD</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_broken'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_broken']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_broken'] >= 5 && $totalSemuaLine['tot_broken'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_broken']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_broken'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_broken']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">BAD SHAPE</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_skip'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_skip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_skip'] >= 5 && $totalSemuaLine['tot_skip'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_skip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_skip'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_skip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">SKIP</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_pktw'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pktw']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_pktw'] >= 5 && $totalSemuaLine['tot_pktw'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pktw']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_pktw'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pktw']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">PUCKERING</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_crooked'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_crooked']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_crooked'] >= 5 && $totalSemuaLine['tot_crooked'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_crooked']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_crooked'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_crooked']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">CROOKED</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_pleated'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pleated']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_pleated'] >= 5 && $totalSemuaLine['tot_pleated'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pleated']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_pleated'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_pleated']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">PLEATED</label></center>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="padding-top:10px;">
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_ros'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ros']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_ros'] >= 5 && $totalSemuaLine['tot_ros'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ros']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_ros'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ros']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">R-O-S</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_htl'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_htl']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_htl'] >= 5 && $totalSemuaLine['tot_htl'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_htl']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_htl'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_htl']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">HTL/LABEL</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_button'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_button']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_button'] >= 5 && $totalSemuaLine['tot_button'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_button']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_button'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_button']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">BUTTON</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_print'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_print']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_print'] >= 5 && $totalSemuaLine['tot_print'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_print']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_print'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_print']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">PRINT</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_bs'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_bs']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_bs'] >= 5 && $totalSemuaLine['tot_bs'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_bs']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_bs'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_bs']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">BAD SHAPE</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_unb'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_unb']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_unb'] >= 5 && $totalSemuaLine['tot_unb'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_unb']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_unb'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_unb']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">UNB</label></center>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="padding-top:10px;">
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_shading'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shading']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_shading'] >= 5 && $totalSemuaLine['tot_shading'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shading']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_shading'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shading']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">SHADING</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_dof'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dof']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_dof'] >= 5 && $totalSemuaLine['tot_dof'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dof']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_dof'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dof']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">DOF</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_dirty'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dirty']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_dirty'] >= 5 && $totalSemuaLine['tot_dirty'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dirty']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_dirty'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_dirty']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">DIRTY,OIL</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_shiny'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shiny']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_shiny'] >= 5 && $totalSemuaLine['tot_shiny'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shiny']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_shiny'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_shiny']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">SHINY</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_sticker'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_sticker']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_sticker'] >= 5 && $totalSemuaLine['tot_sticker'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_sticker']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_sticker'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_sticker']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">STICKER</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_trimming'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_trimming']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_trimming'] >= 5 && $totalSemuaLine['tot_trimming'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_trimming']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_trimming'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_trimming']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">TRIMMING</label></center>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="padding-top:10px;">
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_ip'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_ip'] >= 5 && $totalSemuaLine['tot_ip'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_ip'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_ip']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">I-PROBLEM</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_meas'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_meas']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_meas'] >= 5 && $totalSemuaLine['tot_meas'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_meas']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_meas'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_meas']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">MEAS</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['tot_other'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_other']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_other'] >= 5 && $totalSemuaLine['tot_other'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_other']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['tot_other'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['tot_other']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">OTHER</label></center>
                          </div>
                        </div>
                        <div class="col-lg-2 col-4">
                          <center>
                          @if($totalSemuaLine['p_total_reject'] < 5)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['p_total_reject']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#3AAE55" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['p_total_reject'] >= 5 && $totalSemuaLine['p_total_reject'] <= 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['p_total_reject']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ffff00" disabled>
                            </div>
                          @endif
                          @if($totalSemuaLine['p_total_reject'] > 10)
                            <div class="container" style="padding-top:10px;">
                              <input type="text" class="dial" value="{{$totalSemuaLine['p_total_reject']}}" data-width="68" data-thickness="0.08" data-height="68" data-fgColor="#ff0000" disabled>
                            </div>
                          @endif
                          </center>
                          <div class="container">
                            <center><label for="rw" style="font-weight:bold;font-size:12px;padding-left:2">TOT REJECT</label></center>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <label for="">DETAIL LINE</label>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th>NO</th>
                            <th>LINE</th>
                            <th>WO</th>
                            <th>TARGET_WO</th>
                            <th>TERPENUHI</th>
                            <th>PROGRESS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no=1;?>
                          @foreach($detailLine as $dt)
                          <tr>
                            <td scope="row">{{ $no }}</td>
                            <td>{{$dt['line']}}</td>
                            <td>{{$dt['no_wo']}}</td>
                            <td>{{$dt['target_wo']}}</td>
                            <td>{{$dt['terpenuhi']}}</td>
                            @if($dt['proses'] == 0)
                            <td><span class="badge bg-secondary">Belum Dikerjakan</span></td>
                            @elseif($dt['proses'] == 1)
                            <td><span class="badge bg-warning">Belum Selesai</span></td>
                            @elseif($dt['proses'] == 2)
                            <td><span class="badge bg-success">Selesai</span></td>
                            @endif
                          </tr>
                          <?php $no++ ;?>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div>
                  
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
@include('layouts.footer')
<script>
$(".dial").knob({
 "readOnly":true,
 'change': function (v) { console.log(v); },
  draw: function () {
    $(this.i).css('font-size', '11pt');
    $(this.i).val(this.cv + '%');
  }
});
</script>