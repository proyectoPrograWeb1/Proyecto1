/*Inserts tabla PROFESSOR*/
INSERT INTO professor (document_number,first_name,last_name,password,username,is_admin,email, created_at, updated_at) 
VALUE ('2456789','Fernando', 'Perez', 'fernaperez245', 'Fernando245', 1, 'fernan_perez@gmail.com', '2013-10-27 18:13:00','2013-10-27 18:13:00');

SELECT * FROM professor;

/*Inserts tabla STUDENT*/
INSERT INTO student (first_name,username, last_name, document_number,password,is_admin,email, created_at, updated_at) 
VALUE ('Gerardo', 'Gerfuentes263', 'Fuentes', '2638957', 'gerfuentes263', 0, 'gerfuentes@hotmail.com', '2013-10-27 18:13:00','2013-10-27 18:13:00');

INSERT INTO student (first_name,username, last_name, document_number,password,is_admin,email, created_at, updated_at) 
VALUE ('Gerardo', 'Gerfuentes263', 'Fuentes', '2638957', 'gerfuentes263', 0, 'gerfuentes@hotmail.com', '2013-10-27 18:13:00','2013-10-27 18:13:00');

SELECT * FROM student;

/*Inserts tabla COURSE*/
INSERT INTO course (code,name, description,created_at, updated_at) 
VALUE ('ISW-345','Programación en Ambiente Web I', 'Los estudiantes alcanzaran un conocimiento básico en el diseño web', '2013-10-27 18:13:00','2013-10-27 18:13:00');

SELECT * FROM course;

/*Inserts tabla GROUP*/
INSERT INTO `group` (course_id, quarter, professor_id, group_number, created_at, updated_at) 
VALUE (1, 'primer cuatrimestre', 1, 1,'2013-10-27 18:13:00','2013-10-27 18:13:00');

SELECT * FROM `group`;

/*Inserts tabla REGISTRATION*/
INSERT INTO registration (group_id, student_id) 
VALUE (1, 1);

INSERT INTO registration (group_id, student_id) 
VALUE (1, 2);
SELECT student_id FROM registration WHERE group_id = 1;
SELECT * FROM registration;

/*Inserts tabla TEST*/
INSERT INTO test (group_id, description, application_date, status, term_in_minutes, percent, comments, created_at, updated_at) 
VALUE (1, 'Quiz 1 Programacion en Ambiente Web I','2013-10-27 18:13:00' ,1, 30, 40, 'Primer quiz del curso', '2013-10-27 18:13:00', '2013-10-27 18:13:00');

SELECT id, first_name, last_name, email FROM student;

SELECT * FROM test;

SELECT application_date, term_in_minutes , group_id FROM test WHERE application_date < '2013-10-29 18:13:00'
and status=1;




