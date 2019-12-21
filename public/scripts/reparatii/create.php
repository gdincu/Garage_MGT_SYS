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
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
     <label for="marcamasina">Marca</label>
    <input type="text" id="marcamasina" name="marcamasina">
    <br>
    <label for="modelmasina">Model</label>
    <input type="text" id="modelmasina" name="modelmasina">
    <br>
    <label for="durata">Durata</label>
    <input type="text" name="durata" id="durata" required>
    <br>
    <label for="pret">Pret</label>
    <input type="text" name="pret" id="pret" required>
    <br><br>
    <input type="submit" name="submit" value="Salveaza">
  </form>

</div>
<?php include "../../templates/footer_script.php"; ?>