/*
Para el uso con RAILS colocar los nombres de las tablas y llaves foráneas en plural
De acuerdo a la base de datos utilizada la sintaxis del AUTO_INCREMENT puede variar
http://www.w3schools.com/sql/sql_AUTO_INCREMENT.asp
Los tipos de dato también pueden varias entre bases de datos, se recomienda utilizar
campos ENUM o BOOLEAN para los campos bandera cuando la base de datos lo permita:
professor.is_admin, student_id_admin, group.enabled => boolean
test.status => ENUM('inactive','active','finished');
*/

CREATE TABLE professor (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	document_number varchar(255) NOT NULL,
	first_name varchar(255) NOT NULL,
	last_name varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	username varchar(255) NOT NULL,
	is_admin integer DEFAULT 0,
	email varchar(255) NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime);


CREATE TABLE student (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	first_name varchar(255) NOT NULL,
	username varchar(255) NOT NULL,
	last_name varchar(255) NOT NULL,
	document_number varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	is_admin integer DEFAULT 0,
	email varchar(255) NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime);



CREATE TABLE course (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	code varchar(255) NOT NULL,
	name varchar(255) NOT NULL,
	description varchar(255),
	created_at datetime NOT NULL,
	updated_at datetime);



CREATE TABLE `group` (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	course_id integer NOT NULL REFERENCES course(id) ON DELETE RESTRICT,
	quarter varchar(255),
	professor_id integer NOT NULL REFERENCES professor(id) ON DELETE RESTRICT,
	group_number integer DEFAULT 0,
	created_at datetime NOT NULL,
	updated_at datetime,
	enabled integer DEFAULT 1);



CREATE TABLE registration (
	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	group_id INTEGER NOT NULL REFERENCES `group`(id) ON DELETE CASCADE,
	student_id INTEGER NOT NULL REFERENCES student(id) ON DELETE CASCADE,
	CONSTRAINT pk_registration UNIQUE (group_id, student_id)
	);



CREATE TABLE test (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	group_id INTEGER NOT NULL REFERENCES `group`(id) ON DELETE CASCADE,
	description varchar(255),
	application_date datetime,
	status integer DEFAULT 0,
	term_in_minutes integer DEFAULT 0,
	percent integer DEFAULT 0,
	comments text,
	created_at datetime NOT NULL,
	updated_at datetime);




CREATE TABLE question (
	id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	test_id INTEGER NOT NULL REFERENCES test(id) ON DELETE RESTRICT,
	question_text text,
	correct_answer_text text,
	value integer DEFAULT 0);


CREATE TABLE answer (
  id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  student_id INTEGER NOT NULL REFERENCES student(id) ON DELETE RESTRICT,
  question_id INTEGER NOT NULL REFERENCES question(id) ON DELETE RESTRICT,
  answer_text text,
  score integer DEFAULT 0);


CREATE TABLE notification_sent (
  id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  student_id INTEGER NOT NULL REFERENCES student(id) ON DELETE RESTRICT,
  test_id INTEGER NOT NULL REFERENCES test(id) ON DELETE RESTRICT);


SELECT * FROM notification_sent;
INSERT INTO test () VALUE ();
SELECT * FROM test WHERE id='1';

