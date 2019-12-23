<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">
<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $marca = "%".$_POST['marca']."%";
    $model = "%".$_POST['model']."%";

    $sql = "SELECT * 
            FROM auto_list 
            WHERE marca LIKE :marca
            AND model LIKE :model";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':marca', $marca, PDO::PARAM_STR);
    $statement->bindParam(':model', $model, PDO::PARAM_STR);
    $statement->execute();
	
	 if (!isset($_POST['submit']) && $statement->rowCount() > 0)
      echo "Nici un rezultat gasit pentru cautare!";

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}?>

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <div class="form-group">
    
    <div class="form-row">
    
    <div class="col">
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="model" name="model" placeholder="Model exact sau partial. Se poate omite.">
    </div>
    
    <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>

  </div>
</form>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Lista clienti conform criteriilor de cautare: </h2>

    <table class="col">
      <thead>
        <tr>
          <th>#</th>
          <th>Marca</th>
          <th>Model</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["marca"]); ?></td>
          <td><?php echo escape($row["model"]); ?></td>
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