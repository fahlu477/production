<input type="hidden" name="id_line" id="id_line" value="{{$mline->id}}">
<div class="form-group">
    <label for="roll">NO WO</label>
    <input type="text" class="form-control" id="no_wo" name="no_wo" value="{{$d['no_wo']}}" placeholder="Insert NO WO" disabled>
</div>
<div class="form-group">
    <label for="roll">Order Quantity</label>
    <input type="text" class="form-control" id="order_quantity" name="order_quantity" value="{{$d['order_quantity']}}" placeholder="Insert Order Quantity" disabled>
</div>
<div class="form-group">
    <label for="roll">Target WO</label>
    <input type="text" class="form-control" id="target_wo" name="target_wo" value="" placeholder="Insert Target WO" required>
</div>
<div class="form-group">
    <label for="roll">Tanggal Pengerjaan</label>
    <input type="date" class="form-control" id="tgl_pengerjaan" name="tgl_pengerjaan" placeholder="Insert Tanggal Pengerjaan" required>
</div>
<input type="hidden" class="form-control" id="no_wo" name="no_wo" value="{{$d['no_wo']}}" placeholder="Insert NO WO">
<input type="hidden" class="form-control" id="order_quantity" name="order_quantity" value="{{$d['order_quantity']}}" placeholder="Insert Order Quantity">
<input type="hidden" class="form-control" id="tgl_pengerjaan2" name="tgl_pengerjaan2" placeholder="Insert Tanggal Pengerjaan 2" value="{{$todayDate}}">
<input type="hidden" class="form-control" id="tgl_input" name="tgl_input" placeholder="Insert Tanggal Input" value="{{$todayDate}}">
<input type="hidden" class="form-control" id="created_by" name="created_by" value="{{ Auth::user()->nama }}" placeholder="Insert Created By">
<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
