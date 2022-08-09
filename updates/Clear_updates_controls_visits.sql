/***********************
/**** PROCESS CONTROLS VISITS
/***** CLEAR UPDATE 1 SERVOWEB */

DROP TABLE IF EXISTS tblcvisit;
DROP TABLE IF EXISTS tblcvtype;
DROP TABLE IF EXISTS tblcvstatus;
DROP TABLE IF EXISTS tblcvisit_management;
DROP TABLE IF EXISTS tblcvcontact_type;
ALTER TABLE tblclients DROP COLUMN `type`;
DROP TABLE IF EXISTS tblcvisit_comments;
DROP TABLE IF EXISTS tblcvtake_data;
DROP TABLE IF EXISTS tblcvrelation_ship;
DROP TABLE IF EXISTS tblcvcivil_status;