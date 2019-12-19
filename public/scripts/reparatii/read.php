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

    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $nrtelefon = $_POST['nrtelefon'];

    $sql = "SELECT * 
            FROM client 
            WHERE nume LIKE :nume
            AND prenume LIKE :prenume
            AND nrtelefon LIKE :nrtelefon";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':prenume', $prenume, PDO::PARAM_STR);
    $statement->bindParam(':nrtelefon', $nrtelefon, PDO::PARAM_STR);

    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}?>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Lista clienti conform criteriilor de cautare: </h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Prenume</th>
          <th>Nr. Telefon</th>
	     	  <th>Email</th>
          <th>Adresa</th>
          <th>Observatii</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["nume"]); ?></td>
          <td><?php echo escape($row["prenume"]); ?></td>
          <td><?php echo escape($row["nrtelefon"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["adresa"]); ?></td>
          <td><?php echo escape($row["observatii"]); ?> </td>
		      <td><?php echo escape($row["date"]); ?> </td>		  
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found.</blockquote>
    <?php } 
} ?> 

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <label for="nume">Nume</label>
  <input type="text" id="nume" name="nume" value="%%">
  <br>
  <label for="prenume">Prenume</label>
  <input type="text" id="prenume" name="prenume" value="%%">
  <br>
  <label for="adresa">Nr. de Telefon</label>
  <input type="text" id="nrtelefon" name="nrtelefon" value="%%">
  <br>
  <input type="submit" name="submit" value="Rezultate">
</form>

</div>
<?php include "../../templates/footer.php"; ?>