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
    $marcamasina = "%".$_POST['marcamasina']."%";
    $modelmasina = "%".$_POST['modelmasina']."%";

    $sql = "SELECT * 
            FROM reparatii 
            WHERE nume LIKE :nume
            AND idmasina IN (SELECT DISTINCT id 
                  FROM auto_list 
                  WHERE marca LIKE :marcamasina
                  AND model LIKE :modelmasina)";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':nume', $nume, PDO::PARAM_STR);
    $statement->bindParam(':modelmasina', $modelmasina, PDO::PARAM_STR);
    $statement->bindParam(':marcamasina', $marcamasina, PDO::PARAM_STR);

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
          <th>ID masina</th>
	     	  <th>Durata</th>
          <th>Pret</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["nume"]); ?></td>
          <td><?php echo escape($row["idmasina"]); ?></td>
          <td><?php echo escape($row["durata"]); ?></td>
          <td><?php echo escape($row["pret"]); ?></td>
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
  <input type="text" id="nume" name="nume">
  <br>
  <label for="marcamasina">Marca</label>
  <input type="text" id="marcamasina" name="marcamasina">
  <br>
  <label for="modelmasina">Model</label>
  <input type="text" id="modelmasina" name="modelmasina">
  <br>
  <input type="submit" name="submit" value="Rezultate">
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>