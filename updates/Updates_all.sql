/***********************
/***** UPDATE 1 SERVOWEB */

/**** PROCESS COMMISSIONS
/***** 1: add table the contracts  */
CREATE TABLE `tblcomicontratos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nif` char(15) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `cpe` varchar(45) DEFAULT NULL,
  `nivel_tension` varchar(45) DEFAULT NULL,
  `potencia_contratada` int(11) DEFAULT NULL,
  `consumo_anual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `comercializador` int(11) DEFAULT NULL,
  `tarifa` int(11) DEFAULT NULL,
  `nivel_precios` int(11) DEFAULT NULL,
  `fecha_suscripcion` datetime DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_inicio_suministro` datetime DEFAULT NULL,
  `fecha_fin_suministro` datetime DEFAULT NULL,
  `fecha_comerciante` datetime DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `categoria_comercial` int(11) NOT NULL,
  `socio` int(11) NOT NULL,
  `comercial` int(11) NOT NULL,
  `valor_contrato` decimal(15,2) NOT NULL DEFAULT '0.00',
  `comision_socio` decimal(15,2) NOT NULL DEFAULT '0.00',
  `comision_comercial` decimal(15,2) NOT NULL DEFAULT '0.00',
  `comision_emsconsulting` decimal(15,2) NOT NULL DEFAULT '0.00',
  `trash` tinyint(1) DEFAULT '0',
  `hash` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 2: add table tblcomicomercializador  */
CREATE TABLE `tblcomicomercializador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 3: add table tblcomitarifa  */
CREATE TABLE `tblcomitarifa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comercializador` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 4: add table tblcominivelprecio  */
CREATE TABLE `tblcominivelprecio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comercializador` int(11) NOT NULL,
  `detalle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 5: add table tblcomicategoriacomercial  */
CREATE TABLE `tblcomicategoriacomercial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detalle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 6: add table tblcominiveltension  */
CREATE TABLE `tblcominiveltension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 7: add table tblcomicontractcomments  */
CREATE TABLE `tblcomicontractcomments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `content` MEDIUMTEXT NULL DEFAULT NULL,
  `contract_id` INT(11) NULL,
  `staffid` INT(11) NULL,
  `dateadded` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 8: add table tblcomifiles  */
CREATE TABLE `tblcomifiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `file_name` varchar(600) NOT NULL,
  `filetype` varchar(40) DEFAULT NULL,
  `visible_to_customer` int(11) NOT NULL DEFAULT '0',
  `attachment_key` varchar(32) DEFAULT NULL,
  `external` varchar(40) DEFAULT NULL,
  `external_link` text,
  `thumbnail_link` text COMMENT 'For external usage',
  `staffid` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT '0',
  `task_comment_id` int(11) NOT NULL DEFAULT '0',
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 9: add table tblcominotes  */
CREATE TABLE `tblcominotes` (
  `id` int(11) NOT NULL,
  `rel_id` int(11) NOT NULL,
  `rel_type` varchar(20) NOT NULL,
  `description` text,
  `date_contacted` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 10: add table tblcomicontractrenewals  */
CREATE TABLE `tblcomicontractrenewals` (
  `id` int(11) NOT NULL,
  `contractid` int(11) NOT NULL,
  `old_start_date` date NOT NULL,
  `new_start_date` date NOT NULL,
  `old_end_date` date DEFAULT NULL,
  `new_end_date` date DEFAULT NULL,
  `old_value` decimal(15,2) DEFAULT NULL,
  `new_value` decimal(15,2) DEFAULT NULL,
  `date_renewed` datetime NOT NULL,
  `renewed_by` varchar(100) NOT NULL,
  `renewed_by_staff_id` int(11) NOT NULL DEFAULT '0',
  `is_on_old_expiry_notified` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 11: add table tblcomistafftasks  */
CREATE TABLE `tblcomistafftasks` (
  `id` int(11) NOT NULL,
  `name` mediumtext,
  `description` text,
  `priority` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL,
  `startdate` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `datefinished` datetime DEFAULT NULL,
  `addedfrom` int(11) NOT NULL,
  `is_added_from_contact` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `recurring_type` varchar(10) DEFAULT NULL,
  `repeat_every` int(11) DEFAULT NULL,
  `recurring` int(11) NOT NULL DEFAULT '0',
  `is_recurring_from` int(11) DEFAULT NULL,
  `cycles` int(11) NOT NULL DEFAULT '0',
  `total_cycles` int(11) NOT NULL DEFAULT '0',
  `custom_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `last_recurring_date` date DEFAULT NULL,
  `rel_id` int(11) DEFAULT NULL,
  `rel_type` varchar(30) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `billable` tinyint(1) NOT NULL DEFAULT '0',
  `billed` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `hourly_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `milestone` int(11) DEFAULT '0',
  `kanban_order` int(11) NOT NULL DEFAULT '0',
  `milestone_order` int(11) NOT NULL DEFAULT '0',
  `visible_to_client` tinyint(1) NOT NULL DEFAULT '0',
  `deadline_notified` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 12: add table tblcomiplanos  */
CREATE TABLE `tblcomiplanos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `comercializador` INT(11) NULL,
  `categoria_comercial` INT(11) NULL,
  `tarifa` INT(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 13: add table tblcomiplanosconsumos  */
CREATE TABLE `tblcomiplanosconsumos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plano` int(11) NULL,
  `anual` bit(1) NULL,
  `mensual` bit(1) NULL DEFAULT 0,
  `limite_inferior` DECIMAL(15) NULL DEFAULT 0,
  `limite_superior` DECIMAL(15) NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/***** 14: add table tblcomiplanoscostos  */
CREATE TABLE `tblcomiplanoscostos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `consumo` INT(11) NULL,
  `nivel_precio` INT(11) NULL,
  `comision` DECIMAL(15) NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/***** 15: add table tblcomistaff_assign  */
CREATE TABLE `tblcomistaff_assign` (
  `id` int(11) NOT NULL,
  `staff` int(11) DEFAULT NULL,
  `commercial_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tblcomistaff_assign` ADD PRIMARY KEY (`id`);
ALTER TABLE `tblcomistaff_assign` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 16: Anexa el campo 'relinvoice' que contiene el numero de la factura a la cual pertenece el abono */
alter table tblinvoices add column contracts varchar(200) DEFAULT NULL;

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

/**** PROCESS TIME CONTROLS
/***** 1: add table tbltcholidays  */
CREATE TABLE `tbltcholidays` (
  `holidayid` int(11) NOT NULL,
  `holiday_date` datetime NOT NULL,
  `holiday_reason` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbltcholidays` (`holidayid`, `holiday_date`, `holiday_reason`) VALUES
(1, '2019-01-01 00:00:00', 'Año Nuevo'),
(2, '2019-06-12 00:00:00', 'Día del trabajo'),
(3, '2019-03-18 00:00:00', 'San José'),
(4, '2019-06-13 00:00:00', 'Prueba de dia');
ALTER TABLE `tbltcholidays` ADD PRIMARY KEY (`holidayid`);
ALTER TABLE `tbltcholidays` MODIFY `holidayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/***** 2: add table tbltcmodalitys  */
CREATE TABLE `tbltcmodalitys` (
  `modalityid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbltcmodalitys` (`modalityid`, `name`) VALUES
(1, 'Jornada completa'),
(2, 'Tiempo parcial');
ALTER TABLE `tbltcmodalitys` ADD PRIMARY KEY (`modalityid`);
ALTER TABLE `tbltcmodalitys` MODIFY `modalityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/***** 3: add table tbltcmysdays  */
CREATE TABLE `tbltcmysdays` (
  `mydayid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `reasonid` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `start_hour` time DEFAULT NULL,
  `end_hour` time DEFAULT NULL,
  `notes` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbltcmysdays` ADD PRIMARY KEY (`mydayid`);
ALTER TABLE `tbltcmysdays` MODIFY `mydayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 4: add table tbltcreasons  */
CREATE TABLE `tbltcreasons` (
  `reasonid` int(11) NOT NULL,
  `type_reason` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbltcreasons` (`reasonid`, `type_reason`, `name`) VALUES
(1, 1, 'Vacaciones'),
(2, 1, 'Nacimiento de hija/o'),
(3, 1, 'Defunsión'),
(4, 1, 'Horas de ausencia'),
(5, 1, 'Maternidad'),
(6, 1, 'Mudanza'),
(7, 1, 'Otros'),
(8, 1, 'Paternidad'),
(9, 1, 'Media jornada'),
(10, 1, 'Enfermedad'),
(11, 1, 'Boda'),
(12, 2, 'Horas extras'),
(13, 2, 'Trabajar en día festivo');
ALTER TABLE `tbltcreasons` ADD PRIMARY KEY (`reasonid`);
ALTER TABLE `tbltcreasons` MODIFY `reasonid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/***** 5: add table tbltcschedule  */
CREATE TABLE `tbltcschedule` (
  `scheduleid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `modalityid` int(11) NOT NULL,
  `entry_time` time NOT NULL,
  `rest_start` time NOT NULL,
  `end_rest` time NOT NULL,
  `departure_time` time NOT NULL,
  `weekly_holidays` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbltcschedule` ADD PRIMARY KEY (`scheduleid`);
ALTER TABLE `tbltcschedule` MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 6: add table tbltcscheduleassignment  */
CREATE TABLE `tbltcscheduleassignment` (
  `scheduleassignmentid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `scheduleid` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbltcscheduleassignment` ADD PRIMARY KEY (`scheduleassignmentid`);
ALTER TABLE `tbltcscheduleassignment` MODIFY `scheduleassignmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 7: add table tbltcscheduleholidays  */
CREATE TABLE `tbltcscheduleholidays` (
  `scheduleholidayid` int(11) NOT NULL,
  `scheduleid` int(11) NOT NULL,
  `holidayid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbltcscheduleholidays` ADD PRIMARY KEY (`scheduleholidayid`);
ALTER TABLE `tbltcscheduleholidays` MODIFY `scheduleholidayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 8: add table tbltctimecontrols  */
CREATE TABLE `tbltctimecontrols` (
  `timecontrolid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `entry_time` time DEFAULT NULL,
  `rest_start` time DEFAULT NULL,
  `end_rest` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `rest` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbltctimecontrols` ADD PRIMARY KEY (`timecontrolid`);
ALTER TABLE `tbltctimecontrols` MODIFY `timecontrolid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/***** 9: add table tbltctypesreasons  */
CREATE TABLE `tbltctypesreasons` (
  `typereasonid` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `tbltctypesreasons` (`typereasonid`, `name`) VALUES
(1, 'Ausencia'),
(2, 'Presencia');
ALTER TABLE `tbltctypesreasons` ADD PRIMARY KEY (`typereasonid`);
ALTER TABLE `tbltctypesreasons` MODIFY `typereasonid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/***** 10: add view view_listsigning  */
CREATE TABLE `view_listsigning` (
`timecontrolid` int(11)
,`staffid` int(11)
,`date_add` datetime
,`full_name` varchar(101)
,`reason` varchar(150)
,`horas_motivo` int(11)
,`entry_time` time
,`departure_time` time
,`horas_descanso` decimal(24,4)
,`total_horas` float
,`diferencia` float
);
DROP TABLE IF EXISTS `view_listsigning`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_listsigning`  AS  select `tbltctimecontrols`.`timecontrolid` AS `timecontrolid`,`tbltctimecontrols`.`staffid` AS `staffid`,`tbltctimecontrols`.`date_add` AS `date_add`,concat(`tblstaff`.`firstname`,' ',`tblstaff`.`lastname`) AS `full_name`,`FUNC_REASONMYDAY`(`tbltctimecontrols`.`date_add`) AS `reason`,`FUNC_HOURSMYDAY`(`tbltctimecontrols`.`date_add`) AS `horas_motivo`,`tbltctimecontrols`.`entry_time` AS `entry_time`,`tbltctimecontrols`.`departure_time` AS `departure_time`,(timestampdiff(MINUTE,`tbltctimecontrols`.`rest_start`,`tbltctimecontrols`.`end_rest`) / 60) AS `horas_descanso`,`FUNC_TOTALHOURS`('2019-06-01','2019-06-30',`FUNC_HOURSMYDAY`(`tbltctimecontrols`.`date_add`)) AS `total_horas`,`FUNC_DIFFERENCE`('2019-06-01','2019-06-30',`FUNC_HOURSMYDAY`(`tbltctimecontrols`.`date_add`)) AS `diferencia` from (((`tbltctimecontrols` join `tblstaff` on((`tblstaff`.`staffid` = `tbltctimecontrols`.`staffid`))) join `tbltcscheduleassignment` on((`tbltcscheduleassignment`.`staffid` = `tbltctimecontrols`.`staffid`))) join `tbltcschedule` on((`tbltcschedule`.`scheduleid` = `tbltcscheduleassignment`.`scheduleid`))) where (date_format(`tbltctimecontrols`.`date_add`,'%Y-%m-%d') between '2019-06-01' and '2019-06-30') ;
/***** 11: add function func_difference  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_difference` (`dateadd` VARCHAR(10), `hoursmyday` FLOAT, `holiday` INT) RETURNS FLOAT BEGIN
	declare difference float;
    declare hours_schedule float;
    declare hours_tc float;
    
	select ((TIMESTAMPDIFF(MINUTE, tbltcschedule.entry_time, tbltcschedule.departure_time)/60)-
		(TIMESTAMPDIFF(MINUTE, tbltcschedule.rest_start, tbltcschedule.end_rest)/60))
	into hours_schedule
	from tbltctimecontrols
		inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid
		inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid
		inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid
	where date_format(tbltctimecontrols.date_add, '%Y-%m-%d') between dateadd and dateadd;
    
	select ((TIMESTAMPDIFF(MINUTE, tbltctimecontrols.entry_time, tbltctimecontrols.departure_time)/60)-
		(TIMESTAMPDIFF(MINUTE, tbltctimecontrols.rest_start, tbltctimecontrols.end_rest)/60))
	into hours_tc
	from tbltctimecontrols
		inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid
		inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid
		inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid
	where date_format(tbltctimecontrols.date_add, '%Y-%m-%d') between dateadd and dateadd;
    
    set difference = hours_schedule - hours_tc;
    
    if (hoursmyday = 8) then set difference = hoursmyday - hours_schedule; end if;
    if (holiday = 1) then set difference = 0; end if;
    
RETURN (difference);
END$$
/***** 12: add function func_holiday  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_holiday` (`dateadd` VARCHAR(10)) RETURNS INT(11) BEGIN
	declare holiday int;
    
	select count(tbltcholidays.holidayid)
    into holiday
	from tbltctimecontrols
		inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid
		inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid
		inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid
		inner join tbltcscheduleholidays on tbltcscheduleholidays.scheduleid = tbltcschedule.scheduleid
		inner join tbltcholidays on tbltcholidays.holidayid = tbltcscheduleholidays.holidayid
	where date_format(tbltcholidays.holiday_date, '%Y-%m-%d') = date_format(dateadd, '%Y-%m-%d');

RETURN (holiday);
END$$
/***** 13: add function func_holidayreason  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_holidayreason` (`dateadd` VARCHAR(10)) RETURNS VARCHAR(150) CHARSET utf8 BEGIN
	declare holidayreason varchar(150);
    
	select tbltcholidays.holiday_reason 
    into holidayreason
	from tbltctimecontrols
		inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid
		inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid
		inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid
		inner join tbltcscheduleholidays on tbltcscheduleholidays.scheduleid = tbltcschedule.scheduleid
		inner join tbltcholidays on tbltcholidays.holidayid = tbltcscheduleholidays.holidayid
	where date_format(tbltcholidays.holiday_date, '%Y-%m-%d') = date_format(dateadd, '%Y-%m-%d')
		and date_format(tbltctimecontrols.date_add, '%Y-%m-%d') = date_format(dateadd, '%Y-%m-%d');
    
RETURN (holidayreason);
END$$
/***** 14: add function func_hoursmyday  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_hoursmyday` (`date_add` VARCHAR(10)) RETURNS INT(11) BEGIN
	declare hours int;
    declare diff int;
    
    select DATEDIFF(tbltcmysdays.end_date,tbltcmysdays.start_date) 
    into diff
	from tbltcmysdays inner join tbltcreasons on tbltcreasons.reasonid = tbltcmysdays.reasonid 
	where date_format(date_add, '%Y-%m-%d') >= date_format(tbltcmysdays.start_date, '%Y-%m-%d') 
		and date_format(date_add, '%Y-%m-%d') <= date_format(tbltcmysdays.end_date, '%Y-%m-%d');
        
    if diff = 0 then set hours = 8; end if;
    if diff > 0 then set hours = 12; end if;
    
RETURN (hours);
END$$
/***** 15: add function func_hoursrest  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_hoursrest` (`dateadd` VARCHAR(10)) RETURNS TEXT CHARSET utf8 BEGIN
	declare total_hours float;
    declare json_rest text;
    set total_hours = 10;
    
    select (rest)
    into json_rest
	from tbltctimecontrols
	where tbltctimecontrols.date_add between dateadd and dateadd;
    
    set json_rest = JSON_PRETTY(json_rest);
    
RETURN json_rest;
END$$
/***** 16: add function func_idmyday  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_idmyday` (`date_add` VARCHAR(10)) RETURNS INT(11) BEGIN
	declare id int;
    
    select tbltcmysdays.mydayid 
    into id
	from tbltcmysdays inner join tbltcreasons on tbltcreasons.reasonid = tbltcmysdays.reasonid 
	where date_format(date_add, '%Y-%m-%d') >= date_format(tbltcmysdays.start_date, '%Y-%m-%d') 
		and date_format(date_add, '%Y-%m-%d') <= date_format(tbltcmysdays.end_date, '%Y-%m-%d');
        
RETURN id;
END$$
/***** 17: add function func_reasonmyday  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_reasonmyday` (`date_add` VARCHAR(10)) RETURNS VARCHAR(150) CHARSET utf8 BEGIN
	declare reason varchar(150);
    
	select tbltcreasons.name into reason
    from tbltcmysdays inner join tbltcreasons on tbltcreasons.reasonid = tbltcmysdays.reasonid 
    where date_format(date_add, '%Y-%m-%d') >= date_format(tbltcmysdays.start_date, '%Y-%m-%d') 
		and date_format(date_add, '%Y-%m-%d') <= date_format(tbltcmysdays.end_date, '%Y-%m-%d');

RETURN (reason);
END$$
/***** 18: add function func_totalhours  */
CREATE DEFINER=`root`@`localhost` FUNCTION `func_totalhours` (`dateadd` VARCHAR(10), `hoursmyday` FLOAT, `holiday` INT) RETURNS FLOAT BEGIN
	declare total_hours float;
    declare hours_myday float;
    
	select ((TIMESTAMPDIFF(MINUTE, tbltctimecontrols.entry_time, tbltctimecontrols.departure_time)/60)-
		(TIMESTAMPDIFF(MINUTE, tbltctimecontrols.rest_start, tbltctimecontrols.end_rest)/60))
	into total_hours
	from tbltctimecontrols
		inner join tblstaff on tblstaff.staffid = tbltctimecontrols.staffid
		inner join tbltcscheduleassignment on tbltcscheduleassignment.staffid = tbltctimecontrols.staffid
		inner join tbltcschedule on tbltcschedule.scheduleid = tbltcscheduleassignment.scheduleid
	where date_format(tbltctimecontrols.date_add, '%Y-%m-%d') between dateadd and dateadd;
    
    if (hoursmyday = 8) then set total_hours = hoursmyday; end if;
    if (holiday = 1) then set total_hours = 8; end if;
    
RETURN (total_hours);
END$$

/**** PROCESS RETURNS
/***** 1: Anexa el campo 'relinvoice' que contiene el numero de la factura a la cual pertenece el abono */
alter table tblinvoices add column relinvoice int(11) null default 0 after number;
/***** 2: Anexa el prefijo para abonos en la tabla tbloptions */
insert into tbloptions (name, value, autoload) values ('return_prefix', 'A_', 1);
/***** 3: Anexa el correlativo para abonos en la tabla tbloptions */
insert into tbloptions (name, value, autoload) values ('next_return_number', '1', 0);