<?php 
require_once("conexion.php");

if(isset($_POST["button"]))
{
	$dia = date("d-m-Y");
	$hora = date("g:i");
	
	$destino1 = $_POST["email"];
	$destino2 = "contacto@mmascotas.com";
	
	$encabezado1 = "MIME-Version: 1.0\r\n"; 
	$encabezado1 .= "Content-type: text/html; charset=utf-8\r\n"; 	
	$encabezado1 .= "From: Mmascotas <$destino2>";
	
	$encabezado2 = "MIME-Version: 1.0\r\n"; 
	$encabezado2 .= "Content-type: text/html; charset=utf-8\r\n"; 	
	$encabezado2 .= "From: $_POST[nombre] <$destino1>";
	
	$asunto = "Contacto Mmascotas";
	$contenido = "
	<html> 
	<head> 
	<title>Contacto Mmascotas</title>
	</head> 
	<body>
	<h1>Contacto MMascotas</h1>
	<img src='http://cursowpacp.000webhostapp.com/imagenes/mascotas_block.jpg' alt='Mmascotas logo' /> 
	<p>Hemos recibido un comentario enviado el $dia a las $hora horas</p>
	<p>Nombre: $_POST[nombre]<br />
		   E-mail: $_POST[email]<br />
		   Comentarios: $_POST[comentario]<br />
		   Se entero de nosotros en: $_POST[enterado]<br />
		   Su especie preferida es: $_POST[especie]</p>
	<h3>MMASCOTAS! agradece su confianza y preferencia.</h3>
	<p><a href='http://cursowpacp.000webhostapp.com' target='_blank'>Visita nuestra página</a></p>
	</body> 
	</html>";
	
	if(mail($destino1, $asunto, $contenido, $encabezado1))
	{
		$mensaje[] = "Se envió un correo electrónico a la siguiente dirección <br>$destino1";
	}
	else
	{
		$mensaje[] = "Error en el envió del correo electrónico a la siguiente dirección<br> $destino1";
	}
	if (mail($destino2, $asunto, $contenido, $encabezado2))
	{
		$mensaje[] = "Se envió un correo electrónico a la siguiente dirección<br> $destino2";
	}
	else
	{
		$mensaje[] = "Error en el envío del correo electrónico a la siguiente dirección<br> $destino2";
	}
}
?>
<!DOCTYPE HTML>
<html>
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
<?php 
echo "<img src='fotos/$mascota[foto]' width='120' height='120' /><figcaption>Foto de: $mascota[nombre]</figcaption>";
?>
				</figure>
				<footer>
<?php
echo "<a href='mascotas.php?id=$mascota[idmascota]'>ver detalles</a>";
?>
				</footer>  
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
					<h1>Bienvenidos a MMascotas!!!</h1>
				</header>
			</article>                
   	  		<div align="center">
<?php
if(isset($_POST["button"]))
{
	foreach ($mensaje as $texto)
	{
		echo"<p class='alerta'>$texto</p>";
	}
}	
?>
        		<h2>Tus comentarios nos ayudar&aacute;n a mejorar nuestro servicio</h2>
        		<form id="form1" name="form1" method="post" action="contacto.php" class="formulario">
					<label for="nombre"> Tu nombre y apellido:</label><br>
					<input  name="nombre" type="text" id="nombre" size="40" required><br>
					<br><label for="email">Tu E-mail:</label><br>
					<input name="email" type="email" id="email" size="40"><br>
					<br><label for="especie">Tu especie de mascota preferida:</label><br>
					<select name="especie" id="especie">
<?php 
$sql = "SELECT especie FROM especies ORDER BY especie";
$res = mysqli_query($conexion, $sql) or die(mysqli_error($conexion).", $sql");
while ($especies = mysqli_fetch_array($res))
{
	echo "<option>$especies[especie]</option>";
}
?>
					</select><br>
					<br><label for="enterado">Te enteraste de nosotros en:</label><br>
					<label>
					<input type="radio" name="enterado" value="Prensa" id="enterado_0">Prensa
         			 </label><br>
          			<label>
					<input type="radio" name="enterado" value="Radio" id="enterado_1">Radio
          			</label><br>
          			<label>
					<input type="radio" name="enterado" value="Television" id="enterado_2">Televisi&oacute;n
          			</label><br>
          			<label>
					<input type="radio" name="enterado" value="Recomendacion" id="enterado_3">Recomendaci&oacute;n
          			</label><br> 
          			<br><label for="comentario">Tus comentarios:</label><br>
          			<textarea name="comentario" id="comentario" cols="35" rows="5" required></textarea><br>
          			<br><input type="submit" name="button" id="button" value="Enviar formulario">&nbsp;<input type="reset" name="button2" id="button2" value="Limpiar formulario">
        		</form>
			</div>
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