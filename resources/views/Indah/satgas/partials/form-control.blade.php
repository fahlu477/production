
<div class="form-group">
            <label  class="col-form-label">Satgas</label>
            <select name="nama" id="nama" class="form-control" required="required">
                    <option selected></option>
                    @foreach($user as $row)
                      <option name="nama" value="{{ $row->nama }}"  >{{ $row->nama }}</option>
                    @endforeach
            </select>                                          
</div>


<div class="form-group">
            <label  class="col-form-label">Jabatan</label>
            <select name="jabatan" id="jabatan" class="form-control" required="required">
                      <option name="jabatan" value="kehormatan"  >Kehormatan</option>
                      <option name="jabatan" value="kehormatan"  >Ketua</option>
                      <option name="jabatan" value="kehormatan"  >Wakil Ketua</option>
                      <option name="jabatan" value="kehormatan"  >Penasehat</option>
                      <option name="jabatan" value="kehormatan"  >Pengawas</option>
                      <option name="jabatan" value="kehormatan"  >Pelaksana Piket</option>
                    
            </select>                                          
</div>
<div>
    <label for="roll">Kuota ✔</label>
    <input type="number" class="form-control" id="kuota_like" name="kuota_like" value="" placeholder="Kuota">
</div>
<div class="form-group">
    <label for="roll">Kuota ❌</label>
    <input type="number" class="form-control" id="kuota_dislike" name="kuota_dislike" value="" placeholder="Kuota">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
