/***********************
/***** UPDATE 1 SERVOWEB */

/**** PROCESS SIMULATORS
/***** 1: add table tblmodules  */
CREATE TABLE `tblmodule` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tblmodule` (`id`, `name`) VALUES
(1, 'Comisión Gas'),
(2, 'Simulador Electricidad'),
(3, 'Comisión Eléctricidad'),
(4, 'Simulador Gas');
ALTER TABLE `tblmodule` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblmodule` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/***** 2: add table tblsimudetpricetable  */
CREATE TABLE `tblsimudetpricetable` (
  `id` int(11) NOT NULL,
  `marketer` int(11) DEFAULT NULL,
  `headpricetable` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `hiredpotency` int(11) DEFAULT NULL,
  `columnprice1` decimal(15,6) DEFAULT NULL,
  `columnprice2` decimal(15,6) DEFAULT NULL,
  `columnprice3` decimal(15,6) DEFAULT NULL,
  `columnprice4` decimal(15,6) DEFAULT NULL,
  `columnprice5` decimal(15,6) DEFAULT NULL,
  `columnprice6` decimal(15,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimudetpricetable` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimudetpricetable` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 3: add table tblsimufinished  */
CREATE TABLE `tblsimufinished` (
  `id` int(11) NOT NULL,
  `detalle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tblsimufinished` (`id`, `detalle`) VALUES
(1, 'POTENCIA'),
(2, 'ENERGÍA'),
(3, 'GAS TÉRMINO FIJO'),
(4, 'GAS TÉRMINO VARIABLE');
ALTER TABLE `tblsimufinished` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimufinished` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/***** 4: add table tblsimuheadpricetable  */
CREATE TABLE `tblsimuheadpricetable` (
  `id` int(11) NOT NULL,
  `marketer` int(11) DEFAULT NULL,
  `modality` int(11) DEFAULT NULL,
  `finished` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimuheadpricetable` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimuheadpricetable` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 5: add table tblsimuhiredpotency  */
CREATE TABLE `tblsimuhiredpotency` (
  `id` int(11) NOT NULL,
  `detalle` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimuhiredpotency` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimuhiredpotency` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 6: add table tblsimusimulators  */
CREATE TABLE `tblsimulators` (
  `id` int(11) NOT NULL,
  `client` int(11) DEFAULT NULL,
  `supply_points` int(11) DEFAULT NULL,
  `nif` varchar(80) DEFAULT NULL,
  `cups` varchar(80) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `consumo_potencia1` decimal(15,6) DEFAULT '0.000000',
  `consumo_potencia2` decimal(15,6) DEFAULT '0.000000',
  `consumo_potencia3` decimal(15,6) DEFAULT '0.000000',
  `consumo_potencia4` decimal(15,6) DEFAULT '0.000000',
  `consumo_potencia5` decimal(15,6) DEFAULT '0.000000',
  `consumo_potencia6` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia1` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia2` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia3` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia4` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia5` decimal(15,6) DEFAULT '0.000000',
  `consumo_energia6` decimal(15,6) DEFAULT NULL,
  `trash` tinyint(1) DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  `dateadded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `precio_potencia1` decimal(15,6) DEFAULT '0.000000',
  `precio_potencia2` decimal(15,6) DEFAULT '0.000000',
  `precio_potencia3` decimal(15,6) DEFAULT '0.000000',
  `precio_potencia4` decimal(15,6) DEFAULT '0.000000',
  `precio_potencia5` decimal(15,6) DEFAULT '0.000000',
  `precio_potencia6` decimal(15,6) DEFAULT '0.000000',
  `precio_energia1` decimal(15,6) DEFAULT '0.000000',
  `precio_energia2` decimal(15,6) DEFAULT '0.000000',
  `precio_energia3` decimal(15,6) DEFAULT '0.000000',
  `precio_energia4` decimal(15,6) DEFAULT '0.000000',
  `precio_energia5` decimal(15,6) DEFAULT '0.000000',
  `precio_energia6` decimal(15,6) DEFAULT '0.000000',
  `savings_potency` decimal(15,6) DEFAULT '0.000000',
  `savings_energy` decimal(15,6) DEFAULT '0.000000',
  `total_savings` decimal(15,6) DEFAULT '0.000000',
  `marketer_savings` varchar(80) DEFAULT NULL,
  `gas` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimulators` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
ALTER TABLE `tblsimulators` ADD PRIMARY KEY (`id`);
/***** 7: add table tblsimurate  */
CREATE TABLE `tblsimurate` (
  `id` int(11) NOT NULL,
  `detalle` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimurate` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimurate` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 8: add table tblsimutyperates  */
CREATE TABLE `tblsimutyperates` (
  `id` int(11) NOT NULL,
  `detalle` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblsimutyperates` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblsimutyperates` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;