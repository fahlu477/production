<input type="hidden" class="form-control" id="id_line" name="id_line" value="{{ $mline->id }}" placeholder="Insert ID LINE">
<label for="member">Member</label>
<select class="form-control select2bs4" style="width: 100%;" name="id_user" id="id_user">
    <option value="">Select Member</option>
    @foreach($member as $a)
        <option value="{{$a->nik}}">{{$a->nama}}</option>
    @endforeach
</select>
<div class="form-group">
    <input type="hidden" class="form-control" id="created_by" name="created_by" value="{{ Auth::user()->nama }}" placeholder="Insert Created by">
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
