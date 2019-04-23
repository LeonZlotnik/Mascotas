<?php 
require_once("conexion.php");

//Leyendo el formulario de "Conéctate al sitio"
if(isset($_POST["conectar"]))
{
	$sql = "SELECT idusuario, nombre, tipo
			FROM usuarios
			WHERE usuario = '$_POST[usuarioc]'AND password = '$_POST[passwordc]'";
	$res = mysqli_query($conexion,$sql) or die(mysqli_error().", $sql");
	if($nfilas = mysqli_num_rows($res))
	{
		$fila = mysqli_fetch_array($res);
		$_SESSION['idusuario'] = $fila['idusuario'];
		$_SESSION['nombre'] = $fila['nombre'];
		$_SESSION['tipo'] = $fila['tipo'];
		if($_SESSION['tipo'] != "U")
		{
			header("Location: admin/index.php");
		}
	else
	{
		header("Location: index.php");
	}
	}
else
	{
	header("Location: usuarios.php?r=1");
	}
}


//Leyendo formulario "Regístrate en el sitio"

if(isset($_POST["registrar"]))
{
	$error = false;
	$sql = "SELECT idusuario FROM usuarios 
			WHERE usuario = '$_POST[usuario]'";
	$res = mysqli_query($conexion,$sql) or die (mysqli_error().",$sql");
	if(mysqli_num_rows($res))
	   {
		$mensaje[] = "El nombre del usuario '$_POST[usuario]' ya está registrado; eliga otro porfavor!!!<br/>";
		$error = true;
	}
	
	$sql = "SELECT idusuario FROM usuarios
			WHERE email = '$_POST[email]'";
	$res = mysqli_query($conexion,$sql) or die (mysqli_error().",$sql");
	if(mysqli_num_rows($res))
	   {
		$mensaje[] = "El email '$_POST[email]' ya está registrado; eliga otro porfavor!!!<br/>";
		$error = true;
	}
	if(trim($_POST['password'])!= trim($_POST['password2'])) #trim en para que no haya espacios
	{
		$mensaje[] = "Las contraseñas son diferentes. verifica!!! <br/>";
		
		$error = true;
	}
	if(!$error){

		$mensaje = NULL;
		$sql = "INSERT INTO usuarios (usuario, nombre, email, password,tipo) VALUES ('$_POST[usuario]',
		'$_POST[nombre]','$_POST[email]','$_POST[password]','U')";
		$res2 = mysqli_query($conexion,$sql) or die(mysqli_error().",$sql");
	}   #Las '' (comillas simples) se ponen en lo relacionado a $_POST[] para que entre en formato SQL
}

//Leyendo formulario de "Recuperar contraseña"
if(isset($_POST["recuperar"]))
{
	$sql = "SELECT password FROM usuarios
			WHERE usuario = '$_POST[usuarior]' AND email = '$_POST[emailr]'";
	$res = mysqli_query($conexion,$sql) or die(mysqli_error().",$sql");
	if(!mysqli_num_rows($res))
	{
		header("Location: usuarios.php?c=1"); #la comando header es para redireccionar la pagina
	}
	else
	{
		$passw = mysqli_fetch_array($res); #este comando a SQL es para hacer un arreglo(lista) con 'X' variable
		$destino = $_POST["emailr"];
		$asunto = "Recuperación de pasword";
		$mensaje = "Haz solicitado la recuperación de tu contraseña.\n
					Tu password es $passw[password]\n\r
					Gracias po tu confianza en MMascotas!!!";
					$encabezados = "From : Mmascotas <info@mmascotas.com>";
					$envio = mail($destino, $asunto, $mensaje, $encabezados); #el metodo 'mail' es para enviar correos electronicos y en el () determinas que vas a mandar.
	if($envio){
		$mensajer[] = "Tu password se ha enviado a la dirección de correo $_POST[emailr]";
	}
	else{
		$mensajer[] = "Error en el envio. Vuelva a intenterlo.";
		}
	}
}

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">    
    <title>MMascotas</title>
    <meta name="description" content="MMascotas, encuentra tu mascota favorita">
    <meta name="keywords" content="mascotas, animales, venta">
    <link href="css/estilos.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="imagenes/favicon.ico" />
	<script type="text/javascript">
		function MM_jumpMenu(targ,selObj,restore)
    	{
        	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        	if (restore) selObj.selectedIndex=0;
      	}
    </script>    
</head>

<body>
<div id="agrupar"> <!-- inicia agrupar -->
	<header id="encabezado"> <!-- inicia encabezado -->
		<div id="banner"> <!-- inicia banner -->
        	<hgroup>
            	<h1>MMascotas</h1>
        		<h2>Mascotas cari&ntilde;osas</h2>
      		</hgroup>
    	</div> <!-- termina banner -->
        <div id="form"> <!-- inicia form -->
            <form name="form_busqueda" id="form_busqueda" action="mascotas.php" method="post">
                <input type="text" size="30" placeholder="Buscador de mascotas" name="texto" id="texto">
                <input type="submit" value="Buscar"name="button" id="button" >
            </form>
            <br />
            <form name="form_especie" id="form_especie">
                <select name="especie" id="especie" onChange="MM_jumpMenu('parent',this,0)">
                    <option value="">Elige una especie...</option>
<?php 
$sql = "SELECT idespecie, especie FROM especies ORDER BY especie"; 
$res = mysqli_query($conexion, $sql) or die(mysqli_error($conexion).", $sql");
while ($especies = mysqli_fetch_array($res))
{
	echo "<option value='mascotas.php?e=$especies[idespecie]'>$especies[especie]</option>";
}
?>
				</select>
            </form>
        </div> <!-- termina form -->
    	<div class="clear"></div>
	</header> <!-- termina encabezado -->
	<nav id="menu_principal"> <!-- inicia menu_principal -->
    	<ul class="menu">
      		<li><a href="index.php" title="volver al inicio">inicio</a></li>
			<li><a href="mascotas.php" title="ver todas las mascotas">mascotas</a></li>
			<li><a href="contacto.php" title="formulario de contacto">contacto</a></li>
<?php 
if(!isset($_SESSION["idusuario"]))
{ 
	echo "<li><a href='usuarios.php' title='conectar/crear usuarios'>usuarios</a></li>"; 
}
else
{ 
	echo "<li><a href='?s=1' title='desconectar la sesi&oacute;n'>desconectarse</a></li>"; 
}
?>
    	</ul>
    	<div class="clear"></div>
	</nav> <!-- finaliza menu_principal -->
  	<div id="centro"> <!-- inicia centro -->
  		<aside id="lateral"> <!-- inicia lateral -->
			<div id="lateral_arriba"> <!-- inicia lateral_arriba -->
<?php
if(isset($_SESSION["nombre"]))
{
?>
                <header>
                        <hgroup>        
                            <h3>Tu nombre es:</h3>
                            <h2><?php echo $_SESSION["nombre"]; ?></h2>
                        </hgroup>
                </header>
<?php 
}
?>      
	   			<p>Conoce a:</p>
<?php
$sql = "SELECT idmascota FROM mascotas ";
$res = mysqli_query($conexion, $sql) or die(mysqli_error($conexion).", $sql");
$rand = rand(0, mysqli_num_rows($res)-1);

$sql = "SELECT idmascota, nombre, especie, sexo, nacimiento, precio, foto FROM mascotas AS M, especies AS E WHERE M.idespecie=E.idespecie LIMIT $rand, 1";
$res = mysqli_query($conexion, $sql) or die(mysqli_error($conexion).", $sql");	
$mascota = mysqli_fetch_array($res);	
?>      
				<p><?php echo $mascota["nombre"]; ?><br />
                	<?php echo $mascota["especie"]; ?><br />
                	<?php echo $mascota["sexo"]; ?><br />
					<?php if($mascota["nacimiento"]!=NULL){ echo fechaDMA($mascota["nacimiento"]); } ?><br />
					$<?php echo number_format($mascota["precio"], 2, ".", ","); ?>
				</p>
				<figure>
                	<img src="fotos/<?php echo $mascota["foto"]; ?>" width="120" height="120" />
					<figcaption>Foto de: <?php echo $mascota["nombre"]; ?></figcaption>
				</figure>
				<footer><a href="mascotas.php?id=<?php echo $mascota["idmascota"]; ?>" title="ver detalles de '<?php echo $mascota["nombre"]; ?>' ">ver detalles</a></footer>  
			</div> <!-- finaliza lateral_arriba -->
			<div id="lateral_abajo"> <!-- inicia lateral_abajo -->
				<header>
					<h2>Compartir en redes:</h2>
				</header>
				<img src="imagenes/compartir.jpg" width="63" height="276" alt="redes sociales" />
			</div> <!-- finaliza lateral_abajo -->
		</aside> <!-- finaliza lateral -->
		<section id="principal"> <!-- inicia principal -->
			<article>
				<header>
					<h1>Usuarios de MMascotas!!!</h1>
				</header>
				<div align="center">
	    			<h2>Con&eacute;ctate al sitio</h2>
	    		<?php
					if(isset($_GET["r"]))
					{
						echo "<p class='alerta'>Usuario y/o contraseña incorrectos. Intentalo de nuevo.</p>";
					}	
				?>
	    			<form id="form2" name="form2" method="post" action="usuarios.php" class="formulario">
						<label for="usuarioc">Usuario:<br></label>
						<input name="usuarioc" type="text" id="usuarioc" size="20" maxlength="20" required><br>
						<label for="passwordc">Contrase&ntilde;a:<br></label>
						<input name="passwordc" type="password" id="passwordc" size="15" maxlength="15" required><br>
						<br><input type="submit" name="conectar" id="button" value="Conectarse">
					</form>
					<p>&nbsp;</p>
					<h2>Reg&iacute;strate en el sitio</h2>
				<?php
					if(isset($res2)){
						
					echo "<p class='alerta'>El usuario fue dado de alta correctamente:<br/><br/>";
					echo "Usuario: $_POST[usuario]<br/>"; #aquí ya $_POST no lleva '' por no estar en formato SQL
					echo "Nombre: $_POST[nombre]<br/>";
					echo "Email: $_POST[email]<br/>";
					echo "Password: $_POST[password]</p>";
						
					}
					
					elseif(isset($_POST["registrar"]))
					{
						echo "<p class='alerta'>No se creo el nuevo usuario</p>";
					}
					if(isset($error)) #el comando if(isset()) detemina "si existe" una variable
					{
						foreach($mensaje as $texto)
						{
							echo "<p class='alerta'>$texto</p>";
						}
					}
				?>
					<form id="form1" name="form1" method="post" action="usuarios.php" class="formulario">
          				<label for="nombre">Nombre completo:<br></label>
                      <input name="nombre" type="text" id="nombre" size="30" maxlength="50" required><br>
                      <label for="usuario">Usuario:<br></label>
                      <input name="usuario" type="text" id="usuario" size="20" maxlength="20" required><br>
                      <label for="password">Contrase&ntilde;a:<br></label>
                      <input name="password" type="password" id="password" size="15" maxlength="15" required><br>
                      <label for="password2">Repetir contrase&ntilde;a:<br></label>
                      <input name="password2" type="password" id="password2" size="15" maxlength="15" required><br>
                      <label for="email">Correo electr&oacute;nico:<br></label>
                      <input name="email" type="email" id="email" size="30" maxlength="50" required><br>
                      <br><input type="submit" name="registrar" id="registrar" value="Registrarse">
					</form>
                    <p>&nbsp;</p>
                    <h2>Recupera tu contrase&ntilde;a del sitio</h2>
                    <h3>Ser&aacute; enviada a tu correo electr&oacute;nico</h3>
                <?php
					if(isset($_GET[c]))
					{
						echo "<p class='alerta'>El usuario y/o correo electrónico no están registrados. Vuelva a intentarlo.</p>";
					}
					elseif(isset($mensajer))
					{
						echo "<p class='alerta'>$mensajer[0]</p>";
					}
				?>
					<form id="form3" name="form3" method="post" action="usuarios.php" class="formulario">
						<label for="usuarior">Usuario:<br></label>
						<input name="usuarior" type="text" id="usuarior" size="20" maxlength="20" required><br>
						<label for="emailr">Correo electr&oacute;nico:<br></label>
						<input name="emailr" type="email" id="emailr" size="30" maxlength="50" required><br>
						<br><input type="submit" name="recuperar" id="recuperar" value="Recuperar">
					</form>            
	  			</div>
			</article>
		</section> <!-- finaliza principal -->
		<div class="clear"></div>
	</div> <!-- finaliza centro -->
	<footer id="pie"> <!-- inicia pie -->
		<nav class="vinculos"> 
			<h3>V&iacute;nculos</h3>
			<ul>
				<li><a href="index.php" title="volver al inicio">inicio</a></li>
				<li><a href="mascotas.php" title="ver todas las mascotas">mascotas</a></li>
				<li><a href="contacto.php" title="formulario de contacto">contacto</a></li>
<?php 
if(!isset($_SESSION["idusuario"]))
{ 
	echo "<li><a href='usuarios.php' title='conectar/crear usuarios'>usuarios</a></li>"; 
}
else
{ 
	echo "<li><a href='?s=1' title='desconectar la sesi&oacute;n'>desconectarse</a></li>"; 
} 
?>
			</ul>
		</nav>
		<nav class="vinculos"> 
			<h3>Recomendaciones</h3>
			<ul>
                <li><a href="#">No m&aacute;s mascotas abandonadas</a></li>
                <li><a href="#">Maltrato a los animales</a></li>
                <li><a href="#">Est&eacute;tica Wooow!, lo mejor para tu mascota</a></li>
	      </ul>
		</nav>
		<nav class="vinculos"> 
      		<h3>Mascotas</h3>
      		<ul>
                <li><a href="#">Mascotas para todos</a></li>
                <li><a href="#">Elige tu mascota</a></li>
                <li><a href="#">Los ni&ntilde;os y las mascotas</a></li>
	      </ul>
		</nav>
		<nav class="vinculos"> 
			<h3>Compartir</h3>
			<p><a href="#" target="_blank"><img src="imagenes/iconos/facebook.png" border="0" /></a></p>
			<p><a href="#" target="_blank"><img src="imagenes/iconos/twitter.png" border="0" /></a></p>
			<p><a href="#" target="_blank"><img src="imagenes/iconos/youtube.png" border="0" /></a></p>
		</nav>
		<p class="derechos">Mmascotas | &copy; Derechos reservados | M&eacute;xico 2014</p>  
	</footer> <!-- finaliza pie -->
</div><!-- finaliza agrupar -->
</body>
</html>