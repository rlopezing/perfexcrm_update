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