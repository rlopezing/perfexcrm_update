/***********************
/**** PROCESS CONTROLS VISITS
/***** UPDATE 1 SERVOWEB */

/***** 1: Anexa la tabla 'tblcvisit' que almacena las visitas comerciales planificadas */
DROP TABLE IF EXISTS `tblcvisit`;
CREATE TABLE IF NOT EXISTS `tblcvisit` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `subject` VARCHAR(300) NULL,
  `client` INT(11) NULL,
  `type` INT(11) NULL,
  `name` VARCHAR(25) NULL,
  `dni_die` VARCHAR(25) NULL,
  `date_add` DATETIME NULL,
  `hour_add` DATETIME NULL,
  `notes` VARCHAR(450) NULL,
  `status` INT(11) NULL,
  `trash` TINYINT(1) NULL,
  `hash` VARCHAR(32) NULL,
  `not_visible_to_client` TINYINT(1) NULL,
  `addedfrom` INT(11) NULL,
  `date_input` DATETIME NULL,
  `date_inbank` DATETIME NULL,
  `date_study` DATETIME NULL,
  `date_approved` DATETIME NULL,
  `date_finished` DATETIME NULL,
PRIMARY KEY (`id`));
	-- Agregar columnas faltantes
	ALTER TABLE tblcvisit ADD COLUMN `telephone` VARCHAR(100) NULL AFTER dni_die;
    ALTER TABLE tblcvisit ADD COLUMN `email` VARCHAR(100) NULL AFTER telephone;

/***** 2: Anexa la tabla 'tblcvtype' que almacena los tipos de personas */
DROP TABLE IF EXISTS `tblcvtype`;
CREATE TABLE IF NOT EXISTS `tblcvtype` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvtype (type) VALUES ('Persona Física'),('Persona Jurídica');
    
/***** 3: Anexa la tabla 'tblcvstatus' que almacena los tipos de estatus de las visitas */
DROP TABLE IF EXISTS `tblcvstatus`;
CREATE TABLE `tblcvstatus` (
  `id` INT(11) NOT NULL,
  `status` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `color` VARCHAR(45) NULL,
  `order` INT(11) NULL,
  PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvstatus (id, status, name, `color`, `order`) VALUES 
		(1,'Visitado','Visitado','#000000',1),
        (2,'ParaViabilidad','Para Viabilidad','#FF00FF',2),
        (3,'EntradaFecha','Entrada y Fecha','#00FF00',3),
        (4,'EnBanco','En Banco','#808080',4),
		(5,'Estudio','Estudio','#FFFF00',5),
        (6,'Aprobada','Aprobada','#FF6F00',6),
        (7,'Firmada','Firmada','#03a9f4',7);
        
/***** 4: Anexa la tabla 'tblcvisit_management' que almacena el seguimiento realizado a la visita */
DROP TABLE IF EXISTS `tblcvisit_management`;
CREATE TABLE IF NOT EXISTS `tblcvisit_management` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `staffid` INT(11) NULL,
  `visit` INT(11) NULL,
  `date_add` TIMESTAMP NULL,
  `contact_type` INT(11) NULL,
  `information` VARCHAR(256) NULL,
PRIMARY KEY (`id`));

/***** 5: Anexa la tabla 'tblcvcontact_type', tipos de contactos con el cliente */
DROP TABLE IF EXISTS `tblcvcontact_type`;
CREATE TABLE IF NOT EXISTS `tblcvcontact_type` (
  `id` INT(11) NOT NULL,
  `type_name` VARCHAR(50) NULL,
  PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvcontact_type (id, type_name) VALUES 
		(1,'Oficina'),(2,'Telefonicamente'),(3,'Correo'),(4,'Tasación'),(5,'Firma');

/***** 6: Anexa el campo 'type': tipo de persona (Física o Juridica) a la tabla clientes*/
ALTER TABLE tblclients DROP `type`;
ALTER TABLE tblclients ADD COLUMN `type` INT(11) NULL AFTER userid;

/***** 7: Anexa la tabla 'tblcvisit_comments', comentarios de la visita */
DROP TABLE IF EXISTS `tblcvisit_comments`;
CREATE TABLE `tblcvisit_comments` (
  `id` INT(11) NOT NULL,
  `content` mediumtext,
  `visit` INT(11) NOT NULL,
  `staffid` INT(11) NOT NULL,
  `dateadded` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvisit_comments` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvisit_comments` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 9: Anexa la tabla 'tblcvtake_data', almacena los datos personales de la toma de datos */
DROP TABLE IF EXISTS `tblcvtake_data`;
CREATE TABLE `tblcvtake_data` (
  `id` INT(11) NOT NULL,
  `client` INT(11) NOT NULL,
  `cesion` VARCHAR(50) NULL,
  `collaboration_contract` INT(11) NOT NULL,
  `endorsement` INT(11) NOT NULL,
  `relation_ship` INT(11) NOT NULL,
  `name_1` VARCHAR(50) NULL,
  `lastname_1` VARCHAR(50) NULL,
  `dninie_1` VARCHAR(20) NULL,
  `birthdate_1` DATETIME NOT NULL,
  `phonenumber_1` VARCHAR(50) NULL,
  `email_1` VARCHAR(100) NULL,
  `civilstatus_1` INT(11) NOT NULL,
  `sons_1` INT(11) NOT NULL,
  `maintenance_1` INT(11) NOT NULL,
  `amount_1` decimal(15,2) NOT NULL,
  `name_2` VARCHAR(50) NULL,
  `lastname_2` VARCHAR(50) NULL,
  `dninie_2` VARCHAR(20) NULL,
  `birthdate_2` DATETIME NOT NULL,
  `phonenumber_2` VARCHAR(50) NULL,
  `email_2` VARCHAR(100) NULL,
  `civilstatus_2` INT(11) NOT NULL,
  `sons_2` INT(11) NOT NULL,
  `maintenance_2` INT(11) NOT NULL,
  `amount_2` decimal(15,2) NOT NULL,
  `owner1` VARCHAR(50) NULL,
  `owner2` VARCHAR(50) NULL,
  `owner3` VARCHAR(50) NULL,
  `direction` VARCHAR(100) NULL,
  `estimated` decimal(15,2) NOT NULL,
  `responsabilities` INT(11) NOT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvtake_data` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvtake_data` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 10: Anexa la tabla 'tblcvrelation_ship', almacena los tipos de relaciones personales */
DROP TABLE IF EXISTS `tblcvrelation_ship`;
CREATE TABLE IF NOT EXISTS `tblcvrelation_ship` (
  `id` INT(11) NOT NULL,
  `relation_ship` VARCHAR(45) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvrelation_ship (id, relation_ship) VALUES (1,'Padres'),(2,'Hermanos'),(3,'Otros');

/***** 11: Anexa la tabla 'tblcvcivil_status', almacena los estados civiles */
DROP TABLE IF EXISTS `tblcvcivil_status`;
CREATE TABLE IF NOT EXISTS `tblcvcivil_status` (
  `id` INT(11) NOT NULL,
  `civil_status` VARCHAR(50) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvcivil_status (id, civil_status) 
    VALUES  (1,'Soltero/Soltera'),
			(2,'Casado/Casada'),
            (3,'Divorciado/Divorciada'),
            (4,'Viudo/Viuda'),
            (5,'Pareja de hecho');

/***** 12: Anexa la tabla 'tblcvsales_data', almacena los datos de compra venta vinculadas al cliente visitado */
DROP TABLE IF EXISTS `tblcvsales_data`;
CREATE TABLE `tblcvsales_data` (
  `id` INT(11) NOT NULL,
  `client` INT(11) NOT NULL,
  `purchase_price` decimal(15,2) NOT NULL,
  `purchase_address` VARCHAR(200) NULL,
  `maximum_quota` decimal(15,2) NOT NULL,
  `reserve_amount` decimal(15,2) NOT NULL,
  `proposed_fees` decimal(15,2) NOT NULL,
  `arran_contract` VARCHAR(50) NULL,
  `arran_end_date` DATETIME NOT NULL,
  `total_contribution` decimal(15,2) NOT NULL,
  `real_state_appraisa` VARCHAR(50) NULL,
  `real_state_commisionss` decimal(15,2) NOT NULL,
  `purchase_price_commission` decimal(15,2) NOT NULL,
  `payment_method` INT(11) NOT NULL,
  `priced` VARCHAR(50) NULL,
  `appraisal_company` VARCHAR(200) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvsales_data` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvsales_data` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 13: Anexa la tabla 'tblcvpayment_method', almacena los metodos de pago */
DROP TABLE IF EXISTS `tblcvpayment_method`;
CREATE TABLE IF NOT EXISTS `tblcvpayment_method` (
  `id` INT(11) NOT NULL,
  `payment_method` VARCHAR(50) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvpayment_method (id, payment_method) 
    VALUES  (1,'Efectivo'),
			(2,'Transferencia'),
            (3,'Cheque'),
            (4,'Recibo domiciliado');

/***** 14: Anexa la tabla 'tblcvcontract_types', almacena los tipos de contratos */
DROP TABLE IF EXISTS `tblcvcontract_types`;
CREATE TABLE IF NOT EXISTS `tblcvcontract_types` (
  `id` INT(11) NOT NULL,
  `contract_types` VARCHAR(50) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvcontract_types (id, contract_types) 
	VALUES  (1,'INDEFINIDO TIEMPO COMPLETO'),
			(2,'INDEFINIDO TIEMPO PARCIAL'),
			(3,'TEMPORAL TIEMPO COMPLETO'),
			(4,'TEMPORAL TIEMPO PARCIAL'),
			(5,'PENSIONISTA'),
			(6,'DESEPLEADO CON PARO'),
			(7,'DESEMPLEADO CON SUBSIDIO'),
			(8,'DESEMPLEADO SIN INGRESOS'),
			(9,'AUTONOMO MODULOS'),
			(10,'AUTONOMO ESTIMACIÓN DIRECTA'),
			(11,'AUTONOMO AUTONOMINA'),
			(12,'AUTONOMO'),
			(13,'INTERINO'),
			(14,'FUNCIONARIO');

/***** 15: Anexa la tabla 'tblcvbanks', almacena los bancos */
DROP TABLE IF EXISTS `tblcvbanks`;
CREATE TABLE IF NOT EXISTS `tblcvbanks` (
  `id` INT(11) NOT NULL,
  `bank` VARCHAR(50) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvbanks (id, bank) 
    VALUES  (1,'ABANCA'),
			(2,'BANCA PUEYO'),
			(3,'BANCO PICHINCHA'),
			(4,'BANCO POPULAR'),
			(5,'BANKIA'),
			(6,'BANKINTER'),
			(7,'BBVA'),
			(8,'BMN'),
			(9,'CAIXA GERAL'),
			(10,'CAIXABANK'),
			(11,'CAJA ESPAÑA'),
			(12,'CAJA LABORAL'),
			(13,'CAJAMAR'),
			(14,'CAJA RURAL'),
			(15,'DEUTSCHE BANK'),
			(16,'EVO'),
			(17,'IBERCAJA'),
			(18,'ING'),
			(19,'KUTXABANK'),
			(20,'LIBERBANK'),
			(21,'NOVANCA'),
			(22,'SABADELL'),
			(23,'SCH');

/***** 16: Anexa la tabla 'tblcvbanks', almacena los bancos */
DROP TABLE IF EXISTS `tblcvbanks_loan`;
CREATE TABLE IF NOT EXISTS `tblcvbanks_loan` (
  `id` INT(11) NOT NULL,
  `bank_loan` VARCHAR(100) NULL,
PRIMARY KEY (`id`));
	-- Inserta registros
	INSERT INTO tblcvbanks_loan (id, bank_loan) 
    VALUES  (1,'ABANCA'),
			(2,'BANCA PUEYO'),
			(3,'Banco Cetelem, S.A.'),
			(4,'BANCO PICHINCHA'),
			(5,'BANCO POPULAR'),
			(6,'Banco sofinloc'),
			(7,'Bancopopular-E, S.A.'),
			(8,'BANKIA'),
			(9,'BANKINTER'),
			(10,'Bankinter Consumer Finance, E.F.C., S.A.'),
			(11,'Bansabadell Financiación E.F.C., S.A.'),
			(12,'BBVA'),
			(13,'BBVA Banco de Financiación, S.A.'),
			(14,'BIGBANK AS CONSUMER FINANCE, SUCURSAL EN ESPAÑA'),
			(15,'BMN'),
			(16,'BMW Bank GMBH, SE'),
			(17,'BNP Paribas España, S.A.'),
			(18,'CAIXA GERAL'),
			(19,'CAIXABANK'),
			(20,'Caixabank Consumer Finance, E.F.C., S.A.'),
			(21,'CAJA ESPAÑA'),
			(22,'CAJA LABORAL'),
			(23,'CAJA RURAL'),
			(24,'Cajasiete, Caja Rural, S.C.C.'),
			(25,'Citibank España, S.A.'),
			(26,'Cofiber Financiera, E.F.C., S.A.'),
			(27,'Cofidis, S.A., S.E.'),
			(28,'DEUTSCHE BANK'),
			(29,'EVO'),
			(30,'Financiera Carrión, S.A., E.F.C.'),
			(31,'Financiera El Corte Inglés E.F.C., S.A.'),
			(32,'Finandia E.F.C., S.A.'),
			(33,'Honda Bank GMBH, S.E.'),
			(34,'IBERCAJA'),
			(35,'ING'),
			(36,'KUTXABANK'),
			(37,'LIBERBANK'),
			(38,'Mercedes-Benz Financial Services España E.F.C., S.A.'),
			(39,'NOVANCA'),
			(40,'Oney Servicios Financieros, E.F.C., S.A.'),
			(41,'Open Bank, S.A.'),
			(42,'Popular Servicios Financieros, E.F.C., S.A'),
			(43,'PSA Financial Services Spain E.F.C. S.A'),
			(44,'RCI Banque, S.A., S.E.'),
			(45,'SABADELL'),
			(46,'Santander Consumer Finance, S.A.'),
			(47,'SCH'),
			(48,'Servicios Financieros Carrefour, E.F.C., S.A.'),
			(49,'TARGOBANK'),
			(50,'Toyota Kreditbank GMBH, S.E.'),
			(51,'Unión de Créditos Inmobiliarios, S.A., E.F.C.'),
			(52,'Unión Financiera Asturiana, S.A., E.F.C.'),
			(53,'Unoe Bank, S.A.'),
			(54,'Volkswagen Finance S.A., E.F.C.');

/***** 17: Anexa la tabla 'tblcveconomic_data', almacena los datos económicos del cliente visitado */
DROP TABLE IF EXISTS `tblcveconomic_data`;
CREATE TABLE `tblcveconomic_data` (
  `id` INT(11) NOT NULL,
  `client` INT(11) NOT NULL,
  `high_date_last_job_1` DATETIME NOT NULL,
  `profession_1` VARCHAR(200) NULL,
  `contract_type_1` INT(11) NOT NULL,
  `income_1` decimal(15,2) NOT NULL,
  `payments_1` int(11) NOT NULL,
  `banks_works_1_1` INT(11) NOT NULL,
  `banks_works_2_1` INT(11) NOT NULL,
  `banks_works_3_1` INT(11) NOT NULL,
  `entity_1_1` INT(11) NOT NULL,
  `pending_1_1` decimal(15,2) NOT NULL,
  `share_1_1` decimal(15,2) NOT NULL,
  `entity_2_1` INT(11) NOT NULL,
  `pending_2_1` decimal(15,2) NOT NULL,
  `share_2_1` decimal(15,2) NOT NULL,
  `entity_3_1` INT(11) NOT NULL,
  `pending_3_1` decimal(15,2) NOT NULL,
  `share_3_1` decimal(15,2) NOT NULL,
  `entity_4_1` INT(11) NOT NULL,
  `pending_4_1` decimal(15,2) NOT NULL,
  `share_4_1` decimal(15,2) NOT NULL,
  `high_date_last_job_2` DATETIME NOT NULL,
  `profession_2` VARCHAR(200) NULL,
  `contract_type_2` INT(11) NOT NULL,
  `income_2` decimal(15,2) NOT NULL,
  `payments_2` int(11) NOT NULL,
  `banks_works_1_2` INT(11) NOT NULL,
  `banks_works_2_2` INT(11) NOT NULL,
  `banks_works_3_2` INT(11) NOT NULL,
  `entity_1_2` INT(11) NOT NULL,
  `pending_1_2` decimal(15,2) NOT NULL,
  `share_1_2` decimal(15,2) NOT NULL,
  `entity_2_2` INT(11) NOT NULL,
  `pending_2_2` decimal(15,2) NOT NULL,
  `share_2_2` decimal(15,2) NOT NULL,
  `entity_3_2` INT(11) NOT NULL,
  `pending_3_2` decimal(15,2) NOT NULL,
  `share_3_2` decimal(15,2) NOT NULL,
  `entity_4_2` INT(11) NOT NULL,
  `pending_4_2` decimal(15,2) NOT NULL,
  `share_4_2` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcveconomic_data` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcveconomic_data` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 18: Anexa la tabla 'tblcvoperation_banks', almacena los datos de operaciones bancarias del cliente visitado */
DROP TABLE IF EXISTS `tblcvoperation_banks`;
CREATE TABLE `tblcvoperation_banks` (
  `id` INT(11) NOT NULL,
  `client` INT(11) NOT NULL,
  `banks_works_1_1` INT(11) NOT NULL,
  `banks_works_2_1` INT(11) NOT NULL,
  `banks_works_3_1` INT(11) NOT NULL,
  `creditor_1_1` VARCHAR(200) NULL,
  `amount_1_1` decimal(15,2) NOT NULL,
  `creditor_2_1` VARCHAR(200) NULL,
  `amount_2_1` decimal(15,2) NOT NULL,
  `rental_amount_1` decimal(15,2) NOT NULL,
  `rental_payment_method_1` INT(11) NOT NULL,
  `rental_date_1` DATETIME NOT NULL,
  `address_1_1` VARCHAR(200) NULL,
  `charges_1_1` INT(11) NOT NULL,
  `address_2_1` VARCHAR(200) NULL,
  `charges_2_1` decimal(15,2) NOT NULL,
  `banks_works_1_2` INT(11) NOT NULL,
  `banks_works_2_2` INT(11) NOT NULL,
  `banks_works_3_2` INT(11) NOT NULL,
  `creditor_1_2` VARCHAR(200) NULL,
  `amount_1_2` decimal(15,2) NOT NULL,
  `creditor_2_2` VARCHAR(200) NULL,
  `amount_2_2` decimal(15,2) NOT NULL,
  `rental_amount_2` decimal(15,2) NOT NULL,
  `rental_payment_method_2` INT(11) NOT NULL,
  `rental_date_2` DATETIME NOT NULL,
  `address_1_2` VARCHAR(200) NULL,
  `charges_1_2` INT(11) NOT NULL,
  `address_2_2` VARCHAR(200) NULL,
  `charges_2_2` decimal(15,2) NOT NULL,
  `observations` VARCHAR(500) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvoperation_banks` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvoperation_banks` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 19: Anexa la tabla 'tblcvisit_settings', condiguración de las paginas de la operacion */
DROP TABLE IF EXISTS `tblcvisit_settings`;
CREATE TABLE `tblcvisit_settings` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(100) NULL,
  `value` text NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvisit_settings` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvisit_settings` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
    -- Inserta registros
	INSERT INTO tblcvisit_settings (id, `name`, `value`) 
    VALUES  (1,'view_tasks','1'),
			(2,'create_tasks','1'),
			(3,'edit_tasks','1');
            
/***** 20: Anexa la tabla 'tblcvisit_documents', guarda los documentos necesarios para la operacion */
DROP TABLE IF EXISTS `tblcvisit_documents`;
CREATE TABLE `tblcvisit_documents` (
  `id` INT(11) NOT NULL,
  `visit` INT(11) NOT NULL,
  `type` INT(11) NOT NULL,
  `number` INT(11) NOT NULL,
  `exist` INT(11) NULL,
  `title` VARCHAR(200) NULL,
  `name` VARCHAR(100) NOT NULL,
  `file` VARCHAR(200) NULL,
  `path` VARCHAR(400) NULL,
  `addedfrom` INT(11) NOT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvisit_documents` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvisit_documents` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

/***** 21: Anexa la tabla 'tblcvisit_detail', guarda los cambios de estatus de la operacion */
DROP TABLE IF EXISTS `tblcvisit_detail`;
CREATE TABLE `tblcvisit_detail` (
  `id` INT(11) NOT NULL,
  `visit` INT(11) NOT NULL,
  `status` INT(11) NOT NULL,
  `note` VARCHAR(400) NULL,
  `addedfrom` INT(11) NOT NULL,
  `date_add` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	-- Indices de la tabla
	ALTER TABLE `tblcvisit_detail` ADD PRIMARY KEY (`id`);
	-- AUTO_INCREMENT de la tabla
	ALTER TABLE `tblcvisit_detail` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;


            