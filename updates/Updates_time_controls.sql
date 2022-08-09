/***********************
/***** UPDATE 1 SERVOWEB */

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
CREATE FUNCTION `func_difference` (`dateadd` VARCHAR(10), `hoursmyday` FLOAT, `holiday` INT) RETURNS FLOAT BEGIN
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
CREATE FUNCTION `func_holiday` (`dateadd` VARCHAR(10)) RETURNS INT(11) BEGIN
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
CREATE FUNCTION `func_holidayreason` (`dateadd` VARCHAR(10)) RETURNS VARCHAR(150) CHARSET utf8 BEGIN
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
CREATE FUNCTION `func_hoursmyday` (`date_add` VARCHAR(10)) RETURNS INT(11) BEGIN
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
CREATE FUNCTION `func_hoursrest` (`dateadd` VARCHAR(10)) RETURNS TEXT CHARSET utf8 BEGIN
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
CREATE FUNCTION `func_idmyday` (`date_add` VARCHAR(10)) RETURNS INT(11) BEGIN
	declare id int;
    
    select tbltcmysdays.mydayid 
    into id
	from tbltcmysdays inner join tbltcreasons on tbltcreasons.reasonid = tbltcmysdays.reasonid 
	where date_format(date_add, '%Y-%m-%d') >= date_format(tbltcmysdays.start_date, '%Y-%m-%d') 
		and date_format(date_add, '%Y-%m-%d') <= date_format(tbltcmysdays.end_date, '%Y-%m-%d');
        
RETURN id;
END$$
/***** 17: add function func_reasonmyday  */
CREATE FUNCTION `func_reasonmyday` (`date_add` VARCHAR(10)) RETURNS VARCHAR(150) CHARSET utf8 BEGIN
	declare reason varchar(150);
    
	select tbltcreasons.name into reason
    from tbltcmysdays inner join tbltcreasons on tbltcreasons.reasonid = tbltcmysdays.reasonid 
    where date_format(date_add, '%Y-%m-%d') >= date_format(tbltcmysdays.start_date, '%Y-%m-%d') 
		and date_format(date_add, '%Y-%m-%d') <= date_format(tbltcmysdays.end_date, '%Y-%m-%d');

RETURN (reason);
END$$
/***** 18: add function func_totalhours  */
CREATE FUNCTION `func_totalhours` (`dateadd` VARCHAR(10), `hoursmyday` FLOAT, `holiday` INT) RETURNS FLOAT BEGIN
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