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
    $prenume = $_POST['prenume'];
    $nrtelefon = $_POST['nrtelefon'];

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

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <label for="nume">Nume</label>
  <input type="text" id="nume" name="nume" value="%%">
  <br>
  <label for="prenume">Prenume</label>
  <input type="text" id="prenume" name="prenume" value="%%">
  <br>
  <label for="adresa">Nr. de Telefon</label>
  <input type="text" id="nrtelefon" name="nrtelefon" value="%%">
  <br>
  <input type="submit" name="submit" value="Rezultate">
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>