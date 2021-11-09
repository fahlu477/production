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
            <div class="col-lg-3 col-6">
              <a href="{{ route('allcc.qc') }}" class="btn btn-block btn-secondary btn-sm">QUALITY CONTROL</a>
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
          @foreach($dataBranch as $db)
          <a href="{{ route('cc.qc', $db->id) }}" class="col-lg-3">
            <div class="small-box" style="background-color: #375a64;height:auto;">
             <span class="judul"><center>{{$db->nama_branch}}</center></span>
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
          </a>
          <!-- ./col -->
          @endforeach
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