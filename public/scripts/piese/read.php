<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">
<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

	$nume = "%" . $_POST['nume'] . "%";
  $producator = "%" . $_POST['producator'] . "%";
  $marcamasina = "%" . $_POST['marcamasina'] . "%";
  $modelmasina = "%" . $_POST['modelmasina'] . "%";

    $sql = "SELECT a.*,b.marca,b.model
            FROM piese a
            INNER JOIN auto_list b ON  
            b.id = a.idmasina
            WHERE nume LIKE :nume
            AND producator LIKE :producator
            AND idmasina IN (SELECT id
                            FROM auto_list
                            WHERE marca LIKE :marcamasina
                            AND model LIKE :modelmasina)";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
	  $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':producator', $producator, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();

    if (isset($_POST['submit']) && $statement->rowCount() <= 0)
      echo "Mai incearca!";

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}?>
   
   <h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume exact sau partial. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="producator" name="producator" placeholder="Nume producator. Se poate omite.">
    </div>  
    </div>
    </p>

    <p>
    <div class="form-row">  
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca exact sau partial. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="modelmasina" name="modelmasina" placeholder="Model exact sau partial. Se poate omite.">
    </div>
    </div>
    </p>
    
    <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>

  </div>
</form>


<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Lista piese conform criteriilor de cautare: </h2>
    
    <table class="col">
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Producator</th>
          <th>Marca masina</th>
          <th>Model masina</th>
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
          <td><?php echo escape($row["marca"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
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

</div>

<?php include "../../templates/footer_script.php"; ?>