
<!-- radio -->
<label for="pabrik">Pabrik</label>
<div class="form-group clearfix">
    <div class="row">
        <div class="col-md-3">
            @foreach($dataBranch as $db)
            <div class="icheck-primary">
                <input type="radio" name="branch" id="{{$db->branchdetail}}" value="{{$db->id}}">
                <label for="{{$db->branchdetail}}"> {{$db->nama_branch}}</label>
            </div>
            @endforeach
    </div>
</div>
<br>
<div class="form-group">
    <label>Tanggal Pengerjaan</label>
    <div class="input-group date" id="reservationdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal" placeholder="Pilih Tanggal" required/>
        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
