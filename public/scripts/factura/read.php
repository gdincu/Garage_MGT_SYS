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
    $prenume = "%" . $_POST['prenume'] . "%";
    $nrtelefon = "%" . $_POST['nrtelefon'] . "%";
    $marcamasina = "%" . $_POST['marcamasina'] . "%";
    $modelmasina = "%" . $_POST['modelmasina'] . "%";

    $sql = "SELECT a.id,b.nume,b.prenume,d.marca,d.model,c.nrinmatriculare,a.cost_manopera,a.cost_piese,a.cost_total,a.observatii,a.date
FROM factura a
INNER JOIN client b ON b.id = a.idclient
INNER JOIN masina c ON c.id = a.idmasina
INNER JOIN auto_list d ON c.id_auto = d.id
WHERE b.nume LIKE :nume
AND b.prenume LIKE :prenume
AND b.nrtelefon LIKE :nrtelefon
AND d.marca LIKE :marcamasina
AND d.model LIKE :modelmasina";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':prenume', $prenume, PDO::PARAM_STR);
    $statement->bindParam(':nrtelefon', $nrtelefon, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <div class="form-group">
    <p>
    <div class="form-row">
    
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon exact. Se poate omite.">
    </div>

    </div>
    </p>

    <p>
    <div class="form-row">
    
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca exacta sau partiala. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="modelmasina" name="modelmasina" placeholder="Model exact. Se poate omite.">
    </div>

    </div>
    </p>
    
    <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>

  </div>
</form>

<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    
<h2>Lista facturi conform criteriilor de cautare: </h2>

    <table class="col">
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Prenume</th>
          <th>Marca</th>
          <th>Model</th>
		  <th>Nr. Inmatriculare</th>
	      <th>Cost Manopera</th>
          <th>Cost Piese</th>
          <th>Cost Total</th>
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
          <td><?php echo escape($row["marca"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
		  <td><?php echo escape($row["nrinmatriculare"]); ?></td>
          <td><?php echo escape($row["cost_manopera"]); ?></td>
          <td><?php echo escape($row["cost_piese"]); ?> </td>
          <td><?php echo escape($row["cost_total"]); ?> </td>
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