<?php

	require ('EnviarEmail.php');
	//Variable que guarda el parametro de la conexión.
	$confi= $argv[1];
	//Lee el fichero en una variable
	//covierte el contenido en una estrutura de datos
	$str_datos = file_get_contents("".$confi."");
	$datos_a = json_decode($str_datos,true);

	
	
	//CONEXIÓN A LA BASE DE DADTOS Y PASA EL NOMBRE DE LA BASE DE DATOS
	$conexion = mysqli_connect("".$datos_a['configuracion']['database_host']."", "".$datos_a['configuracion']['database_user']."", "".$datos_a['configuracion']['database_pass']."", "".$datos_a['configuracion']['database_name']."")
	or die ("Fallo en el establecimiento de la conexión");
	
	//Parametros para enviar correo
	$nombre_host = $datos_a['configuracion']['email_smtp_host'];
	$from_email = $datos_a['configuracion']['email_from'];
	$from_name = $datos_a['configuracion']['email_from_name'];
	$smtp_port = $datos_a['configuracion']['email_smtp_port'];
	$smtp_user = $datos_a['configuracion']['email_smtp_user'];
	$smtp_pass = $datos_a['configuracion']['email_smtp_pass'];
	$limite = $datos_a['configuracion']['email_batch_limit'];
		
		
	//Toma la fecha actual para validar cuales quices están activos
	$fecha= date("Y-m-d H:i:s"); 
	
	//Trae de la tabla test los campos application_date, term_in_minutes , group_id cuando application_date es menor a la hora actual
	//y status es igual a 1
	$query = "SELECT id, application_date, term_in_minutes , group_id, description FROM test WHERE application_date < '$fecha' and status=1;";
	$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
	$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$fechaAplic = $row["application_date"]; 
	$tiempoRelizac = $row["term_in_minutes"];
	$Id_grupo = $row["group_id"];
	$descripcion = $row["description"];
	$id_test = $row["id"];

	
	//Trae de la tabla registration los datos del campo student_id cuando group_id es igual a group_id de la tabla test
	$query = "SELECT student_id FROM registration WHERE group_id = '$Id_grupo';";
	$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
	//Recorre el $row para pasar los datos al array 
	while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
 		 $id_estudiantes[] = $row["student_id"];
	}


	//Llama al professor_id para verificar el profesor que está asociado a un grupo
	$query = "SELECT professor_id, course_id FROM `group` WHERE id = '$Id_grupo';";
	$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
	$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$id_profesor = $row["professor_id"]; 
	$id_curso = $row["course_id"]; 



	//Llama al professor_id para verificar el profesor que está asociado a un grupo
	$query = "SELECT name FROM course WHERE id = '$id_curso';";
	$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
	$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$nombre_curso = $row["name"]; 
	
	

	//Trae los campos first_name, last_name, email, para optener el nombre y  
	$query = "SELECT first_name, last_name, email FROM professor WHERE id = '$id_profesor';";
	$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
	$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
	$nombre_prof = $row["first_name"] . "  ".$row["last_name"]; 
	$correo_prof = $row["email"]; 




	foreach ($id_estudiantes  as $valor) {

		//Trae los campos first_name, last_name, email, para optener el nombre y  email del estudiante	
		$estudiante = $id_estudiantes[$valor];
		$query = "SELECT id, first_name, last_name, email FROM student WHERE id = '$estudiante';";
		$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 
		$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$nombre_stud = $row["first_name"] . "  ".$row["last_name"]; 
		$correo_stud = $row["email"]; 
		$id_studid = $row["id"];

		//$contSt ++;
		//Evalua si el estudiante existe o no.
		$query = "SELECT * FROM notification_sent where student_id = '$id_studid';";
		$result = mysqli_query($conexion, $query) or die(mysqli_error($conexion)); 

		if($reg= mysql_fetch_array($result)){
	            echo "El registro existe";
	            if((empty($from_email))&&(empty($from_name))) { //Si estan vacios manda a llamar el correo y nombre del profesor

					//Enviar los parametros a la funcion envEmail y guarda en la base de datos
					$envEmail = new EnviarEmail($correo_stud, $nombre_stud, $nombre_host, $correo_prof, $nombre_prof, $smtp_port, $smtp_user, $smtp_pass, $tiempoRelizac, $descripcion, $nombre_curso, $fechaAplic);
					$query = "INSERT INTO notification_sent (student_id, test_id) VALUES ('$id_studid', '$id_test');";
					$envEmail->eviar();
					
					
				}else{//Si no estan vacios manda utiliza los campos encontrados en archivo Configuracion.json

					//Enviar los parametros a la funcion envEmail y guarda en la base de datos
					$envEmail = new EnviarEmail($correo_stud, $nombre_stud, $nombre_host, $from_email, $from_name, $smtp_port, $smtp_user, $smtp_pass, $tiempoRelizac, $descripcion, $nombre_curso, $fechaAplic);
					$query = "INSERT INTO notification_sent (student_id, test_id) VALUES ('$id_studid', '$id_test');";
					$envEmail->eviar();
				}
	            $cont =+ 1;
	        }else{

	            echo "El registro no existe";
			}    
	    
		}
	
?>