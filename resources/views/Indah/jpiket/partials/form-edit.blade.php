<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">
<input type="hidden" class="form-control" id="day" name="nik" value="{{$data->day}}">
<input type="text" class="form-control" id="hari" name="nama" value="{{$data->hari}}"readonly>
<div class="form-inline">
    <div class="form-group">
                <label  class="col-form-label">Petugas 1</label>
                <select name="petugas1" id="petugas1" class="form-control" style="width: 95%;" placeholder="Select Petugas2">
                        <option selected></option>        
                        <option selected>{{$data->petugas1}}</option>
                        @foreach($satgas as $row)
                        <option name="nama" value="{{ $row['nama'] }}">{{ $row['nama'] }}</option>
                        @endforeach
                </select>                                          
    </div>

    <div class="form-group">
                <label  class="col-form-label">Petugas 2</label>
                <select name="petugas2" id="petugas2" class="form-control" style="width: 95%;">
                        <option selected></option>        
                        <option selected>{{$data->petugas2}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>

    <div class="form-group">
                <label  class="col-form-label">Petugas 3</label>
                <select name="petugas3" id="petugas3" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas3}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>

    <div class="form-group">
                <label  class="col-form-label">Petugas 4</label>
                <select name="petugas4" id="petugas4" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas4}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 5</label>
                <select name="petugas5" id="petugas5" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas5}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 6</label>
                <select name="petugas6" id="petugas6" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas6}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 7</label>
                <select name="petugas7" id="petugas7" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas7}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 8</label>
                <select name="petugas8" id="petugas8" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas8}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 9</label>
                <select name="petugas9" id="petugas9" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas9}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>
    <div class="form-group">
                <label  class="col-form-label">Petugas 10</label>
                <select name="petugas10" id="petugas10" class="form-control" style="width: 95%;">
                        <option selected></option>
                        <option selected>{{$data->petugas10}}</option>
                        @foreach($petugas as $row)
                        <option name="nama" value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                </select>                                          
    </div>


</div>
<div>
    <label> </label>
</div>

<button type="submit" class="btn btn-primary btn-block">{{$submit}}</button>
