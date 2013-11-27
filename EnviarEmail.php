<?php

	require_once('class.phpmailer.php');
	
	class EnviarEmail {

		public $correo_alumno;
		public $nombre_alumno;
		public $smtp_host;
		public $from_email;
		public $from_name;
		public $smtp_port;
		public $smtp_user;
		public $smtp_pass;
		public $tiemp_realiz;
		public $descrip_test;
		public $nombre_curso;
		public $fecha_aplicacion;

		

	function __construct($emailbAlumn, $nombAlumn, $smtpHost, $fromEmail, $fromName, $smtpPort, $smtpUser, $smtpPass, $tiempRealiz, $descripccionTest, $nombreCurso, $fechaAplicacion) {
	
		$this->correo_alumno = $emailbAlumn;
		$this->nombre_alumno = $nombAlumn;
		$this->$smtp_host = $smtpHost;
		$this->$from_email = $fromEmail;
		$this->$from_name = $fromName;
		$this->$smtp_port = $smtpPort;
		$this->$smtp_user = $smtpUser;
		$this->$smtp_pass = $smtpPass;
		$this->$atch_limit = $atchLimit;
		$this->$tiemp_realiz = $tiempRealiz;
		$this->$descrip_test = $descripccionTest;
		$this->$nombre_curso = $nombreCurso;
		$this->$fecha_aplicacion = $fechaAplicacion;

	}


		function eviar(){

			
			$mail = new PHPMailer();
			//Se le indica a la clase que use SMTP
			$mail->IsSMTP();
			//Debug para ver mensajes de las cosas que van ocurriendo
			$mail->SMTPDebug = 2;
			//Se hace la autenticación SMTP
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "ssl";
			//Se indica el servidor de Gmail para SMTP
			$mail->Host = "$this->$smtp_host";
			//Se indica el puerto que usa Gmail
			$mail->Port = $this->$smtp_port;
			//Se indica el usuario / clave de un usuario de gmail
			$mail->Username = "$this->$smtp_user";
			$mail->Password = "$this->$smtp_pass";
			$mail->SetFrom('$this->$from_email', '$this->$from_name');
			//Cuerpo del mensaje
			$mail->Subject = "Notificacion de Quiz";
			$mail->MsgHTML("Hola $this->nombre_alumno <br><br>
			El quiz $this->descrip_test del curso $this->$nombre_curso ha sido activado a partir de
			$this->$fecha_aplicacion y por un lapso de $this->$tiemp_realiz. <br><br>
			Seguir el siguiente link para ingresar al sistema automatizado de quices de la UTN. <br><br>
			<a href='http://localhost/test/<id/tabla test>'>Link</a> <br><br><br>
			<--	
			name/ tabla teacher>");
			//Se indica el destinatario
			$address = "$this->correo_alumno";
			$mail->AddAddress($address, "$this->nombre_alumno");

			if(!$mail->Send()) {
				echo "Error al enviar: " . $mail->ErrorInfo;
			} else {
				echo "Mensaje enviado!";
			} 	
		}

		
	}
	  

?>