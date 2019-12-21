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
    $modelmasina  = "%".$_POST['modelmasina']."%";
    $nume         = $_POST['nume'];
    $durata       = $_POST['durata'];
    $pret         = $_POST['pret'];


    $sql = "INSERT INTO reparatii 
            (nume,durata,pret,idmasina) 
            (SELECT :nume , :durata , :pret , id 
                  FROM auto_list
                  WHERE marca LIKE :marcamasina
                  AND model LIKE :modelmasina)";


    $statement = $connection->prepare($sql);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':durata', $durata, PDO::PARAM_STR);
    $statement->bindParam(':pret', $pret, PDO::PARAM_STR);
    $statement->execute();

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['nume']); ?> adaugat cu success.</blockquote>
  <?php endif; ?>

  <h2>Adauga reparatie</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca masina">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="modelmasina" placeholder="Model masina">
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume Reparatie">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="durata" name="durata" placeholder="Durata">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="pret" name="pret" placeholder="Pret">
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