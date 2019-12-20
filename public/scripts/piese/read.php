<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">
<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_POST['id'];
	$idmasina = $_POST['idmasina'];
	$nume = $_POST['nume'];
    $producator = $_POST['producator'];

    $sql = "SELECT * 
            FROM piese 
            WHERE id LIKE :id
			AND idmasina LIKE :idmasina
            AND nume LIKE :nume
            AND producator LIKE :producator";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
	$statement->bindParam(':idmasina', $idmasina, PDO::PARAM_STR);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':producator', $producator, PDO::PARAM_STR);

    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}?>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Lista piese conform criteriilor de cautare: </h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Producator</th>
          <th>ID masina</th>
	     	  <th>Cost Achizitie</th>
          <th>Cost Vanzare</th>
          <th>Cantitate</th>
          <th>Observatii</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["nume"]); ?></td>
          <td><?php echo escape($row["producator"]); ?></td>
          <td><?php echo escape($row["idmasina"]); ?></td>
          <td><?php echo escape($row["costachizitie"]); ?></td>
          <td><?php echo escape($row["costvanzare"]); ?></td>
          <td><?php echo escape($row["cantitate"]); ?> </td>
		      <td><?php echo escape($row["observatii"]); ?> </td>		  
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
  
  <label for="nume">ID</label>
  <input type="text" id="id" name="id" value="%%">
  <br>
  <label for="nume">ID Masina</label>
  <input type="text" id="idmasina" name="idmasina" value="%%">
  <br>
  <label for="nume">Nume</label>
  <input type="text" id="nume" name="nume" value="%%">
  <br>
  <label for="prenume">Producator</label>
  <input type="text" id="producator" name="producator" value="%%">
  <br>
  <input type="submit" name="submit" value="Rezultate">
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>