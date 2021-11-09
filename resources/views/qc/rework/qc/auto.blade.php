@include('qc.rework.layouts.header')
<style> 
.div1 {
  width: 200px;
  height: auto;
  padding: 5px;
  background-color:red;
  border: 1px solid red;
}

.div2 {
  width: 200px;
  height: auto;  
  padding: 5px;
  background-color:yellow;
  border: 1px solid yellow;
}

.div3 {
  width: auto;
  height: auto;  
  padding: 5px;
  border: 1px solid black;
}

.div4 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#228B22;
  border: 1px solid #228B22;
}

.div5 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#7FFF00;
  border: 1px solid #7FFF00;
}

.div6 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#20B2AA;
  border: 1px solid #20B2AA;
}

.div7 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#FFE4B5;
  border: 1px solid #FFE4B5;
}

.div8 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#FFA500;
  border: 1px solid #FFA500;
}

.div9 {
  width: 100%;
  height: auto;
  padding: 7px;
  font-weight: bold;
  font-size: 18px;
  background-color:#D3D3D3;
  border: 1px solid #D3D3D3;
}
</style>
@include('qc.rework.layouts.navbarform')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  @foreach($dataDetail as $dt)
    <!-- Main content -->
    <section class="content" style="padding-top:5px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                <center>
                <p class="div5 col-12" style="font-size:20px"> WO {{$dt['no_wo']}} Terpenuhi</p>
                </center>
                @endif
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <center>
                          <div class="div1">
                            <div class="container">
                              <label for="WO" style="color:white;font-size:20px">WO :</label> 
                              <label for="WO" style="color:white;font-size:20px">{{$dt['no_wo']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:20px">TARGET WO :</label> 
                              <label for="WO" style="font-size:20px">{{$dt['target_wo']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:20px">TERPENUHI :</label> 
                              <label for="WO" id="result" style="font-size:20px">{{$dt['target_terpenuhi']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
                  @include('qc.rework.qc.partials.form-auto')
                <br>
                <label for="wo"> List untuk dikerjakan hari ini</label>
                <div class="row">
                  @foreach($dataTarget as $d)
                    @if($d->proses != 2 && $d->id != $kerjakan->id)
                    <div class="col-1">
                      <form action="{{ route('rework.pindah', $d->id)}}" method="post">
                      @csrf
                          <input type="hidden" id="id" name="id" value="{{$d->id}}">
                          <input type="hidden" id="target_id" name="target_id" value="{{$d->id}}">
                          <input type="hidden" id="tgl_pengerjaan" name="tgl_pengerjaan" value="{{$d->tgl_pengerjaan}}">
                          <input type="hidden" id="no_wo" name="no_wo" value="{{$d->no_wo}}">
                          <input type="hidden" id="id_line" name="id_line" value="{{$d->id_line}}">
                          <input type="hidden" id="target_wo" name="target_wo" value="{{$d->target_wo}}">
                          <input type="hidden" id="proses" name="proses" value="1">
                          <button type="submit" class="btn btn-secondary btn-md" onclick="return confirm('Pindah WO ?');"><i class="far fa-file-alt"></i> {{$d->no_wo}}</button>
                      </form>
                    </div>
                    @endif
                  @endforeach
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
  @endforeach
  </div>
@include('qc.rework.layouts.footer')
<script type="text/javascript">

$(".qty1").on("blur", function(){
    var sum=0;
    $(".qty1").each(function(){
        if($(this).val() !== "")
          sum += parseInt($(this).val(), 10);   
    });

    $("#result").html(sum);
});

</script>