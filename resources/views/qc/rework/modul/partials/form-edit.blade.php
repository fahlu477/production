<input type="hidden" class="form-control" id="id" name="id" value="{{ $data->id }}">
<div class="form-group">
    <label for="roll">Kode Modul</label>
    <input type="text" class="form-control" id="kode" name="kode" value="{{ $data->kode }}" placeholder="Insert Kode Modul">
</div>
<div class="form-group">
    <label for="roll">Nama</label>
    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" placeholder="Insert Nama Modul">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
