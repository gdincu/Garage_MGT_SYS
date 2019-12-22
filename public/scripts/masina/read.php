<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">
<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $nrinmatriculare = "%" . $_POST['nrinmatriculare'] . "%";
    $marcamasina = "%" . $_POST['marcamasina'] . "%";
    $modelmasina = "%" . $_POST['modelmasina'] . "%";

    $sql = "SELECT  a.id,
                    b.marca,
                    b.model,
                    a.nrinmatriculare,
                    d.nume,
                    d.prenume,
                    a.motor,
                    a.avariat,
                    a.receptionat,
                    a.datareceptie
            FROM masina a 
            INNER JOIN auto_list b ON b.id = a.id_auto
            INNER JOIN clientmasina c ON c.idmasina = a.id
            INNER JOIN client d ON d.id = c.idclient
            WHERE a.nrinmatriculare LIKE :nrinmatriculare
            AND b.marca LIKE :marcamasina
            AND b.model LIKE :modelmasina";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':nrinmatriculare', $nrinmatriculare, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
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
    <input type="text" class="form-control" id="nrinmatriculare" name="nrinmatriculare" placeholder="Nr. de inmatriculare exact. Se poate omite.">
    </div>
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
    <h2>Lista masini conform criteriilor de cautare: </h2>

    <table class="col">
      <thead>
        <tr>
          <th>#</th>
          <th>Marca</th>
          <th>Model</th>
          <th>Nr Inmatriculare</th>
          <th>Nume Client</th>
          <th>Prenume Client</th>
          <th>Motor</th>
          <th>Avariat</th>
          <th>Receptionat</th>
          <th>Data Receptie</th>
        </tr>
      </thead>
      <tbody>
      
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["marca"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
          <td><?php echo escape($row["nrinmatriculare"]); ?></td>
          <td><?php echo escape($row["nume"]); ?></td>
          <td><?php echo escape($row["prenume"]); ?></td>
          <td><?php echo escape($row["motor"]); ?></td>
          <td><?php echo escape($row["avariat"]); ?> </td>		  	  
          <td><?php echo escape($row["receptionat"]); ?> </td>		  
          <td><?php echo escape($row["datareceptie"]); ?> </td>		  
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