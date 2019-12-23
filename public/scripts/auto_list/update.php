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
    $prenume = "%".$_POST['prenume']."%";
    $nrtelefon = $_POST['nrtelefon'];

    $sql = "SELECT * 
            FROM client 
            WHERE nume LIKE :nume
            AND prenume LIKE :prenume
            AND nrtelefon = :nrtelefon";
    
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

<h2>Criterii cautare</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
  <div class="form-group">
    
    <div class="form-row">
    
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume exact sau partial. Se poate omite.">
    </div>
    
    <div class="col">
    <input type="text" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon exact. Nu se poate omite.">
    </div>
    
    <button type="submit" name="submit" class="btn btn-primary">Rezultate</button>

  </div>
</form>
   
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() == 1) { 

    foreach ($result as $row) {
		echo "
		<h2><br>Modifica client</h2>
		<form method=\"post\">
		<input name=\"csrf\" type=\"hidden\" value=\"" . $_SESSION['csrf'] ."\">
		
		<p>
		<div class=\"form-row\">
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"nume1\" name=\"nume1\" value = \"" . $row["nume"] . "\" required>
		</div>
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"prenume1\" name=\"prenume1\" value = \"" . $row["prenume"] ."\" required>
		</div>
		</div>
		</p>
		
		<p>
		<div class=\"form-row\">
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"nrtelefon1\" name=\"nrtelefon1\" value = \"" . $row["nrtelefon"] . "\" title=\"Nu se poate modifica.\">
		</div>
		<div class=\"col\">
		<input type=\"email\" class=\"form-control\" id=\"email1\" name=\"email1\" value = \"" . $row["email"] . "\">
		</div>
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"adresa1\" name=\"adresa1\" value = \"" . $row["adresa"] . "\" required>
		</div>
		</p>

		<p>
		<div class=\"form-row\">
		<div class=\"col\">
		<input type=\"text\" class=\"form-control\" id=\"observatii1\" name=\"observatii1\" value = \"" . $row["observatii"] . "\">
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
			echo "<br>Se poate modifica un singur client deodata. Schimbati nr. de telefon.";
	else 	echo "<br>Nici un client gasit conform rezultatelor cautarii.";
}
?> 

    <?php
    if (isset($_POST['submit1'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
          
                try  {

                   $connection1 = new PDO($dsn, $username, $password, $options);
              
                   $nume1 = $_POST['nume1'];
                   $prenume1 = $_POST['prenume1'];
                   $nrtelefon1 = $_POST['nrtelefon1'];
                   $email1 = $_POST['email1'];
                   $adresa1 = $_POST['adresa1'];
                   $observatii1 = $_POST['observatii1'];
                   $success = $_POST['nume1'] . " " . $_POST['prenume1'] . " modificat cu succes.";
              
                  $sql1 = " UPDATE client 
                            SET   nume = :nume1,
                                prenume = :prenume1,
                                nrtelefon = :nrtelefon1,
                                email = :email1,
                                adresa = :adresa1,
                                observatii = :observatii1
                            WHERE nrtelefon = :nrtelefon1";
                          
                          
                  $statement1 = $connection1->prepare($sql1);
                  $statement1->bindParam(':nume1', $nume1, PDO::PARAM_STR);
                  $statement1->bindParam(':prenume1', $prenume1, PDO::PARAM_STR);
                  $statement1->bindParam(':nrtelefon1', $nrtelefon1, PDO::PARAM_STR);
                  $statement1->bindParam(':email1', $email1, PDO::PARAM_STR);
                  $statement1->bindParam(':adresa1', $adresa1, PDO::PARAM_STR);
                  $statement1->bindParam(':observatii1', $observatii1, PDO::PARAM_STR);
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