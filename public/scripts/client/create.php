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
  <div class="form-row">
  <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume">
  </div>
  <div class="form-row">
  <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume">
  </div>
  <div class="form-row">
  <input type="text" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon. Se poate omite.">
  </div>
  <div class="form-row">
  <input type="text" class="form-control" id="email" name="email" placeholder="Adresa de email. Se poate omite.">
  </div>
  <div class="form-row">
  <input type="text" class="form-control" id="adresa" name="adresa" placeholder="Adresa. Se poate omite.">  
  </div>
  <div class="form-row">
  <input type="text" class="form-control" id="observatii" name="observatii" placeholder="Adresa. Se poate omite.">  
  </div>
  <div class="form-row">
  <button type="submit" name="submit" class="btn btn-primary">Salveaza</button>
  </div>
</form>
  
</div>
<?php include "../../templates/footer_script.php"; ?>