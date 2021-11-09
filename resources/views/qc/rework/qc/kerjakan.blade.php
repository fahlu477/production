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
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#228B22;
  border: 1px solid #228B22;
}

.div5 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#7FFF00;
  border: 1px solid #7FFF00;
}

.div6 {
  width: auto;
  height: auto;
  font-weight: bold;
  font-size: 13px;
  background-color:#20B2AA;
  border: 1px solid #20B2AA;
}

.div7 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#FFE4B5;
  border: 1px solid #FFE4B5;
}

.div8 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#FFA500;
  border: 1px solid #FFA500;
}

.div9 {
  width: auto;
  height: auto;
  padding: 5px;
  text-align: center;
  font-weight: bold;
  font-size: 13px;
  background-color:#D3D3D3;
  border: 1px solid #D3D3D3;
}
</style>
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
  @foreach($dataDetail as $dt)
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">QC Rework Table</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <center>
                          <div class="div1">
                            <div class="container">
                              <label for="WO" style="color:white;font-size:15px">WO :</label> 
                              <label for="WO" style="color:white;font-size:15px">{{$dt['no_wo']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:15px">TARGET WO :</label> 
                              <label for="WO" style="font-size:15px">{{$dt['target_wo']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:15px">TERPENUHI :</label> 
                              <label for="WO" id="result" style="font-size:15px">{{$dt['target_terpenuhi']}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
                <form action="{{ route('detail.manualstore', $dt['target_id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                        @include('qc.rework.qc.partials.form-control', ['submit' => 'Simpan'])
                </form>
                @if($dt['target_terpenuhi'] == $dt['target_wo'])
                  <form action="{{ route('auto.selesai')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                      <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                      <input type="hidden" style="width:4em;text-align:center;" name="proses" id="proses" value="2"> 
                      <div>
                          <button type="submit" class="btn btn-success btn-sm col-2" onclick="return confirm('Selesaikan Pekerjaan ?');"><i class="far fa-check-circle"></i> Selesai</button>
                      </div> 
                  </form>
                @endif
                <br>
                @if($dt['file'] == null)
                <label for="foto">Hanya bisa upload 1 foto setelah foto di upload form ini akan menghilang</label>
                <form action="{{ route('auto.file', $dt['id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                    <input type="file" name="file" id="file" required>
                    <br><br>
                    <div>
                        <button type="submit" class="btn btn-info btn-sm col-2" onclick="return confirm('Simpan Foto ?');"><i class="fas fa-file-download"></i> Simpan Foto</button>
                    </div> 
                </form>
                @endif

                @if($dt['file'] != null)
                <div class="div3 col-3">
                    <center><img class="col-10" style="height:auto;padding:20px;"  src="{{ url('rework/qc/images/'.$dt['file']) }}"> </center>
                </div>
                <form action="{{ route('hapus.file', $dt['id'])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                    <input type="hidden" style="width:4em;text-align:center;" name="file" id="file" value=""> 
                    <div style="padding-top:10px">
                        <button type="submit" class="btn btn-danger btn-sm col-2" onclick="return confirm('Hapus Foto ?');"><i class="far fa-trash-alt"></i> Hapus Foto</button>
                    </div> 
                </form>
                @endif
                <br><br>
                <label for="wo"> List untuk dikerjakan hari ini</label>
                <div class="row">
                  @foreach($dataTarget as $d)
                    @if($d->proses != 2 && $d->id != $dt['target_id'])
                    <div class="col-1">
                      <form action="{{ route('rework.pindah', $d['id'])}}" method="post">
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