USE translatable;
DROP TABLE IF EXISTS basic;
DROP TABLE IF EXISTS table1;
DROP TABLE IF EXISTS table2;
DROP TABLE IF EXISTS table3;
DROP TABLE IF EXISTS translation;
DROP TABLE IF EXISTS translatable2.table1;
DROP TABLE IF EXISTS translatable2.table2;
DROP TABLE IF EXISTS translatable2.translation;

CREATE TABLE basic (
  id INT NOT NULL AUTO_INCREMENT,
  value VARCHAR(255) NULL,
  PRIMARY KEY (id));

CREATE TABLE table1 (
  id INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id));

CREATE TABLE table2 (
  id INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id));

CREATE TABLE table3 (
  t1_id INT,
  t2_id INT,
  PRIMARY KEY (t1_id, t2_id));

CREATE TABLE translatable2.table1 (
  id INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id));

CREATE TABLE translatable2.table2 (
  id INT NOT NULL AUTO_INCREMENT,
  t1_id INT NOT NULL,
  PRIMARY KEY (id));


CREATE TABLE translation (
  `table` VARCHAR(255) NOT NULL,
  field VARCHAR(255) NOT NULL,
  row VARCHAR(255) NOT NULL,
  lang CHAR(2) NOT NULL,
  text TEXT NOT NULL,
  PRIMARY KEY (`table` ASC, field ASC, row ASC, lang ASC));

CREATE TABLE translatable2.translation (
  `table` VARCHAR(255) NOT NULL,
  field VARCHAR(255) NOT NULL,
  row VARCHAR(255) NOT NULL,
  lang CHAR(2) NOT NULL,
  text TEXT NOT NULL,
  PRIMARY KEY (`table` ASC, field ASC, row ASC, lang ASC));
