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
    $model = $_POST['model'];

    $sql = "SELECT * 
            FROM auto_list 
            WHERE marca LIKE :marca
            AND model = :model";
    
    $statement = $connection->prepare($sql);
    $statement->bindParam(':marca', $marca, PDO::PARAM_STR);
    $statement->bindParam(':model', $model, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
	
  }
  catch(PDOException $error) {
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
    <input type="text" class="form-control" id="model" name="model" placeholder="Model exact. Nu se poate omite.">
    </div>
    
    <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>

  </div>
</form>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() == 1) { 

	$model = "";
	$marca = "";

    foreach ($result as $row) {
		$model = $row["model"];
		$marca = $row["marca"];
		echo "
		<h2><br>Modifica model</h2>
		<form method=\"post\">
		<input name=\"csrf\" type=\"hidden\" value=\"" . $_SESSION['csrf'] ."\">
		
		<p>
		<div class=\"form-row\">
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"marca1\" name=\"marca1\" value = \"" . $row["marca"] . "\">
		</div>
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"model1\" name=\"model1\" value = \"" . $row["model"] ."\">
		</div>
		</div>
		</p>
	
		<div class=\"form-row\">
		<div class=\"col\">
		<button type=\"submit\" name=\"submit1\" class=\"btn btn-primary\">Modifica</button>
		</div>
		</div>
			
		</div>
		</form>";
    }
}	else if($result && $statement->rowCount() > 1)
			echo "<br>Se poate modifica un singur model deodata. Schimbati modelul.";
	else 	echo "<br>Nici un model gasit conform rezultatelor cautarii.";
}

    if (isset($_POST['submit1'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
          
                try  {

                   $connection1 = new PDO($dsn, $username, $password, $options);
              
                   $marca1 = $_POST['marca1'];
                   $model1 = $_POST['model1'];
                   $success = "<br>" . $marca1 . " " . $model1 . " modificat cu succes.";
              
                  $sql1 = " UPDATE auto_list 
                            SET marca := marca1,
                                model = :model1
                            WHERE model = :marca
							AND marca LIKE :marca";
                          
                  $statement1 = $connection1->prepare($sql1);
                  $statement1->bindParam(':marca1', $marca1, PDO::PARAM_STR);
                  $statement1->bindParam(':model1', $model1, PDO::PARAM_STR);
				  $statement1->bindParam(':marca', $marca1);
                  $statement1->bindParam(':model', $model1);
                  $statement1->execute();

                  if (isset($_POST['submit1']) && $statement1->rowCount() > 0) { 
                    echo $success; 
                  } else {
                    echo "Mai incearca!";
                  }
            
        }
        catch(PDOException $error) {
            echo $sql1 . "<br>" . $error->getMessage();
        }

            }
    ?>



</div>

<?php include "../../templates/footer_script.php"; ?>