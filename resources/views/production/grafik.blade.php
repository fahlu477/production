@include('production.layouts.header')
@include('production.layouts.navbar')
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto);

body {
  font-family: Roboto, sans-serif;
}

#chart {
  max-width: 650px;
  margin: 35px auto;
}
</style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
     <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title"> SIGNAL TOWER</h3>
                                </div>
                                    <div class="card-body">

                        <canvas id="myChart" width="600" height="250"></canvas>
                        <div id="chart">
                            <div id="responsive-chart"></div>
                        </div>

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
  @include('production.layouts.footer')
{{-- <script type="text/javascript">
 
    // let dataRequest = null;
    //     axios.get('/production/grafik/getData')
    //       .then(response => {
    //           //disinilah data dari controller akan dapat
    //           console.log(response)

    //           //data yang didapatkan bisa dimasukkan variabel, dan diterusskan ke chartJS. CONTOH::
    //           dataRequest = response; //datanya tinggal disimpan ke variabel yang dibuat diatas. nanti dimasukkan ke chartJS
    //       })
    //       .catch((error) => console.log(error));
    new Chart(document.getElementById("mixed-chart"), {
        
    type: 'bar',
    data: {
      labels: ["1", "2", "3", "4", "5"],
      datasets: [{
          label: "Qty Req/Day (Pc)",
          type: "line",
          borderColor: "#8e5ea2",
          data: [16,18,21,21,24,40],
          fill: true
        }, {
          label: "total Delivery Time",
          type: "line",
          borderColor: "#3e95cd",
          data: [163,173,197,205,242,78,78],
          fill: true
        }, {
          label: "Avr Respon Time (Min)",
          type: "bar",
          backgroundColor: "rgba(#8e5ea2)",
          data: [1.23,0.76,0.23,0.27,0.2 ,0.2],
        }, {
          label: "Avr Delivery Time",
          type: "bar",
          backgroundColor: "rgba(0,0,0,0.2)",
          // backgroundColorHover: "#f30808",
          data: [37,30,29,29,33]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Chart Parameter Waktu Signal Tower'
      },
      legend: { display: true }
    }
});
</script> --}}

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  let dataRequest = null;

//   axios.get('production.grafik.getData')
//           .then(response => {
//               //disinilah data dari controller akan dapat
//               console.log(response)
//               this.getData = response.

//               //data yang didapatkan bisa dimasukkan variabel, dan diterusskan ke chartJS. CONTOH::
//               dataRequest = response; //datanya tinggal disimpan ke variabel yang dibuat diatas. nanti dimasukkan ke chartJS
//           })
//           .catch((error) => console.log(error));

//ini kurang tanda kurung
console.log("{{ route('production.grafik.getData')}}") ;
fetch("{{ route('production.grafik.getData') }}")
    .then(response => {
        return response.json();
    })
    .then(response => {
        console.log('response', response);
        dataRequest = response.data;
        console.log('dataRequest', dataRequest);
        console.log('dataRequest123', [30,40,45,50,49,60,70,91,125]);

        var options = {
            chart: {
                type: 'bar'
            },
            series: [{
            name: 'sales',
            //   data: [30,40,45,50,49,60,70,91,125],
            data: dataRequest,
            // data: dataRequest, //ini data yang dari controller di masukkan ke chartJS
            }],
            xaxis: {
            categories: [1,2,3,4,5,6,7, 8,9], // tanggal perbulan
            },
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    })
    .catch(error => {
        console.log(error);
    });

//Sepertinya kode dibawah sini hingga paling bawah dijalankan terlebih dahulu,
// sebelum request ajaxnya selesai (fetch). Ini namany asyncronous. Jadi masukin aja ke then nya


//nahh ini juga sama buat lakuin request, seperti axios dan fetch. Tapi ini pakai jquery
// function transaksi_status() {
//     $.ajax({
//         type: "GET",
//         url: "{{ route('production.grafik.getData') }}",
//         success: function (response) {
//             var labels = response.data.map(function (e) {
//                 return e.tanggal
//             })

//             var data = response.data.map(function (e) {
//                 return e.jumlah
//             })

//             var ctx = $('#myChart');
//             var config = {
//                 type: 'bar',
//                 data: {
//                     labels: labels,
//                     datasets: [{
//                         label: 'Transaksi Status',
//                         data: data,
//                         backgroundColor: 'rgba(75, 192, 192, 1)',

//                     }]
//                 }
//             };
//             var chart = new Chart(ctx, config);
//         },
//         error: function(xhr) {
//             console.log(xhr.responseJSON);
//         }
//     });
//   }
</script>
