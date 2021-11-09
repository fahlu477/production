<input type="hidden" id="id" name="id" value="{{$target['id']}}">
<input type="hidden" id="target_id" name="target_id" value="{{$target['id']}}">
<input type="hidden" id="tgl_pengerjaan" name="tgl_pengerjaan" value="{{$todayDate}}">
<input type="hidden" id="tgl_pengerjaan2" name="tgl_pengerjaan2" value="{{$todayDate}}">
<input type="hidden" id="no_wo" name="no_wo" value="{{$target['no_wo']}}">
<input type="hidden" id="id_line" name="id_line" value="{{$target['id_line']}}">
<div class="form-group">
    <label for="roll">Target WO</label>
    <input type="text" class="form-control" id="target_wo" name="target_wo" value="" placeholder="Insert Target WO" reuired>
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
