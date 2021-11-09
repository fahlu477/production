<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">
<input type="hidden" class="form-control" id="modul" name="modul" value="{{$data->modul}}">
<div class="form-group">
    <label for="roll">Kode Line</label>
    <input type="text" class="form-control" id="string1" name="string1" value="{{$data->string1}}" placeholder="Insert Kode Modul">
</div>
<div class="form-group">
    <label for="roll">Nama Line</label>
    <input type="text" class="form-control" id="string2" name="string2" value="{{$data->string2}}" placeholder="Insert Nama Modul">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
