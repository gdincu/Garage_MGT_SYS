<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $nume = "%".$_POST['nume']."%";
    $prenume = "%".$_POST['prenume']."%";
    $nrtelefon = $_POST['nrtelefon'];
    $success = "Client sters cu success.";

    $sql = "DELETE FROM client 
            WHERE (nume LIKE :nume OR prenume LIKE :prenume) 
            AND nrtelefon = :nrtelefon";

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
  
  <div class="form-group">
    
    <p>
    <div class="form-row">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume exact sau partial. Se poate omite.">
    </div>
    </p>

    <p>
    <div class="form-row">
    <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume exact sau partial. Se poate omite.">
    </div>
    </p>

    <p>
    <div class="form-row">
    <input type="tel" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon exact. Nu se poate omite." required>
    </div>
    </p>
    
    <button type="submit" name="submit" class="btn btn-primary">Sterge</button>
  
  </div>
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>