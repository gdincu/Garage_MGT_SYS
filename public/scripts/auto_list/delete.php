<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);
  
    $marca = "%".$_POST['marca']."%";
    $model = $_POST['model'];
    $success = $_POST['marca'] . " " . $_POST['model'] . " sters cu success.";

    $sql = "DELETE FROM auto_list 
            WHERE marca LIKE :marca
            AND model = :model";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':model', $model);
    $statement->bindValue(':marca', $marca);
    $statement->execute();

    if (isset($_POST['submit']) && $statement->rowCount() > 0) { 
      echo $success; 
    } else {
      echo "Mai incearca!";
    }

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}?>

<h2>Sterge model auto</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <div class="form-group">
    
    <div class="form-row">
    
    <div class="col">
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="model" name="model" placeholder="Model exact. Nu se poate omite.">
    </div>
    
    <button type="submit" name="submit" class="btn btn-primary">Sterge</button>

  </div>
</form>

</div>

<?php include "../../templates/footer_script.php"; ?>