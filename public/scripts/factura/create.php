<?php include "../../templates/header.php"; ?>

  <!-- Custom fonts for this theme -->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Theme CSS -->
  <link href="../../css/freelancer.min.css" rel="stylesheet">
  <link href="../../css/style.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="../../index.php">Auto GMS</a>
  <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Meniu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="read.php">Cauta</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="create.php">Adauga</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="update.php">Modifica</a>
          </li>
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="delete.php">Sterge</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <br><br><br><br><br>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "nume" => $_POST['nume'],
      "prenume"  => $_POST['prenume'],
      "nrtelefon"     => $_POST['nrtelefon'],
      "email"       => $_POST['email'],
      "adresa"  => $_POST['adresa'],
      "observatii"  => $_POST['observatii']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "client","nume,prenume,nrtelefon,email,adresa,observatii",
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['prenume']); ?> adaugat cu success.</blockquote>
  <?php endif; ?>

  <h2>Adauga client</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
    <label for="prenume">Prenume</label>
    <input type="text" name="prenume" id="prenume" required>
    <br>
    <label for="nrtelefon">Nr. de Telefon</label>
    <input type="text" name="nrtelefon" id="nrtelefon" required>
    <br>
    <label for="email">Email</label>
    <input type="text" name="email" id="email">
    <br>
    <label for="adresa">Adresa</label>
    <input type="text" name="adresa" id="adresa">
    <br>
    <label for="observatii">Observatii</label>
    <input type="text" name="observatii" id="observatii">
    <br><br>
    <input type="submit" name="submit" value="Salveaza">
  </form>

</div>
<?php include "../../templates/footer.php"; ?>