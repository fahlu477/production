<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">
<input type="hidden" class="form-control" id="nik" name="nik" value="{{$data->nik}}">
<div class="form-group">
    <label >Nama</label>
<input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama}}" readonly>
</div>
<div class="form-group">
    <label >Jabatan</label>
<input type="text" class="form-control" id="jabatan" name="jabatan" value="{{$data->jabatan}}">
</div>
<div class="form-group">
    <label >Kuota ✔</label>
    <input type="number" class="form-control" id="kuota_like" name="kuota_like" value="{{$data->kuota_like}}" placeholder="Insert Kode Modul">
</div>
<div class="form-group">
    <label >Kuota ❌</label>
    <input type="number" class="form-control" id="kuota_dislike" name="kuota_dislike" value="{{$data->kuota_dislike}}" placeholder="Insert Nama Modul">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
