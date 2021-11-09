<div class="form-group">
    <label>No WO</label>
    <select class="form-control select2bs4" style="width: 100%;"  name="no_wo" id="no_wo" required>
        <option value=""></option>    
        @foreach($dataWo as $a)
            <option value="{{$a['no_wo']}}">{{$a['no_wo']}}</option>
        @endforeach
    </select>
</div>
<input type="hidden" name="id_line" value="{{($id)}}">
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
