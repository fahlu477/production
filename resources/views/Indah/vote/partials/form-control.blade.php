

    <div class="col-lg-6">
    <div class="container">
            <center><img src="{{url('/assets3/gistex.jpg')}}"  height="130px" width="200px">
            <br>
                    <label>Gistex Garment Indonesia</label>
                    <br>
                    <label> INDAH</label>
                    <br>
                    <label> Inovatif Nyaman Disiplin Aman Hijau</label>
                    
        </center>
        </div>
        <div class="container">
            <input type="text" class="form-control" id="nik" name="nik" value="{{$data->nik}}" readonly><br>
            <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama}}" readonly><br>
            <input type="text" class="form-control" id="bagian" name="bagian" value="{{$data->departemensubsub}}" readonly>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="container">
            <center>
                <form action="{{ route('vote.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" class="form-control" id="nik" name="nik" value="{{$data->nik}}" >
                    <input type="hidden" class="form-control" id="nama" name="nama" value="{{$data->nama}}" >
                    <input type="hidden" class="form-control" id="bagian" name="bagian" value="{{$data->departemensubsub}}" >
                    <input type="hidden" class="form-control" id="tgl_vote" name="tgl_vote" value="{{$todayDate}}" >
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="created_by" name="created_by" value="{{ Auth::user()->nama }}" placeholder="Insert Created by">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="created_nik" name="created_nik" value="{{ Auth::user()->nik }}" placeholder="Insert Created nik">
                    </div>
                    <input type="hidden" class="form-control" id="like" name="like" value="1" placeholder="Like" required>
                    <div>
                    <button type="submit" class="btn bg-gradient-success col-sm-3" title="Like"><i class="fas fa-check"></i></button>
                    </div> 
                    <div class="product__rating-legend" style="padding-top:10px;"><a >Kuota Tersisa : <?= $l ?> <?= $lkhusus ?> </a><span></div>
                </form>
            </center>   
        </div>
        <div class="container">
            <center>
                <form action="{{ route('vote.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" class="form-control" id="nik" name="nik" value="{{$data->nik}}" >
                    <input type="hidden" class="form-control" id="nama" name="nama" value="{{$data->nama}}" >
                    <input type="hidden" class="form-control" id="bagian" name="bagian" value="{{$data->departemensubsub}}" >
                    <input type="hidden" class="form-control" id="tgl_vote" name="tgl_vote" value="{{$todayDate}}" >
                
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="created_by" name="created_by" value="{{ Auth::user()->nama }}" placeholder="Insert Created by">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="created_nik" name="created_nik" value="{{ Auth::user()->nik }}" placeholder="Insert Created nik">
                    </div>
                    <input type="hidden" class="form-control" id="like" name="dislike" value="1" placeholder="Like" required>
                    <div>
                    <button type="submit" class="btn bg-gradient-danger col-sm-3" title=""><i class="fas fa-times"></i></button>
                    <div class="product__rating-legend" style="padding-top:10px;"><a >Kuota Tersisa : <?= $dl?><?= $dlkhusus ?></a><span></div>
                    </div> 
                </form>
            </center>   
        </div>
    </div>

<center>


                




