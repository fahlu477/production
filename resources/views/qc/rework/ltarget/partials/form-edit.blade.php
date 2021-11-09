<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}" placeholder="Insert Nama Modul">
<div class="form-group">
    <label for="roll">Target WO</label>
    <input type="text" class="form-control" id="target_wo" name="target_wo" value="{{$data->target_wo}}" placeholder="Insert Nama Modul">
</div>
<input type="hidden" class="form-control" id="edited_by" name="edited_by" value="{{ Auth::user()->nama }}" placeholder="Insert Edited By">
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
