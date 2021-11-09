<div class="form-group" style="padding-right:10px">
    <label>Pilih Tahun</label>
    <div class="input-group date" id="reservationdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tahun" id="tahun" required/>
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