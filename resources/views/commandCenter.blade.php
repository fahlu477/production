@include('layouts.header')
@include('layouts.navbar2')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="content-header">
          <div class="row">
            <div class="col-lg-3 col-6" style="padding:2px">
                <a href="{{ route('commandCenter') }}" class="btn btn-block btn-secondary btn-sm">ALL FACTORY</a>
            </div>
            @foreach($branch as $bc)
            <div class="col-lg-3 col-6" style="padding:2px">
              <a href="{{ route('cc.level2', $bc->id) }}" class="btn btn-block btn-outline-secondary btn-sm">{{$bc->nama_branch}}</a>
            </div>
            @endforeach
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
                    @if($dataSemua >= 0 && $dataSemua <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataSemua >= 50 && $dataSemua <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataSemua >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataSemua}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
          <a href="{{route('allfac.qc')}}" class="col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>QUALITY CONTROL</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataQualityControl >= 0 && $dataQualityControl <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataQualityControl}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataQualityControl >= 50 && $dataQualityControl <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataQualityControl}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataQualityControl >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataQualityControl}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>PRODUCTION</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataProduction >= 0 && $dataProduction <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataProduction}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataProduction >= 50 && $dataProduction <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataProduction}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataProduction >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataProduction}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>EXPEDITION</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataExpedition > 10)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataExpedition}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataExpedition >= 5 && $dataExpedition <= 10)
                    
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataExpedition}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataExpedition == 0 || $dataExpedition < 5)
                  
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataExpedition}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>MARKETING</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataMarketing >= 0 && $dataMarketing <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataMarketing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataMarketing >= 50 && $dataMarketing <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataMarketing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataMarketing >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataMarketing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>ACCOUNTING</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataAccounting >= 0 && $dataAccounting <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataAccounting}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataAccounting >= 50 && $dataAccounting <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataAccounting}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataAccounting >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataAccounting}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>PURCHASING</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataPurchasing >= 0 && $dataPurchasing <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataPurchasing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataPurchasing >= 50 && $dataPurchasing <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataPurchasing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataPurchasing >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataPurchasing}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>WAREHOUSE</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataWarehouse >= 0 && $dataWarehouse <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataWarehouse}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataWarehouse >= 50 && $dataWarehouse <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataWarehouse}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataWarehouse >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataWarehouse}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>HR & GA</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataHR >= 0 && $dataHR <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataHR}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataHR >= 50 && $dataHR <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataHR}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataHR >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataHR}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>DOCUMENT</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataDocument >= 0 && $dataDocument <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDocument}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataDocument >= 50 && $dataDocument <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDocument}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataDocument >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDocument}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>INTERNAL AUDIT</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataInternalAudit >= 0 && $dataInternalAudit <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataInternalAudit}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataInternalAudit >= 50 && $dataInternalAudit <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataInternalAudit}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataInternalAudit >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataInternalAudit}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>IT & DT</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataIT >= 0 && $dataIT <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataIT}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataIT >= 50 && $dataIT <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataIT}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataIT >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataIT}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>DEPARTEMEN 1</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataDepartemen1 >= 0 && $dataDepartemen1 <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen1}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataDepartemen1 >= 50 && $dataDepartemen1 <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen1}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataDepartemen1 >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen1}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>DEPARTEMEN 2</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataDepartemen2 >= 0 && $dataDepartemen2 <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen2}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataDepartemen2 >= 50 && $dataDepartemen2 <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen2}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataDepartemen2 >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen2}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#00ff00;text-align: center;font-size:18px;">GOOD</div>
                      </div>
                    @endif
                    </center>
                  </div>
                  <div class="col-lg-5 col-6">
                    <div clas="container" style="padding-top:30px">
                      <span class="Issues">Issues</span>
                      <br>
                      <span class="Angka">2</span>
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
             <span class="judul"><center>DEPARTEMEN 3</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataDepartemen3 >= 0 && $dataDepartemen3 <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen3}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataDepartemen3 >= 50 && $dataDepartemen3 <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen3}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataDepartemen3 >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen3}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
             <span class="judul"><center>DEPARTEMEN 4</center></span>
              <div class="container">
                <div class="row">
                  <div class="col-lg-7 col-6">
                    <center>
                    @if($dataDepartemen4 >= 0 && $dataDepartemen4 <= 49)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen4}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#ff0000" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#ff0000;text-align: center;font-size:18px;">CRITICAL</div>
                      </div>
                    @endif
                    @if($dataDepartemen4 >= 50 && $dataDepartemen4 <= 74)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen4}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#FFC826" disabled>
                        <div class="knob-label" style="font-weight:bold;color:#FFC826;text-align: center;font-size:18px;">POOR</div>
                      </div>
                    @endif
                    @if($dataDepartemen4 >= 75)
                      <div class="container" style="padding-top:10px;">
                        <input type="text" class="dial" value="{{$dataDepartemen4}}" data-width="118" data-thickness="0.13" data-height="118" data-fgColor="#00ff00" disabled>
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
    $(this.i).css('font-size', '16pt').css('font-weight', 'bold');
    $(this.i).val(this.cv + ' %');
  }
});
</script>