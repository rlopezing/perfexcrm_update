/***********************
/***** UPDATE 1 SERVOWEB */

/**** PROCESS RETURNS
/***** 1: Anexa el campo 'relinvoice' que contiene el numero de la factura a la cual pertenece el abono */
alter table tblinvoices add column relinvoice int(11) null default 0 after number;
/***** 2: Anexa el prefijo para abonos en la tabla tbloptions */
insert into tbloptions (name, value, autoload) values ('return_prefix', 'A_', 1);
/***** 3: Anexa el correlativo para abonos en la tabla tbloptions */
insert into tbloptions (name, value, autoload) values ('next_return_number', '1', 0);