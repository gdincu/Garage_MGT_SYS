<?php include "../templates/header.php"; ?>

<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM client";
//WHERE location = :location


//$location = $_POST['location'];
    $statement = $connection->prepare($sql);
//$statement->bindParam(':location', $location, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
      
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nume</th>
          <th>Prenume</th>
          <th>Nr. Telefon</th>
		  <th>Email</th>
          <th>Adresa</th>
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
          <td><?php echo escape($row["nrtelefon"]); ?></td>
          <td><?php echo escape($row["email"]); ?></td>
          <td><?php echo escape($row["adresa"]); ?></td>
          <td><?php echo escape($row["observatii"]); ?> </td>
		  <td><?php echo escape($row["date"]); ?> </td>		  
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['location']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find user based on location</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="location">Location</label>
  <input type="text" id="location" name="location">
  <input type="submit" name="submit" value="View Results">
</form>

<?php include "../templates/footer.php"; ?>