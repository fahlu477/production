<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PT.Gistex Garmen Indonesia</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('/assets/img/ggi.png')}}" rel="icon">
  <link href="{{asset('/assets/img/ggi.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="{{asset('/assets/vendor/animate.css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/boxicons/css/boxicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/glightbox/css/glightbox.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/remixicon/remixicon.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendor/swiper/swiper-bundle.min.css')}}">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="fixed-top d-flex align-items-center">

    <div class="container d-flex justify-content-center justify-content-md-between">

      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"> <a href="mailto:sales-ggi@gistexgroup.com">sales-ggi@gistexgroup.com</a></i>
        <i class="bi bi-envelope d-flex align-items-center ms-4"><a href="mailto:g-shield@gistexgroup.com">g-shield@gistexgroup.com</a></i>
        <i class="bi bi-telephone d-flex align-items-center ms-4"><span>+62-22-7796683</span></i>
      </div>

      <div class="social-links d-none d-md-flex">
        <a href="https://www.linkedin.com/in/gistexgarmen-pt-b33301211/" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>

    </div>

  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">

    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <!-- <h1><a href="index.html">My<span>Biz</span></a></h1> -->

        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{url('/')}}"><img src="{{ asset('/assets/img/PT.-Gistex-Garmen-Indonesia.png') }}" alt="" class="img-fluid"></a>

      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#services">Technology</a></li>
          <li><a class="nav-link scrollto " href="#portfolio">Product</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a a class="nav-link scrollto" href="{{ route('login') }}">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->

    </div>

  </header>
  <!-- End Header -->



  <!-- ======= Hero Section ======= -->

  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(assets/img/cover.png);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h4 class="animate__animated animate__fadeInDown" style="color:#f9b935;">Welcome to <span>Gistex Garmen Indonesia</span></h4>
                <h2 class="animate__animated animate__fadeInUp">QUALITY PRODUCT <br>EXCEPTIONAL CUSTOMER SERVICE</h2>
                <a href="#about" class="btn-get-started scrollto animate__animated animate__fadeInUp">Read More</a>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url(assets/img/cover2.png);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">SPORT PERFOMANCE WEAR</h2>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item" style="background-image: url(assets/img/cover3.png);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">BASIC</h2>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(assets/img/cover4.png);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">FASHION</h2>
              </div>
            </div>
          </div>

          <div class="carousel-item" style="background-image: url(assets/img/cover5.png);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">MEDICAL WEAR</h2>
              </div>
            </div>
          </div>

        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon ri-arrow-left-line" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon ri-arrow-right-line" aria-hidden="true"></span>
        </a>

      </div>

    </div>

  </section><!-- End Hero -->



  <main id="main">

    <!-- ======= About Section ======= -->

    <section id="about" class="about">

      <div class="container">

        <div class="section-title">

          <span>About Us</span>

          <h2>About Us</h2>

        </div>

        <div class="row content">

          <div class="text-center title">

            <h1>Our History</h1>

          </div>

          <div class="image col-lg-12 col-12 order-1 order-lg-2" style='background-image: url("assets/img/history.png");'></div>

        </div>

        <div class="row content mt-5">

          <div class="col-lg-6 my-auto">

            <h2>Our Goals</h2>

            <h3>Keep neighbourhood and local community in harmony</h3>

            <!-- </span> -->

          </div>

          <div class="col-lg-6 pt-4 pt-lg-0">

            <h3>Customers-oriented production</h3>

            <ul>

              <li><i class="ri-check-double-line"></i> Constant and continuous improvement in product quality</li>

              <li><i class="ri-check-double-line"></i> Delivery consistent quality</li>

              <li><i class="ri-check-double-line"></i> Ontime delivery</li>

            </ul>

            <h3>Fostering Human Resources</h3>

            <ul>

              <li><i class="ri-check-double-line"></i> To keep workplace energetic and fun</li>

              <li><i class="ri-check-double-line"></i> Promote team work, process improvement based on empowered human
                resources</li>

            </ul>

          </div>

        </div>



      </div>

    </section><!-- End About Section -->



    <!-- ======= About List Section ======= -->

    <section id="about-list" class="about-list">

      <div class="container">





        <div class="row content">

          <div class="text-center title">

            <h1>Our Production Units</h1>

          </div>

          <div class="image col-lg-12 col-12 order-1 order-lg-2" style='background-image: url("assets/img/factory.png");'></div>

        </div>

      </div>

    </section>

    <!-- End About List Section -->

    <section class="factory">

      <div class="container">

        <div class="row content">

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-1.png");'></div>

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-2.png");'></div>

        </div>

        <div class="row content mt-3">

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-3.png");'></div>

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-4.png");'></div>

        </div>

        <div class="row content mt-3">

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-5.png");'></div>

          <div class="col-lg-6 col-12 image" style='background-image: url("assets/img/factory-6.png");'></div>

        </div>

      </div>

    </section>

    <!-- ======= Counts Section ======= -->

    <section id="counts" class="counts">

      <div class="container position-relative">



        <div class="text-center title">

          <h3>Our Capacity</h3>

        </div>



        <div class="row counters">



          <div class="col-lg-3 col-12 text-center">

            <span data-purecounter-start="0" data-purecounter-end="62" data-purecounter-duration="1" class="purecounter"></span>

            <p>Product Line</p>

          </div>



          <div class="col-lg-3 col-12 text-center">

            <span data-purecounter-start="0" data-purecounter-end="4400" data-purecounter-duration="1" class="purecounter"></span>

            <p>Workers</p>

          </div>



          <div class="col-lg-3 col-12 text-center">

            <span data-purecounter-start="0" data-purecounter-end="2265" data-purecounter-duration="1" class="purecounter"></span>

            <p>Machine</p>

          </div>



          <div class="col-lg-3 col-12 text-center">

            <span data-purecounter-start="0" data-purecounter-end="2000000" data-purecounter-duration="1" class="purecounter"></span>

            <p>Pcs/Month</p>

          </div>



        </div>

      </div>

    </section><!-- End Counts Section -->

    <!-- ======= Services Section ======= -->

    <section id="services" class="services">

      <div class="container">

        <div class="section-title">

          <span>Technology</span>

          <h2>Technology</h2>

        </div>

        <div class="row">

          <div class="col-lg-12 col-12">

            <img src="assets/img/technology/technology-14.jpg" style="width:100%">

          </div>

          <!-- <div class="col-lg-6 col-6">

            <img src="assets/img/technology/technology-15.jpg" style="width:100%">

          </div> -->

        </div>

        <div class="row">
          <div class="col-lg-12 col-12">

            <img src="assets/img/technology/technology-15.jpg" style="width:100%">

          </div>
        </div>

        <!-- <div class="row mt-3">

            <div class="col-lg-4 col-12"><img src="assets/img/technology/technology-6.jpg" style="width:100%"></div>

            <div class="col-lg-4 col-12"><img src="assets/img/technology/technology-9.jpg" style="width:100%"></div>

            <div class="col-lg-4 col-12"><img src="assets/img/technology/technology-11.png" style="width:100%"></div>

          </div> -->

      </div>

    </section><!-- End Services Section -->



    <!-- ======= Portfolio Section ======= -->

    <section id="portfolio" class="portfolio section-bg">

      <div class="container">



        <div class="section-title">

          <span>Product</span>

          <h2>Product</h2>

        </div>

        <div class="row portfolio-container">

          <div class="col-lg-4 col-md-6 portfolio-item filter-spw">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-1.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Sport Perfomance Wear</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-15.jpg" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>

          <div id="myModal" class="modal">



            <!-- The Close Button -->

            <span class="close">&times;</span>



            <!-- Modal Content (The Image) -->

            <img class="modal-content" id="img01">



            <!-- Modal Caption (Image Text) -->

            <div id="caption"></div>

          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-basic">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-2.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Basic</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-14.jpg" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-basic">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-5.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Fashion</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-17.jpg" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-fashion">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-7.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Medical Wear</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-27.png" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-fashion">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-28.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Protective Coveral Suit</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-18.jpg" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-mw">

            <div class="portfolio-wrap">

              <img src="assets/img/portfolio/product-12.jpg" class="img-fluid" alt="">

              <div class="portfolio-info">

                <h4>Industrial Wear</h4>

                <div class="portfolio-links">

                  <a href="assets/img/portfolio/product-25.png" data-gallery="portfolioGallery"
                    class="portfolio-lightbox"><i class="bi bi-eye"></i></a>

                  <!-- <a href="portfolio-details.html" title="More Details"><i class="ri-links-fill"></i></a> -->

                </div>

              </div>

            </div>

          </div>



        </div>



      </div>

    </section><!-- End Portfolio Section -->

    <!-- ======= Contact Section ======= -->

    <section id="contact" class="contact">

      <div class="container">

        <div class="section-title">

          <span>Contact</span>

          <h2>Contact</h2>

          <!-- <p>Sit sint consectetur velit quisquam cupiditate impedit suscipit alias</p> -->

        </div>

      </div>



      <div class="map">

        <iframe style="border:0; width: 100%; height: 350px;"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.528524184117!2d107.75114691431737!3d-6.94680786993633!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c36647e51555%3A0x2e0addd9aec3c6c!2sPT%20Gistex%20Garmen%20Indonesia!5e0!3m2!1sen!2sid!4v1619404491919!5m2!1sen!2sid"
          frameborder="0" allowfullscreen></iframe>

      </div>



      <div class="container">



        <div class="info-wrap mt-5">

          <div class="row">

            <div class="col-lg-2 info">

            </div>

            <div class="col-lg-4 info">

              <i class="ri-map-pin-line"></i>

              <h4>Location 1:</h4>

              <p>Jl.Panyawungan KM.19, Cileunyi-Bandung,<br>

                40393, West Java, Indonesia</p>

            </div>

            <div class="col-lg-6 info mt-4 mt-lg-0">

              <i class="ri-phone-line"></i>

              <h4>Call:</h4>

              <p>Ph. +62-22-7796683 <br>Fx. +62-22-7796686</p>

            </div>

            <!-- <div class="col-lg-5 info mt-4 mt-lg-0">

              <i class="ri-mail-line"></i>

              <h4>Email:</h4>

              <p><strong>For Sport Performance Wear, Basic, and Fashion, please contact:</strong> <br>sales-ggi@gistexgroup.com<br><strong>For Medical Wear, Protective Coverall Suit, and Industrial Wear, please contact:</strong> <br>g-shield@gistexgroup.com</p>

            </div> -->

          </div>
          <br>
          <br>
          <div class="row">

            <div class="col-lg-2 info">

            </div>

            <div class="col-lg-4 info">

              <i class="ri-map-pin-line"></i>

              <h4>Location 2:</h4>

              <p>Jl.Raya Cirebon - Bandung, Dawuan,<br>
                Majalengka, 45453 West Java, Indonesia<br></p>

            </div>

            <div class="col-lg-6 info mt-4 mt-lg-0">

              <i class="ri-phone-line"></i>

              <h4>Call:</h4>

              <p>Ph. +62-283-664493</p>

            </div>

            <!-- <div class="col-lg-5 info mt-4 mt-lg-0">

              <i class="ri-mail-line"></i>

              <h4>Email:</h4>

              <p><strong>For Sport Performance Wear, Basic, and Fashion, please contact:</strong> <br>sales-ggi@gistexgroup.com<br><strong>For Medical Wear, Protective Coverall Suit, and Industrial Wear, please contact:</strong> <br>g-shield@gistexgroup.com</p>

            </div> -->

          </div>

          <div class="row mt-5">

            <h5 class="text-center">For Sport Performance Wear, Basic, and Fashion, please contact:</h5>

          </div>

          <div class="row mt-3">

            <div class="col-lg-2 info">

            </div>

            <div class="col-lg-4 info">

              <i class="ri-mail-line"></i>

              <h4>Email:</h4>

              <p>sales-ggi@gistexgroup.com</p>

            </div>

            <div class="col-lg-6 info mt-4 mt-lg-0">

              <i class="ri-whatsapp-line"></i>

              <h4>WhatsApp:</h4>

              <p>Firawaty +62 818-0223-3330<br>Suwartini +62 819-3126-6700<br>Synta +62 898-6859-688</p>

            </div>

          </div>

          <div class="row mt-5">

            <h5 class="text-center">For Medical Wear, Protective Coverall Suit, and Industrial Wear, please contact:
            </h5>

          </div>

          <div class="row mt-3">

            <div class="col-lg-2 info">

            </div>

            <div class="col-lg-4 info">

              <i class="ri-mail-line"></i>

              <h4>Email:</h4>

              <p>g-shield@gistexgroup.com</p>

            </div>

            <div class="col-lg-6 info mt-4 mt-lg-0">

              <i class="ri-whatsapp-line"></i>

              <h4>WhatsApp:</h4>

              <p>
                  Agustina Fung Fung +62-812-1263-4242 <br>
                  Victora Purwanti +62 812-234-1018 <br>
                  Sari Nany +62 813-2221-8179 <br>
                  Yuli Hartati +62 852-9555-4343
              </p>

            </div>



          </div>

        </div>
      </div>

    </section><!-- End Contact Section -->



  </main><!-- End #main -->



  <!-- ======= Footer ======= -->

  <footer id="footer">

    <div class="footer-top">

      <div class="container">

        <div class="row">



          <div class="col-lg-6 col-md-6">

            <div class="footer-info">

              <h3>PT.Gistex Garmen Indonesia</h3>

              <p>

                Jl.Panyawungan KM.19, Cileunyi-Bandung, 40393 <br>

                West Java, Indonesia<br><br>

                <strong>Phone:</strong> +62-22-7796683<br>

                <strong>Fax:</strong> +62-22-7796686<br>

                <br>

                <strong>For Sport Performance Wear, Basic, and Fashion, please contact:</strong><br>
                sales-ggi@gistexgroup.com<br>

                Firawaty <i class="bi bi-whatsapp"></i> +62 818-0223-3330 <br> Suwartini <i class="bi bi-whatsapp"></i>
                +62 819-3126-6700 <br> Synta <i class="bi bi-whatsapp"></i> +62 898-6859-688 <br><br>

                <strong>For Medical Wear, Protective Coverall Suit, and Industrial Wear, please contact:</strong><br>
                g-shield@gistexgroup.com<br>

                Agustina Fung Fung <i class="bi bi-whatsapp"></i> +62-812-1263-4242 <br>
                Victora Purwanti <i class="bi bi-whatsapp"></i> +62 812-234-1018 <br>
                Sari Nany <i class="bi bi-whatsapp"></i> +62 813-2221-8179 <br>
                Yuli Hartati <i class="bi bi-whatsapp"></i> +62 852-9555-4343

            </div>

          </div>



          <div class="col-lg-2 col-md-6 footer-links">

            <h4>NAVIGATION</h4>

            <ul>

              <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>

              <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>

              <li><i class="bx bx-chevron-right"></i> <a href="#services">Our Technology</a></li>

              <li><i class="bx bx-chevron-right"></i> <a href="#portfolio">Our Product</a></li>

              <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contact Us</a></li>

              <li><i class="bx bx-chevron-right"></i> <a href="inner-page.html">Career</a></li>

            </ul>

          </div>

          <div class="col-lg-4 col-md-12 footer-newsletter">

            <img src="assets/img/PT.-Gistex-Garmen-Indonesiaa.png" alt="" class="img-fluid">

            <div class="copyright">

              &copy; Copyright <strong><span>PT.Gistex Garmen Indonesia</span></strong>.

            </div>

            <br>

            <p class="text-center">Follow Us:</p>

            <div class="social-links mt-3 text-center">

              <a href="https://www.linkedin.com/in/gistexgarmen-pt-b33301211/" class="linkedin"><i class="bx bxl-linkedin"></i></a>

            </div>

          </div>



        </div>

      </div>

    </div>

  </footer>

  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/vendor/purecounter/purecounter.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

</body>



</html>