<input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
<input type="hidden" style="width:4em;text-align:center;" name="proses" id="proses" value="2"> 
<input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$dt['target_id']}}"> 
<br>
<div class="row">
    <div class="col-md-12">
        <div class="div3">
             <center>
                <form action="{{ route('auto.fg', $dt['id'])}}" method="post">
                    @csrf
                    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="fg" id="fg" value="{{$dt['fg']}}" disabled>
                    <div>
                        @if($dt['target_wo'] > $dt['target_terpenuhi'])
                        <button type="submit" class="div4">FINISH GOOD</button>
                        @endif
                        @if($dt['target_wo'] == $dt['target_terpenuhi'])
                        <button type="submit" class="div4" disabled>FINISH GOOD</button>
                        @endif
                    </div> 
                </form>
            </center> 
        </div>
    </div>
</div>
<div class="row" style="pading-top:10px;">
    <div class="col-md-6">
        <center><label for="kotak1">STICHING</label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.ros', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="ros" id="ros" value="{{$dt['ros']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6">RUN OF STICH</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>RUN OF STICH</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.broken', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="broken" id="broken" value="{{$dt['broken']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6">BROKEN</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>BROKEN</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:3px">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.skip', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="skip" id="skip" value="{{$dt['skip']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6">SKIP</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>SKIP</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.pktw', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="pktw" id="pktw" value="{{$dt['pktw']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6" >PUCKERING / TWISTING</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>PUCKERING / TWISTING</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:3px">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.crooked', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="crooked" id="crooked" value="{{$dt['crooked']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6">CROOKED</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>CROOKED</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.pleated', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="pleated" id="pleated" value="{{$dt['pleated']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div6">PLEATED</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div6" disabled>PLEATED</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <center><label for="kotak1">APPERANCE</label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.shading', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="shading" id="shading" value="{{$dt['shading']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8">SHADING</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>SHADING</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.dof', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="dof" id="dof" value="{{$dt['dof']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8" >DEFECT ON LAB</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>DEFECT ON LAB</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:3px;">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.dirty', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="dirty" id="dirty" value="{{$dt['dirty']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8">DIRTY, OIL</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>DIRTY, OIL</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.shiny', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="shiny" id="shiny" value="{{$dt['shiny']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8">SHINY</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>SHINY</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:3px;">
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.bs', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="bs" id="bs" value="{{$dt['bs']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8" >BAD SHAPE</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>BAD SHAPE</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                        <form action="{{ route('auto.unb', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="unb" id="unb" value="{{$dt['unb']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div8" >UN - BALANCE</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div8" disabled>UN - BALANCE</button>
                                @endif
                            </div> 
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <center><label for="kotak1">ATTACHMENT</label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-4">
                    <div class="container">
                        <center>
                        <form action="{{ route('auto.htl', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="htl" id="htl" value="{{$dt['htl']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div7" >HTL/LABEL</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div7" disabled>HTL/LABEL</button>
                                @endif
                            </div> 
                        </form>
                        </center>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container">
                        <center>
                        <form action="{{ route('auto.button', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="button" id="button" value="{{$dt['button']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div7" >BUTTON (HOLE)</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div7" disabled>BUTTON (HOLE)</button>
                                @endif
                            </div> 
                        </form>
                        </center>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="container">
                        <center>
                        <form action="{{ route('auto.print', $dt['id'])}}" method="post">
                            @csrf
                            <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                            <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                            <input type="number" class="qty1" style="width:4em;text-align:center;" name="print" id="print" value="{{$dt['print']}}" disabled>
                            <div>
                                @if($dt['target_wo'] > $dt['target_terpenuhi'])
                                <button type="submit" class="div7" >PRINT, EMBRO</button>
                                @endif
                                @if($dt['target_wo'] == $dt['target_terpenuhi'])
                                <button type="submit" class="div7" disabled>PRINT, EMBRO</button>
                                @endif
                            </div> 
                        </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <center><label for="kotak1"><font color="white">aaa</font></label></center>
        <div class="div3">
            <div class="container">
                <center>
                <form action="{{ route('auto.ip', $dt['id'])}}" method="post">
                    @csrf
                    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="ip" id="ip" value="{{$dt['ip']}}" disabled>
                    <div>
                        @if($dt['target_wo'] > $dt['target_terpenuhi'])
                        <button type="submit" class="div5">IRON PROBLEM</button>
                        @endif
                        @if($dt['target_wo'] == $dt['target_terpenuhi'])
                        <button type="submit" class="div5" disabled>IRON PROBLEM</button>
                        @endif
                    </div> 
                </form>
                </center>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding-top:10px;">
    <div class="col-md-12">
        <div class="div3">
            <div class="row">
                <div class="col-md-3">
                    <center>
                    <form action="{{ route('auto.sticker', $dt['id'])}}" method="post">
                        @csrf
                        <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                        <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="sticker" id="sticker" value="{{$dt['sticker']}}" disabled>
                        <div>
                            @if($dt['target_wo'] > $dt['target_terpenuhi'])
                            <button type="submit" class="div5">STICKER</button>
                            @endif
                            @if($dt['target_wo'] == $dt['target_terpenuhi'])
                            <button type="submit" class="div5" disabled>STICKER</button>
                            @endif
                        </div> 
                    </form>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                    <form action="{{ route('auto.meas', $dt['id'])}}" method="post">
                        @csrf
                        <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                        <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="meas" id="meas" value="{{$dt['meas']}}" disabled>
                        <div>
                            @if($dt['target_wo'] > $dt['target_terpenuhi'])
                            <button type="submit" class="div5">MEAS</button>
                            @endif
                            @if($dt['target_wo'] == $dt['target_terpenuhi'])
                            <button type="submit" class="div5" disabled>MEAS</button>
                            @endif
                        </div> 
                    </form>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                    <form action="{{ route('auto.trimming', $dt['id'])}}" method="post">
                        @csrf
                        <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                        <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="trimming" id="trimming" value="{{$dt['trimming']}}" disabled>
                        <div>
                            @if($dt['target_wo'] > $dt['target_terpenuhi'])
                            <button type="submit" class="div5"> TRIMMING</button>
                            @endif
                            @if($dt['target_wo'] == $dt['target_terpenuhi'])
                            <button type="submit" class="div5" disabled> TRIMMING</button>
                            @endif
                        </div> 
                    </form>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                    <form action="{{ route('auto.other', $dt['id'])}}" method="post">
                        @csrf
                        <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
                        <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="other" id="other" value="{{$dt['other']}}" disabled>
                        <div>
                            @if($dt['target_wo'] > $dt['target_terpenuhi'])
                            <button type="submit" class="div5">OTHER</button>
                            @endif
                            @if($dt['target_wo'] == $dt['target_terpenuhi'])
                            <button type="submit" class="div5" disabled>OTHER</button>
                            @endif
                        </div> 
                    </form>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<form action="{{ route('auto.remark', $dt['id'])}}" method="post">
@csrf
<input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
<input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
<div class="form-group">
    <textarea class="col-12" name="string1" id="string1" style="height:4em;" placeholder="Insert Remark">{{$dt['string1']}}</textarea>
</div>
<div>
    <button type="submit" class="btn btn-info btn-sm col-3" onclick="return confirm('Simpan Remark ?');"><i class="fas fa-file-download"></i> Simpan Remark</button>
</div> 
</form>
<br><br>
@if($dt['file'] == null)
<label for="foto">Hanya bisa upload 1 foto setelah foto di upload form ini akan menghilang</label>
<form action="{{ route('auto.file', $dt['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
    <input type="file" name="file" id="file" required>
    <br><br>
    <div>
        <button type="submit" class="btn btn-info btn-sm col-3" onclick="return confirm('Simpan Foto ?');"><i class="fas fa-file-download"></i> Simpan Foto</button>
    </div> 
</form>
@endif
@if($dt['file'] > null)
<div class="div3 col-3">
    <center><img class="col-10" style="height:auto;padding:20px;"  src="{{ url('rework/qc/images/'.$dt['file']) }}"> </center>
</div>
<form action="{{ route('hapus.file', $dt['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
    <input type="hidden" style="width:4em;text-align:center;" name="file" id="file" value=""> 
    <div style="padding-top:10px">
        <button type="submit" class="btn btn-danger btn-sm col-3" onclick="return confirm('Hapus Foto ?');"><i class="far fa-trash-alt"></i> Hapus Foto</button>
    </div> 
</form>
@endif
<br>
@if($dt['target_terpenuhi'] == $dt['target_wo'])
<form action="{{ route('auto.selesai')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}"> 
    <input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$kerjakan->id}}"> 
    <div>
    <button type="submit" class="btn btn-success btn-sm col-3" onclick="return confirm('Simpan data ?');"><i class="far fa-check-circle"></i> Selesai</button>
    </div> 
</form>
@endif

