@include('qc.rework.layouts.header')
<style> 
.div1 {
  width: 200px;
  height: 40px;
  padding: 5px;
  background-color:red;
  border: 1px solid red;
}

.div2 {
  width: 200px;
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">QC Rework Table</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-11">
                    <div class="row">
                      <div class="col-md-4">
                        <center>
                          <div class="div1">
                            <div class="container">
                              <label for="WO" style="color:white;font-size:15px">WO :</label> 
                              <label for="WO" style="color:white;font-size:15px">{{$kerjakan->no_wo}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:15px">TARGET WO :</label> 
                              <label for="WO" style="font-size:15px">{{$kerjakan->target_wo}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                      <div class="col-md-4">
                        <center>
                          <div class="div2">
                            <div class="container">
                              <label for="WO" style="font-size:15px">TERPENUHI :</label> 
                              <label for="WO" id="result" style="font-size:15px">{{$kerjakan->target_terpenuhi}}</label> 
                            </div>
                          </div>
                        </center>
                      </div>
                    </div>
                  </div>
                </div>
                <form action="{{ route('details.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        @include('qc.rework.qc.partials.form-edit', ['submit' => 'Update'])
                </form>
                <br>
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
  </div>
@include('qc.rework.layouts.footer')
<script type="text/javascript">

$(".qty1").on("blur", function(){
    var sum=0;
    $(".qty1").each(function(){
        if($(this).val() !== "")
          sum += parseInt($(this).val(), 10);   
    });

    $("#result").html(sum);
});

</script>