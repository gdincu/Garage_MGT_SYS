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
    $marcamasina  = $_POST['marcamasina'];
    $modelmasina  = $_POST['modelmasina'];
    $success = "Reparatie stearsa cu success.";

    $sql = "DELETE FROM reparatii WHERE nume LIKE :nume AND idmasina = (SELECT id 
                  FROM auto_list
                  WHERE marca = :marcamasina
                  AND model = :modelmasina)";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':nume', $nume);
    $statement->bindValue(':modelmasina', $modelmasina);
    $statement->bindValue(':marcamasina', $marcamasina);
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

<h2>Sterge reparatie</h2>

 <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
    <label for="modelmasina">Model Masina</label>
    <input type="text" name="modelmasina" id="modelmasina">
    <br>
    <label for="marcamasina">Marca Masina</label>
    <input type="text" name="marcamasina" id="marcamasina" required>
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