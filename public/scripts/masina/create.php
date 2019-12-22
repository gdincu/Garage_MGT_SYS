<?php include "../../templates/header_script.php"; ?>

<div class="col-md-12 col-lg-12">

<?php
require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $nrtelefon = $_POST['nrtelefon'];
    $nrinmatriculare = $_POST['nrinmatriculare'];
    $nrtelefon = "%" . $_POST['marcamasina'] . "%";
    $nrtelefon = $_POST['modelmasina'];
    $motor = $_POST['motor'];
    $vin = $_POST['vin'];
    $detalii = $_POST['detalii'];
    $avariat = $_POST['avariat'];
    $acesorii = $_POST['acesorii'];
    $km = $_POST['km'];
    $observatii = $_POST['observatii'];
    $receptionat = $_POST['receptionat'];
    $success = $_POST['nrinmatriculare'] . " adaugat cu success.";

    $sql = "INSERT INTO masina (id_auto,nrinmatriculare,motor,vin,detalii,avariat,acesorii,km,observatii,receptionat,datareceptie)
            (SELECT id,:nrinmatriculare,:motor,:vin,:detalii,:avariat,:acesorii,:km,:observatii,:receptionat,CURRENT_TIMESTAMP()
            FROM auto_list WHERE marca LIKE :marcamasina AND model = :modelmasina);
            
            INSERT INTO clientmasina (idclient,idmasina)
            (SELECT a.id,b.id
            FROM masina a
            FROM client b
            WHERE a.nrinmatriculare = :nrinmatriculare
            AND b.nrtelefon = :nrtelefon)";
    
    $statement = $connection->prepare($sql);
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

<h2>Adauga masina</h2>

  <form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  
    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="marcamasina" placeholder="Marca masina exact sau aproximativ. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="marcamasina" name="modelmasina" placeholder="Model masina exact. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="nrinmatriculare" name="nrinmatriculare" placeholder="Nr. de inmatriculare. Nu se poate omite." required>
    </div>
    <div class="col">
    <input type="text" class="form-control" id="nrtelefon" name="nrtelefon" placeholder="Nr. de telefon. Nu se poate omite." required>
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="motor" name="motor" placeholder="Motor. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="vin" name="vin" placeholder="VIN. Se poate omite.">
    </div>
    <div class="col">
    <input type="number" class="form-control" id="km" name="km" placeholder="Kilometraj. Se poate omite.">
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">
    <input type="text" class="form-control" id="detalii" name="detalii" placeholder="Detalii. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="acesorii" name="acesorii" placeholder="Acesorii. Se poate omite.">
    </div>
    <div class="col">
    <input type="text" class="form-control" id="observatii" name="observatii" placeholder="Observatii. Se poate omite.">
    </div>
    </div>
    </p>

    <p>
    <div class="form-row">
    <div class="col">Avariat</div>
    <div class="col">
    <input class="form-check-input" type="checkbox" id="avariat" name="avariat" value="DA">
    <label class="form-check-label" for="avariat">Da</label>
    </div>
    <div class="col">
    <input class="form-check-input" type="checkbox" id="avariat" name="avariat" value="DA">
    <label class="form-check-label" for="avariat">Nu</label>
    </div>

    <div class="col">Receptionat</div>
    <div class="col">
    <input class="form-check-input" type="checkbox" id="receptionat" name="receptionat" value="DA">
    <label class="form-check-label" for="avariat">Da</label>
    </div>
    <div class="col">
    <input class="form-check-input" type="checkbox" id="receptionat" name="receptionat" value="DA">
    <label class="form-check-label" for="avariat">Nu</label>
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