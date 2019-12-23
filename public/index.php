<?php include "templates/header.php"; ?>

  <!-- Custom fonts for this theme -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="css/freelancer.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Auto GMS</a>
  </nav>

  <!-- Portfolio Section -->
  <section class="page-section portfolio" id="portfolio">
    <div class="container">
      <br>

      <!-- Portfolio Grid Items -->
      <div class="row">

        <!-- Portfolio Item 1 -->
        <div class="col-md-6 col-lg-4">
           <div class="portfolio-item mx-auto">
           [C]lienti
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/client/read.php" id="clienti">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/1.png" alt="">
          </div>
        </div>

        <!-- Portfolio Item 2 -->
        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto">
          [R]eparatii
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/reparatii/read.php" id="reparatii">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/2.png" alt="">
          </div>
        </div>

        <!-- Portfolio Item 3 -->
        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto">
          R[a]poarte
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/raport/read.php" id="rapoarte">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/3.png" alt="">
          </div>
        </div>

        <!-- Portfolio Item 4 -->
        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto"data-target="#portfolioModal1">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/4.png" alt="">
            [M]asini
          </div>  
        </div>

        <!-- Portfolio Item 5 -->
        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/piese/read.php" id="piese">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/5.png" alt="">
            [P]iese
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="portfolio-item mx-auto"data-target="#portfolioModal2">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <i class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <img class="img-fluid" src="img/6.png" alt="">
            [F]actura
          </div>  
        </div>

      </div>
      <!-- /.row -->

    </div>
  </section>
  
    <!-- Portfolio Modals -->

  <!-- Portfolio Modal 1 -->
  <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-labelledby="portfolioModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
		
        <div class="modal-body text-center page-section portfolio">
          <div class="container">
          <div class="row justify-content-center">
              
		<div class="col-md-4 col-lg-4 col-sm-4">
          <div class="portfolio-item mx-auto">
          <div class="text-justify">Masin[i] Clienti</div>
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/masina/read.php" id="masini_1">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/4.png" alt="">
          </div>
        </div>
			  
		<div class="col-md-4 col-lg-4 col-sm-4">
          <div class="portfolio-item mx-auto">
          <div class="text-justify">Lis[t]a Auto</div>
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/auto_list/read.php" id="masini_2">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/4_1.png" alt="">
          </div>
        </div>
			  
            </div>
			<br>
			<div class="row justify-content-center">
			<button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Inchide Fereastra
			</button>
			 </div>
			 
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Portfolio Modal 2 -->
  <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-labelledby="portfolioModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <i class="fas fa-times"></i>
          </span>
        </button>
		
        <div class="modal-body text-center page-section portfolio">
          <div class="container">
          <div class="row justify-content-center">
              
		<div class="col-md-4 col-lg-4 col-sm-4">
          <div class="portfolio-item mx-auto">
          <div class="text-justify">Crea[z]a Factura</div>
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/factura/read.php" id="factura_1">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/6.png" alt="">
          </div>
        </div>
			  
		<div class="col-md-4 col-lg-4 col-sm-4">
          <div class="portfolio-item mx-auto">
          <div class="text-justify">C[o]mpleteaza Factura</div>
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
              <div class="portfolio-item-caption-content text-center text-white">
                <a href="scripts/factura_complet/read.php" id="factura_2">
                <i class="fas fa-plus fa-3x"></i>
                </a>
              </div>
            </div>
            <img class="img-fluid" src="img/6_1.png" alt="">
          </div>
        </div>
			  
            </div>
			<br>
			<div class="row justify-content-center">
			<button class="btn btn-primary" href="#" data-dismiss="modal">
                  <i class="fas fa-times fa-fw"></i>
                  Inchide Fereastra
			</button>
			 </div>
			 
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include "templates/footer.php"; ?>