
INSERT INTO `menu` (`mnuid`, `mnunm`, `mnumodule`, `mnuicon`, `mnulv`, `mnusort`, `mnuparent`) VALUES ('95', 'Import', 'import', 'fa fa-upload', '3', '24', '20');
INSERT INTO `permission` (`pmsrolcd`, `pmsmnuid`, `pmsauth`) VALUES ('ADM', '95', 'W');

INSERT INTO `prmhdr` (`pmhtbno`, `pmhdesc`) VALUES ('13', 'Import File');


INSERT INTO `prmdtl` (`pmdtbno`, `pmdcd`, `pmddesc`, pmdval1) VALUES ('13', 'SAL', 'Sales File', 'Sales');
INSERT INTO `prmdtl` (`pmdtbno`, `pmdcd`, `pmddesc`, pmdval1) VALUES ('13', 'STK', 'Stocks File', 'Stocks');

INSERT INTO `prmhdr` (`pmhtbno`, `pmhdesc`) VALUES ('14', 'Partner');
INSERT INTO `prmdtl` (`pmdtbno`, `pmdcd`, `pmddesc`) VALUES ('14', 'KKM', 'Krua Kroo Meuk');
INSERT INTO `prmdtl` (`pmdtbno`, `pmdcd`, `pmddesc`) VALUES ('14', 'FPD', 'Food Panda');
INSERT INTO `prmdtl` (`pmdtbno`, `pmdcd`, `pmddesc`) VALUES ('14', 'NPF', 'Baan Noppadol');

CREATE TABLE `ocha_sales_import` (
	`isalpaydate` VARCHAR(50) NULL DEFAULT NULL,
	`isalordno` VARCHAR(10) NULL DEFAULT NULL,
	`isalorddate` VARCHAR(50) NULL DEFAULT NULL,
	`isalordnm` VARCHAR(30) NULL DEFAULT NULL,
	`isalamt` VARCHAR(10) NULL DEFAULT NULL,
	`isalret` VARCHAR(10) NULL DEFAULT NULL,
	`isalstat` VARCHAR(15) NULL DEFAULT NULL
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `sales_daily` (
	`saldocno` VARCHAR(10) NOT NULL,
	`salorddttm` DATETIME NOT NULL,
	`salpaydttm` DATETIME NOT NULL,
	`salordfrom` VARCHAR(50) NULL DEFAULT NULL,
	`salordtyp` VARCHAR(5) NULL DEFAULT NULL,
	`salamt` INT(11) NULL DEFAULT NULL,
	`salretamt` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`saldocno`),
	INDEX `IDX_ORDTYP` (`salordtyp`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
