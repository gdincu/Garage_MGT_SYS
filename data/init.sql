CREATE DATABASE GMS;
use GMS;
SET time_zone = "+02:00";

CREATE TABLE client (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nume VARCHAR(30) NOT NULL,
	prenume VARCHAR(30) NOT NULL,
	nrtelefon VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	adresa  VARCHAR(50),
	observatii VARCHAR(100),
	date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE masina (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nrinmatriculare VARCHAR(30) NOT NULL,
	marca  VARCHAR(50) NOT NULL,
	model VARCHAR(50) NOT NULL,
	motor VARCHAR(50),
	vin  VARCHAR(50),
	detalii   VARCHAR(50),
	avariat varchar(250) NOT NULL,
	acesorii VARCHAR(250),
	km  varchar(10),
	observatii VARCHAR(100),
	receptionat varchar(100) NOT NULL DEFAULT 'Nu',
	datareceptie datetime NOT NULL DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE clientmasina (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idclient INT(11) UNSIGNED,
	idmasina INT(11) UNSIGNED,
--	data TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	FOREIGN KEY (idclient) REFERENCES client(id),
	FOREIGN KEY (idmasina) REFERENCES masina(id)
);

CREATE TABLE factura (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idclient INT(11) UNSIGNED NOT NULL,
	idmasina INT(11) UNSIGNED NOT NULL,
	cost FLOAT(50) NOT NULL,
	observatii VARCHAR(100),
	date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
	FOREIGN KEY (idclient) REFERENCES client(id),
	FOREIGN KEY (idmasina) REFERENCES masina(id)
);

use GMS;
CREATE TABLE reparatie (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	nume VARCHAR(100) NOT NULL,
	durata TIME,
	pret FLOAT(50) NOT NULL
);



use GMS;
CREATE TABLE facturareparatii (
	id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	idfactura INT(11) UNSIGNED NOT NULL,
	idreparatie INT(11) UNSIGNED NOT NULL,
	cantitate INT(11) UNSIGNED NOT NULL,
	cost FLOAT(30) UNSIGNED NOT NULL,
	FOREIGN KEY (idfactura) REFERENCES factura(id),
	FOREIGN KEY (idreparatie) REFERENCES reparatie(id)
);



USE GMS;
INSERT INTO	client 
VALUES 		(null,'A1','A1','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A2','A2','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A3','A3','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A4','A4','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A5','A5','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A6','A6','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP()),
			(null,'A7','A7','0770777222',null,null,'Client Nou',CURRENT_TIMESTAMP());
			
USE GMS;
INSERT INTO	masina
VALUES		(null,'DJ00AAA','FORD','FIESTA','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAB','FORD','F1','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAC','FORD','F2','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAD','FORD','F3','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAE','FORD','F4','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAF','FORD','F5','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAG','FORD','F6','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP()),
			(null,'DJ00AAH','FORD','F7','1.3 TDI','A333AASDASDASD',null,'NU',null,'223456',null,'Da',CURRENT_TIMESTAMP());
			
USE GMS;
INSERT INTO clientmasina
VALUES		(null,5,3,CURRENT_TIMESTAMP()),
			(null,2,5,CURRENT_TIMESTAMP()),
			(null,6,2,CURRENT_TIMESTAMP()),
			(null,3,2,CURRENT_TIMESTAMP()),
			(null,3,4,CURRENT_TIMESTAMP()),
			(null,5,3,CURRENT_TIMESTAMP()),
			(null,3,3,CURRENT_TIMESTAMP());

USE GMS;	
INSERT INTO	reparatie
VALUES		(null,'Schimbare Ambreiaj',null,12.13),
			(null,'Schimbare Frane',null,33.13),
			(null,'ITP',null,45.13),
			(null,'Schimbare ulei',null,133.13),
			(null,'Schimbare alte lichide',null,77.13);
			
USE GMS;
INSERT INTO	factura
VALUES		(null,3,4,123.44,null,CURRENT_TIMESTAMP()),
			(null,5,2,33.44,null,CURRENT_TIMESTAMP()),
			(null,7,6,991.44,null,CURRENT_TIMESTAMP());

USE GMS;
INSERT INTO	facturareparatii
VALUES		(null,1,2),
			(null,2,2),
			(null,2,3);


USE GMS;
INSERT INTO	facturareparatii
VALUES		(null,2,2,2,2);

DROP TRIGGER `costreparatie`;

USE GMS;
DELIMITER $$
CREATE TRIGGER `costreparatie` BEFORE INSERT ON facturareparatii
    FOR EACH ROW
    BEGIN
      SET NEW.cost = NEW.cantitate * (SELECT pret FROM reparatie WHERE id = NEW.id);
END$$
DELIMITER ;