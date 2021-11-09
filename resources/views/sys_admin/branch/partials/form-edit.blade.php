<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">
<div class="form-group">
    <label for="roll">Kode Branch</label>
    <input type="text" class="form-control" id="kode_branch" name="kode_branch" value="{{$data->kode_branch}}" placeholder="Insert Kode Branch">
</div>
<div class="form-group">
    <label for="roll">Branch Detail</label>
    <input type="text" class="form-control" id="branchdetail" name="branchdetail" value="{{$data->branchdetail}}" placeholder="Insert Branch Detail">
</div>
<div class="form-group">
    <label for="roll">Nama Branch</label>
    <input type="text" class="form-control" id="nama_branch" name="nama_branch" value="{{$data->nama_branch}}" placeholder="Insert Nama Branch">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
