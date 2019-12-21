<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $nume = $_POST['nume'];
    $producator  = $_POST['producator'];
    $marcamasina = $_POST['marcamasina'];
    $modelmasina = $_POST['modelmasina'];
    $costachizitie = $_POST['costachizitie'];
    $costvanzare = $_POST['costvanzare'];
    $cantitate  = $_POST['cantitate'];
	  $observatii = $_POST['observatii'];

      $sql = "INSERT INTO piese 
      (nume,producator,costachizitie,costvanzare,cantitate,observatii,idmasina) 
      (SELECT :nume,:producator,:costachizitie,:costvanzare,:cantitate,:observatii,id 
            FROM auto_list
            WHERE marca LIKE :marcamasina
            AND model = :modelmasina)";  
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':producator', $producator, PDO::PARAM_STR);
    $statement->bindParam(':costachizitie', $costachizitie, PDO::PARAM_STR);
    $statement->bindParam(':costvanzare', $costvanzare, PDO::PARAM_STR);
    $statement->bindParam(':cantitate', $cantitate, PDO::PARAM_STR);
    $statement->bindParam(':observatii', $observatii, PDO::PARAM_STR);
    $statement->execute();
    $success = $_POST['nume'] . " pentru " . $_POST['marcamasina'] . " " . $_POST['modelmasina'] . " adaugat cu success.";

    if (isset($_POST['submit']) && $statement->rowCount() > 0) { 
      echo $success; 
    } else {
      echo "Mai incearca!";
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

  <h2>Adauga piesa</h2>

  <form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume piesa">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="producator" name="producator" placeholder="Producator piesa">
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

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="costachizitie" name="costachizitie" placeholder="Cost achizitie.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="costvanzare" name="costvanzare" placeholder="Cost vanzare.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="cantitate" name="cantitate" placeholder="Cantitate">
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="observatii" name="observatii" placeholder="Observatii">
    </div>
    </div>
    </p>

    <div class="form-row">
    <div class="col">
    <button type="submit" name="submit" class="btn btn-primary">Adauga</button>
    </div>
    </div>
    
    
  </div>
</form>

</div>
<?php include "../../templates/footer_script.php"; ?>