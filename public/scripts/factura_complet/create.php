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
      "prenume"  => $_POST['prenume'],
      "nrtelefon"     => $_POST['nrtelefon'],
      "email"       => $_POST['email'],
      "adresa"  => $_POST['adresa'],
      "observatii"  => $_POST['observatii']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "client","nume,prenume,nrtelefon,email,adresa,observatii",
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
    <blockquote><?php echo escape($_POST['prenume']); ?> adaugat cu success.</blockquote>
  <?php endif; ?>

  <h2>Adauga client</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="nume">Nume</label>
    <input type="text" name="nume" id="nume" required>
    <br>
    <label for="prenume">Prenume</label>
    <input type="text" name="prenume" id="prenume" required>
    <br>
    <label for="nrtelefon">Nr. de Telefon</label>
    <input type="text" name="nrtelefon" id="nrtelefon" required>
    <br>
    <label for="email">Email</label>
    <input type="text" name="email" id="email">
    <br>
    <label for="adresa">Adresa</label>
    <input type="text" name="adresa" id="adresa">
    <br>
    <label for="observatii">Observatii</label>
    <input type="text" name="observatii" id="observatii">
    <br><br>
    <input type="submit" name="submit" value="Salveaza">
  </form>

</div>
<?php include "../../templates/footer_script.php"; ?>