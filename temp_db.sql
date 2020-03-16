drop database if exists arduino;
create database arduino default character set= utf8 collate utf8_general_ci ;
DROP USER IF EXISTS  sample@localhost;
create user sample@localhost identified by 'password';
grant all privileges on arduino.* to 'sample'@'localhost';
use arduino;


create table temp_tb(
	id		int primary key not null auto_increment,
    temp	integer,
	dt		timestamp not null default now()
);
#더미데이터