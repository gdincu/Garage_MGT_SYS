<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $nrinmatriculare = $_POST['nrinmatriculare'];
    $success = $_POST['nrinmatriculare'] . " sters cu success.";

    $sql = "DELETE FROM clientmasina WHERE idmasina = (SELECT id FROM masina WHERE nrinmatriculare = :nrinmatriculare);
            DELETE FROM masina WHERE nrinmatriculare = :nrinmatriculare";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':nrinmatriculare', $nrinmatriculare);
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

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">  
    <div class="col">
    <input type="text" class="form-control" id="nrinmatriculare" name="nrinmatriculare" placeholder="Nr. de inmatriculare exact. Nu se poate omite." required>
    </div>
    <div class="col">
    <button type="submit" name="submit" class="btn btn-primary">Sterge</button>
    </div>
    </div>
    </p>

</form>

</div>

<?php include "../../templates/footer_script.php"; ?>