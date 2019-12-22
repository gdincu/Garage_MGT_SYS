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
    $producator = "%" . $_POST['producator'] . "%";
    $marcamasina = "%" . $_POST['marcamasina'] . "%";
    $modelmasina = $_POST['modelmasina'];
	  $success = $_POST['nume'] . " - Piesa stearsa cu succes.";

    $sql = "DELETE FROM piese 
            WHERE nume = :nume
            AND producator LIKE :producator
            AND idmasina = (SELECT id
                            FROM auto_list
                            WHERE marca LIKE :marcamasina
                            AND model = :modelmasina)";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':nume', $nume);
    $statement->bindValue(':producator', $producator);
    $statement->bindValue(':marcamasina', $marcamasina);
    $statement->bindValue(':modelmasina', $modelmasina);
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

<h2>Sterge piesa</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume piesa exact. Nu poate fi omis." required>
    </div>
    <div class="col">
    <input type="text" class="form-control" id="producator" name="producator" placeholder="Producator piesa. Poate fi omis.">
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca masina exact sau aproximativ. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="modelmasina" name="modelmasina" placeholder="Model masina exact. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <div class="form-row">
    <div class="col">
    <button type="submit" name="submit" class="btn btn-primary">Sterge</button>
    </div>
    </div>
        
  </div>
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>