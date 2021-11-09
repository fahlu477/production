@include('layouts.header')
@include('layouts.navbar2')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="content-header">
          <div class="row">
            <div class="col-lg-3 col-6" style="padding:2px">
              <a href="{{ route('cc.level2', $dataBranch->id) }}" class="btn btn-block btn-secondary btn-sm">{{$dataBranch->nama_branch}}</a>
            </div>
            <div class="col-lg-3 col-6">
              <a href="{{ route('cc.qc', $dataBranch->id) }}" class="btn btn-block btn-secondary btn-sm">QUALITY CONTROL</a>
            </div>
          </div>
      </div>
    </section>
    <!-- Content Header (Page header) -->
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>OVERALL</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataSemua > 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataSemua >= 5 && $dataSemua <= 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataSemua < 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">11</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <a href="{{ route('cc.rework', $dataBranch->id) }}" class="col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>REWORK LINE</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataRework > 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRework}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataRework >= 5 && $dataRework <= 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRework}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataRework < 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRework}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px" >
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">11</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <!-- ./col -->
          <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>REJECT CUTTING</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataRejectCutting > 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectCutting}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataRejectCutting >= 2 && $dataRejectCutting <= 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectCutting}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataRejectCutting < 2)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectCutting}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">1</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>REJECT GARMENT</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataRejectGarment > 0.5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectGarment}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataRejectGarment >= 0.25 && $dataRejectGarment <= 0.5)
                    
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectGarment}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataRejectGarment < 0.25)
                  
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataRejectGarment}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px" >
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">1</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>FACTORY AUDIT (FA)</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataFactoryAudit > 2)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFactoryAudit}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataFactoryAudit > 0 && $dataFactoryAudit <= 2)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFactoryAudit}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataFactoryAudit == 0)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFactoryAudit}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">0</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>FINAL INSPECTION</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataFinalInspection > 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFinalInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataFinalInspection >= 3 && $dataFinalInspection <= 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFinalInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataFinalInspection < 3)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataFinalInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">1</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
           <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>SAMPLE INSPECTION</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataSampleInspection > 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSampleInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataSampleInspection >= 5 && $dataSampleInspection <= 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSampleInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataSampleInspection < 5)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSampleInspection}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">0</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="container col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>KLAIM BUYER</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataKlaimBuyer >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataKlaimBuyer}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataKlaimBuyer >= 50 && $dataKlaimBuyer <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataKlaimBuyer}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#ffff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ffff00;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataKlaimBuyer >= 0 && $dataKlaimBuyer <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataKlaimBuyer}}" data-width="118" data-thickness="0.19" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">1</span>
                    </div>
                    <div class="container lines"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@include('layouts.footer')
<script>
$(".dial").knob({
 "readOnly":true,
 'change': function (v) { console.log(v); },
  draw: function () {
    $(this.i).css('font-size', '14pt');
    $(this.i).val(this.cv + ' %');
  }
});
</script>