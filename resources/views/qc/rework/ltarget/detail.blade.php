@include('qc.rework.layouts.header')
<style> 
.div1 {
  width: 150px;
  height: 40px;
  padding: 5px;
  background-color:red;
  border: 1px solid red;
}

.div2 {
  width: 250px;
  height: 40px;  
  padding: 5px;
  background-color:yellow;
  border: 1px solid yellow;
}

.div3 {
  width: auto;
  height: auto;  
  padding: 5px;
  border: 1px solid black;
}

.div4 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#228B22;
  border: 1px solid #228B22;
}

.div5 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#7FFF00;
  border: 1px solid #7FFF00;
}

.div6 {
  width: auto;
  height: auto;
  font-weight: bold;
  font-size: 13px;
  background-color:#20B2AA;
  border: 1px solid #20B2AA;
}

.div7 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#FFE4B5;
  border: 1px solid #FFE4B5;
}

.div8 {
  width: auto;
  height: auto;
  padding: 5px;
  font-weight: bold;
  font-size: 13px;
  background-color:#FFA500;
  border: 1px solid #FFA500;
}

.div9 {
  width: auto;
  height: auto;
  padding: 5px;
  text-align: center;
  font-weight: bold;
  font-size: 13px;
  background-color:#D3D3D3;
  border: 1px solid #D3D3D3;
}
</style>
@include('qc.rework.layouts.navbar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
  @foreach($dataDetail as $dt)
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">Detail QC Rework [ {{$dt['tgl_pengerjaan']}} ]</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-2">
                    <div class="div1">
                      <font style="color:white">WO : {{$dt['no_wo']}}</font>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="div2">
                      TARGET WO : {{$dt['target_wo']}}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="div2">
                      TERPENUHI : {{$dt['target_terpenuhi']}}
                    </div>
                  </div>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                        @include('qc.rework.ltarget.partials.form-detail', ['submit' => 'Create'])
                </form>
                <br>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm col-2"><i class="fas fa-arrow-circle-left"></i> Back</a>
                @if(auth()->user()->role == 'SYS_ADMIN' || auth()->user()->role == 'QCR_Admin' || auth()->user()->role == 'QCR_PIC')
                <a href="{{ route('ltarget.summary', $dt['target_id'])}}" class="btn btn-info btn-sm col-2"><i class="fas fa-home"></i> Index</a>
                @if($dt['target_terpenuhi'] != $dt['target_wo'])
                <a href="{{route('details.edit', $dt['id'])}}" class="btn btn-warning btn-sm col-2"><i class="fas fa-edit"></i> Edit</a>
                @endif
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  @endforeach
  </div>
@include('qc.rework.layouts.footer')
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>