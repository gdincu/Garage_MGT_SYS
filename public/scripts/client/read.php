<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">
<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $nume = "%".$_POST['nume']."%";
    $prenume = "%".$_POST['prenume']."%";
    $nrtelefon = "%".$_POST['nrtelefon']."%";

    $sql = "SELECT * 
            FROM client 
            WHERE nume LIKE :nume
            AND prenume LIKE :prenume
            AND nrtelefon LIKE :nrtelefon";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':prenume', $prenume, PDO::PARAM_STR);
    $statement->bindParam(':nrtelefon', $nrtelefon, PDO::PARAM_STR);

    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}?>

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <div class="form-row">
    <div class="col">
    <label for="nume">Nume</label>
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume exact sau partial. Se poate omite.">
  </div>
  <div class="col">
<label for="prenume">Prenume</label>
    <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume exact sau partial. Se poate omite.">
  </div>
  </div>
  
  <div class="form-group">
    <label for="nrtelefon">Nr. de Telefon</label>
    <input type="text" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon exact sau partial. Se poate omite.">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>
</form>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Lista clienti conform criteriilor de cautare: </h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Prenume</th>
          <th>Nr. Telefon</th>
	     	  <th>Email</th>
          <th>Adresa</th>
          <th>Observatii</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["nume"]); ?></td>
          <td><?php echo escape($row["prenume"]); ?></td>
          <td><?php echo escape($row["nrtelefon"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["adresa"]); ?></td>
          <td><?php echo escape($row["observatii"]); ?> </td>
		      <td><?php echo escape($row["date"]); ?> </td>		  
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found.</blockquote>
    <?php } 
} ?> 



</div>

<?php include "../../templates/footer_script.php"; ?>