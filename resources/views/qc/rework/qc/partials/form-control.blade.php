<br>
<input type="hidden" style="width:4em;text-align:center;" name="id" id="id" value="{{$dt['id']}}">
<input type="hidden" style="width:4em;text-align:center;" name="target_id" id="target_id" value="{{$dt['target_id']}}"> 
<input type="hidden" style="width:4em;text-align:center;" name="target_wo" id="target_wo" value="{{$kerjakan->target_wo}}"> 
<div class="row">
    <div class="col-lg-3">
        <center><label for="kotak1"><font color="white">aaa</font></label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-6">
                    <center>
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="fg" id="fg" value="{{$dt['fg']}}">
                        <div class="div4">
                            FINISH GOOD
                        </div>
                    </center>   
                </div>
                <div class="col-md-6">
                    <center>
                        <input type="number" class="qty1" style="width:4em;text-align:center;" name="ip" id="ip" value="{{$dt['ip']}}">
                        <div class="div5">
                        IRON PROBLEM
                        </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="sticker" id="sticker" value="{{$dt['sticker']}}">
                    <div class="div5">
                        STICKER
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="meas" id="meas" value="{{$dt['meas']}}">
                    <div class="div5">
                        MEAS
                    </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="trimming" id="trimming" value="{{$dt['trimming']}}">
                    <div class="div5">
                        TRIMMING
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="other" id="other" value="{{$dt['other']}}">
                    <div class="div5">
                        OTHER
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <center><label for="kotak1">STITCHING</label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="ros" id="ros" value="{{$dt['ros']}}">
                    <div class="div6" style="padding-top:6px">
                        RUN OF STICH
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="broken" id="broken" value="{{$dt['broken']}}">
                    <div class="div6" style="padding-top:6px">
                        BROKEN
                    </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="skip" id="skip" value="{{$dt['skip']}}">
                    <div class="div6" style="padding-top:6px">
                        SKIP
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="pktw" id="pktw" value="{{$dt['pktw']}}">
                    <div class="div6">
                    PUCKERING / TWISTING
                    </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="crooked" id="crooked" value="{{$dt['crooked']}}">
                    <div class="div6" style="padding-top:6px">
                        CROOKED
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="pleated" id="pleated" value="{{$dt['pleated']}}">
                    <div class="div6" style="padding-top:6px">
                        PLEATED
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <center><label for="kotak1">ATTACHMENT</label></center>
        <div class="div3">
            <div class="container">
                <center>
                <input type="number" class="qty1" style="width:4em;text-align:center;" name="htl" id="htl" value="{{$dt['htl']}}">
                <div class="div7" style="padding-top:6px">
                HTL/LABEL
                </div>
                </center>
            </div>
            <div class="container" style="padding-top:10px">
                <center>
                <input type="number" class="qty1" style="width:4em;text-align:center;" name="button" id="button" value="{{$dt['button']}}">
                <div class="div7" style="padding-top:6px">
                BUTTON (HOLE)
                </div>
                </center>
            </div>
            <div class="container" style="padding-top:10px">
                <center>
                <input type="number" class="qty1" style="width:4em;text-align:center;" name="print" id="print" value="{{$dt['print']}}">
                <div class="div7" style="padding-top:6px">
                PRINT, EMBRO
                </div>
                </center>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <center><label for="kotak1">APPERANCE</label></center>
        <div class="div3">
            <div class="row">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="shading" id="shading" value="{{$dt['shading']}}">
                    <div class="div8" style="padding-top:6px">
                        SHADING
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="dof" id="dof" value="{{$dt['dof']}}">
                    <div class="div8" style="padding-top:6px">
                        DEFECT ON LAB
                    </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="dirty" id="dirty" value="{{$dt['dirty']}}">
                    <div class="div8" style="padding-top:6px">
                        DIRTY, OIL
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="shiny" id="shiny" value="{{$dt['shiny']}}">
                    <div class="div8" style="padding-top:6px">
                        SHINY
                    </div>
                    </center>
                </div>
            </div>
            <div class="row" style="padding-top:10px">
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="bs" id="bs" value="{{$dt['bs']}}">
                    <div class="div8" style="padding-top:6px">
                        BAD SHAPE
                    </div>
                    </center>
                </div>
                <div class="col-md-6">
                    <center>
                    <input type="number" class="qty1" style="width:4em;text-align:center;" name="unb" id="unb" value="{{$dt['unb']}}">
                    <div class="div8" style="padding-top:6px">
                        UN - BALANCE
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="form-group">
    <textarea class="col-lg-11" name="string1" id="string1" style="height:4em;" placeholder="Insert Remark">{{$dt['string1']}}</textarea>
</div>
@if($dt['target_terpenuhi'] != $dt['target_wo'])
<button type="submit" class="btn btn-primary btn-sm col-2" onclick="return confirm('Simpan data ?');"><i class="fas fa-file-download"></i> {{$submit}}</button>
@endif
