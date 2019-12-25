USE GMS;
SET @idfacturaTemp = 3;
SET @idpiesa = 2;
SET @cantitatepiese = 2;
INSERT INTO facturapiese values (null,@idfacturaTemp,@idpiesa,@cantitatepiese,@cantitatepiese * (SELECT costvanzare FROM piese WHERE id = @idpiesa));
UPDATE factura SET factura.cost_piese = ROUND((SELECT SUM(cost) FROM facturapiese WHERE factura.id = @idfacturaTemp),2) WHERE factura.id = @idfacturaTemp;
UPDATE factura SET factura.cost_total = factura.cost_manopera + factura.cost_piese WHERE factura.id = @idfacturaTemp;