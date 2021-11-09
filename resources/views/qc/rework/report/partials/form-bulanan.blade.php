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
</div>
<div class="form-group" style="padding-right:10px">
    <label>Pilih Bulan</label>
    <div class="input-group date" id="reservationdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="bulan" id="bulan" required/>
        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>
<div class="form-group">
    <div>
        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> {{$submit}}</button>
    </div>
</div>