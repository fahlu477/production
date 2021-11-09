<label for="pabrik">Pabrik</label>
<div class="form-group clearfix">
    <div class="row">
        <div class="col-sm-2">
            <div class="icheck-primary">
                <input type="radio" name="branch" id="cln" value="CLN" {{ (auth()->user()->branch == 'CLN' && auth()->user()->branchdetail == 'CLN') ? "checked" : "" }}>
                <label for="cln"> Gistex Cileunyi </label>
            </div>
            <div class="icheck-primary">
                <input type="radio" id="maja" name="branch" value="MAJA1" {{ (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM1') ? "checked" : "" }}>
                <label for="maja"> Gistex Majalengka 1 </label>
            </div>
            <div class="icheck-primary">
                <input type="radio" id="maja2" name="branch" value="MAJA2" {{ (auth()->user()->branch == 'MAJA' && auth()->user()->branchdetail == 'GM2') ? "checked" : "" }}>
                <label for="maja2"> Gistex Majalengka 2</label>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="icheck-primary">
                <input type="radio" id="solo" name="branch" value="GS" {{ (auth()->user()->branch == 'GS' && auth()->user()->branchdetail == 'GS' ) ? "checked" : "" }}>
                <label for="solo"> Gistex Solo </label>
            </div>
            <div class="icheck-primary">
                <input type="radio" id="kalibenda" name="branch" value="GK" {{ (auth()->user()->branch == 'GK' && auth()->user()->branchdetail == 'GK') ? "checked" : "" }}>
                <label for="kalibenda"> Gistex Kalibenda </label>
            </div>
        </div>
    </div>
</div>
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