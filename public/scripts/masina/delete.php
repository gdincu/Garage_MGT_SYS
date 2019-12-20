<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $nume = $_POST['nume'];
    $prenume = $_POST['prenume'];
    $nrtelefon = $_POST['nrtelefon'];
    $success = "Client sters cu success.";

    $sql = "DELETE FROM client WHERE (nume = :nume OR prenume = :prenume) AND nrtelefon = :nrtelefon";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':nume', $nume);
    $statement->bindValue(':prenume', $prenume);
    $statement->bindValue(':nrtelefon', $nrtelefon);
    $statement->execute();

    if (isset($_POST['submit']) && $statement->rowCount() > 0) { 
      echo $success; 
    } else {
      echo "Mai incearca!";
    }

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}?>

<h2>Sterge client</h2>

 <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
    <label for="prenume">Prenume</label>
    <input type="text" name="prenume" id="prenume">
    <br>
    <label for="nrtelefon">Nr. de Telefon</label>
    <input type="text" name="nrtelefon" id="nrtelefon" required>
    <br><br>
    <input type="submit" name="submit" value="Sterge">
  </form>

</div>

  <!-- Bootstrap core JavaScript -->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Contact Form JavaScript -->
  <script src="../../js/jqBootstrapValidation.js"></script>
  <script src="../../js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="../../js/freelancer.min.js"></script>

<?php include "../../templates/footer_script.php"; ?>