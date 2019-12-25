<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

require "../public/scripts/config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
	$init = file_get_contents("init.sql");
	$insert_client = file_get_contents("insert_client.sql");	
	$insert_auto_list = file_get_contents("insert_auto_list.sql");
	$insert_masina = file_get_contents("insert_masina.sql");
	$insert_clientmasina = file_get_contents("insert_clientmasina.sql");
	$insert_piese = file_get_contents("insert_piese.sql");
	$insert_reparatii = file_get_contents("insert_reparatii.sql");
	$insert_factura = file_get_contents("insert_factura.sql");
	$insert_facturapiese = file_get_contents("insert_facturapiese.sql");

	$connection->exec($init);
	$connection->exec($insert_client);
	$connection->exec($insert_auto_list);
	$connection->exec($insert_masina);
	$connection->exec($insert_clientmasina);
	$connection->exec($insert_piese);
	$connection->exec($insert_reparatii);
	$connection->exec($insert_factura);
	$connection->exec($insert_facturapiese);
	$connection->exec(file_get_contents("insert_facturareparatii.sql"));

    echo "Baza de date si tabele create cu succes.";
} catch(PDOException $error) {
    echo $init . "<br>" . $error->getMessage();
}