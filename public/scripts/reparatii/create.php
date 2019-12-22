<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $marcamasina  = "%".$_POST['marcamasina']."%";
    $modelmasina  = $_POST['modelmasina'];
    $nume         = $_POST['nume'];
    $durata       = $_POST['durata'];
    $pret         = $_POST['pret'];
    $success      = $_POST['nume'] . " pentru " . $_POST['marcamasina'] . " " . $_POST['modelmasina'] . " adaugat(a) cu succes.";


    $sql = "INSERT INTO reparatii 
            (nume,durata,pret,idmasina) 
            (SELECT :nume , :durata , :pret , id 
                  FROM auto_list
                  WHERE marca LIKE :marcamasina
                  AND model = :modelmasina)";


    $statement = $connection->prepare($sql);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':durata', $durata, PDO::PARAM_STR);
    $statement->bindParam(':pret', $pret, PDO::PARAM_STR);
    $statement->execute();

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

  <h2>Adauga reparatie</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca masina exact sau aproximativ. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="modelmasina" placeholder="Model masina exact. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume Reparatie. Nu se poate omite." required>
    </div>
    <div class="col">
    <input type="text" class="form-control" id="durata" name="durata" placeholder="Durata. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="pret" name="pret" placeholder="Pret. Nu se poate omite." required>
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