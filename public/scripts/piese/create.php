<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "nume" => $_POST['nume'],
      "producator"  => $_POST['producator'],
      "idmasina"     => $_POST['idmasina'],
      "costachizitie"       => $_POST['costachizitie'],
      "costvanzare"  => $_POST['costvanzare'],
      "cantitate"  => $_POST['cantitate'],
	  "observatii"  => $_POST['observatii']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "piese","nume,producator,idmasina,costachizitie,costvanzare,cantitate,observatii",
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['nume']); ?> adaugat cu success.</blockquote>
  <?php endif; ?>

  <h2>Adauga piesa</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
    <label for="producator">Producator</label>
    <input type="text" name="producator" id="producator" required>
    <br>
    <label for="idmasina">ID Masina</label>
    <input type="text" name="idmasina" id="idmasina" required>
    <br>
    <label for="costachizitie">Cost Achizitie</label>
    <input type="text" name="costachizitie" id="costachizitie">
    <br>
    <label for="costvanzare">Cost Vanzare</label>
    <input type="text" name="costvanzare" id="costvanzare">
    <br>
	<label for="cantitate">Cantitate</label>
    <input type="text" name="cantitate" id="cantitate">
    <br>
    <label for="observatii">Observatii</label>
    <input type="text" name="observatii" id="observatii">
    <br><br>
    <input type="submit" name="submit" value="Salveaza">
  </form>

</div>
<?php include "../../templates/footer_script.php"; ?>