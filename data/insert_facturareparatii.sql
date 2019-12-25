USE GMS;
SET @idfacturaTemp = 3;
SET @idreparatie = 1;
SET @cantitatereparatie = 1;
INSERT INTO facturareparatii values (null,@idfacturaTemp,@idreparatie,@cantitatereparatie,@cantitatereparatie * (SELECT pret FROM reparatii WHERE id = @idreparatie));
UPDATE factura SET factura.cost_manopera = ROUND((SELECT SUM(cost) FROM facturareparatii WHERE factura.id = @idfacturaTemp),2) WHERE factura.id = @idfacturaTemp;
UPDATE factura SET factura.cost_total = factura.cost_manopera + factura.cost_piese WHERE factura.id = @idfacturaTemp;