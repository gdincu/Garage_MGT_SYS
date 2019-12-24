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
	$nrtelefon = $_POST['nrtelefon'];
	$nrinmatriculare = $_POST['nrinmatriculare'];
	$observatii = $_POST['observatii'];
	$success = "Factura pentru " . $nrinmatriculare . " creata cu succes.";

    $sql = "INSERT INTO factura
			(idclient,idmasina,cost_manopera,cost_piese,cost_total,observatii)
			SELECT a.id,b.id,0,0,0,:observatii
			FROM client a,masina b
			WHERE a.nume LIKE :nume
			AND a.prenume LIKE :prenume
			AND a.nrtelefon = :nrtelefon
			AND b.nrinmatriculare = :nrinmatriculare";
    
    $statement = $connection->prepare($sql);
	$statement->bindValue(':nume', $nume);
    $statement->bindValue(':prenume', $prenume);
    $statement->bindValue(':nrtelefon', $nrtelefon);
	$statement->bindValue(':nrinmatriculare', $nrinmatriculare);
	$statement->bindValue(':observatii', $observatii);
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

<h2>Adauga factura</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nume" name="nume" placeholder="Nume. Nu se poate omite." required>
    </div>
    <div class="col">
    <input type="text" class="form-control" id="prenume" name="prenume" placeholder="Prenume. Nu se poate omite." required>
    </div>
	<div class="col">
    <input type="tel" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nrinmatriculare" name="nrinmatriculare" placeholder="Nr. de inmatriculare exact. Nu se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="observatii" name="observatii" placeholder="Observatii. Se poate omite.">
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