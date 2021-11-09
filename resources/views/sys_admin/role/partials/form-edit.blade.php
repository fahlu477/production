<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">
<div class="form-group">
    <label for="roll">Kode Role</label>
    <input type="text" class="form-control" id="kode_role" name="kode_role" value="{{$data->kode_role}}" placeholder="Insert Kode Line">
</div>
<div class="form-group">
    <label for="roll">Nama Role</label>
    <input type="text" class="form-control" id="nama_role" name="nama_role" value="{{$data->nama_role}}" placeholder="Insert Nama Line">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
