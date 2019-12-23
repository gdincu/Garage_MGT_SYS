<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $marca = $_POST['marca'];
	$model = $_POST['model'];
	$success = $_POST['marca'] . " " . $_POST['model'] . " aduagat cu succes.";

    $sql = "INSERT INTO auto_list (marca,model) 
			VALUES (:marca,:model)";
    
    $statement = $connection->prepare($sql);
	$statement->bindValue(':marca', $marca);
	$statement->bindValue(':model', $model);
    $statement->execute();
	
	if (isset($_POST['submit']) && $statement->rowCount() > 0) { 
      echo $success; 
    } else {
      echo "Mai incearca!";
    }
	
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<h2>Adauga model nou</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca. Nu se poate omite." required>
    </div>
    <div class="col">
    <input type="text" class="form-control" id="model" name="model" placeholder="Model. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <div class="form-row">
    <div class="col">
    <button type="submit" name="submit" class="btn btn-primary">Adauga</button>
    </div>
    </div>
    
    
  </div>
</form>
  
</div>
<?php include "../../templates/footer_script.php"; ?>