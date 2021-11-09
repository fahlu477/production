<div class="form-group">
    <label for="roll">Kode Line</label>
    <input type="text" class="form-control" id="string1" name="string1" value="" placeholder="Insert Kode Line" required>
</div>
<div class="form-group">
    <label for="roll">Nama Line</label>
    <input type="text" class="form-control" id="string2" name="string2" value="" placeholder="Insert Nama Line" required>
</div>
<div class="form-group">
    <input type="hidden" class="form-control" id="branch" name="branch" value="{{ Auth::user()->branch }}" placeholder="Insert Branch">
</div>
<div class="form-group">
    <input type="hidden" class="form-control" id="branch_detail" name="branch_detail" value="{{ Auth::user()->branchdetail }}" placeholder="Insert Branch Detail">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
