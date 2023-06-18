<html lang="es">

  <head>
    <link rel="stylesheet" href="style.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crear Cuenta</title>
  </head>
  <body>

	<div class="cont">

			<h1>Create Account</h1>
			<br>
				<form id="form" method="post" action="">
					<div>
						<p>Nombre</p>
						<input type="text" id="nombre" name="nombre" class="form-input" required>
					</div>
					<br>

					<div>
						<p>Primer apellido</p>
						<input type="text" id="apellido1" name="apellido1" class="form-input" required>
					</div>
					<br>

					<div>
						<p>Segundo apellido</p>
						<input type="text" id="apellido2" name="apellido2" class="form-input">
					</div>
					<br>

					<div>
						<p>Email</p>
						<input type="email" id="email" name="email" class="form-input" required>
					</div>
					<br>

					<div>
						<p>Login</p>
						<input type="text" id="login" name="login" class="form-input" required>
					</div>
					<br>

					<div>
						<p>Password</p>
						<input type="password" id="clave" minlength="4" maxlenght="8" name="clave" class="form-input" required>
					</div>
					<br>


					<input type="submit" id="check" name="check" value="ENVIAR" class="form-btn">

				</form>

				<?php

				if($_POST){
					if (isset($_POST['check'])) {
						$nombre = $_POST['nombre'];
						$apellido1 = $_POST['apellido1'];
						$apellido2 = $_POST['apellido2'];
						$email = $_POST['email'];
						$login = $_POST['login'];
						$clave = $_POST['clave'];

						$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "bbddlaboratorio";

						$conn = new mysqli($servername, $username, $password, $dbname);

						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						if (!empty($nombre) || !empty($apellido1) || !empty($apellido2) || !empty($email) || !empty($login) || !empty($clave)) {
							$consulta = "SELECT * FROM USUARIO WHERE EMAIL = '$email'";
							$resultado = $conn->query($consulta);

							if ($resultado->num_rows > 0) {
								echo "Este correo electrónico ya está registrado.";
							} else if (strlen($clave) < 4 || strlen($clave) > 8) {
								echo "La longitud de la contraseña debe ser entre 4 y 8 carácteres.";
							} else {
								$sql = "INSERT INTO USUARIO (NOMBRE, APELLIDO1, APELLIDO2, EMAIL, LOGIN, PASSWORD)
								VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$clave')";

								if ($conn->query($sql) === TRUE) {
									echo "Registro completado con éxito.";
									echo "<br>";
									echo '<form method="POST" action=""> <input type="submit" id="boton" name="boton" value="CONSULTA" onclick="mostrarTabla()"></form>';
								} else {
									echo "Error al registrar.";
								}
							}
						} else {
							echo "Todos los campos deben rellenarse.";
						}


						$conn->close();
					} else if (isset($_POST['boton'])) {
						$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "bbddlaboratorio";

						$conn = new mysqli($servername, $username, $password, $dbname);

						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						$sqlconsulta = "SELECT * FROM USUARIO";
						$resultadoconsulta = $conn->query($sqlconsulta);

						if ($resultadoconsulta->num_rows > 0) {
							echo "<table>";
							echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>EMAIL</th></tr>";
							while ($fila = $resultadoconsulta->fetch_assoc()){
								echo "<tr><td>" . $fila["NOMBRE"] . "</td>";
								echo "<td>" . $fila["APELLIDO1"] . " " . $fila["APELLIDO2"] . "</td>";
								echo "<td>" . $fila["EMAIL"] . "</td>";
								echo "</tr>";
							}
							echo "</table>";
						}
						$conn->close();
					}
				}

				?>

				<div id="tabla-container" style="display: none;">

				</div>

				<script>
					function mostrarTabla(){
						document.getElementById("tabla-container").style.display = "block";
					}
				</script>

	</div>
  </body>
</html>