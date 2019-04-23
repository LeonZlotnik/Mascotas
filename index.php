<?php
require_once("conexion.php");

if(isset($_POST["button"])){
	
	$sql = "INSERT INTO comentarios (idusuario,comentario) 
	VALUES ('$_SESSION[idusuario]','$_POST[comentario]')";
		$res = mysqli_query($conexion,$sql) OR die(mysqli_eror().",$sql");
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
				$sql = "SELECT idespecie,especie
						FROM especies
						ORDER BY especie";
				$res = mysqli_query($conexion,$sql) or die(mysqli_error($conexion).",$sql");
					while ($especies = mysqli_fetch_array($res))
					{
						echo "<option value='mascotas.php?e=$especies[idespecie]'>
						$especies[especie]</option>";
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
				if(!isset($_SESSION["idusuario"])){
					echo "<li><a href='usuarios.php' title='conectar/crear usuarios'>usuarios</a></li>";
				}
				else{
					echo "<li><a href='?s=1' title='desconectar la sesión'>desconectar</a></li>";
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
                            <h2><?php echo $_SESSION["nombre"];?></h2>
                        </hgroup>
                </header>
                <?php
				}
				?>
	   			<p>Conoce a:</p>  
	   			<?php
				$sql = 'SELECT idmascota FROM mascotas';
				$res = mysqli_query($conexion,$sql) or die(mysqli_error($conexion).",$sql");
				$rand = rand(0,mysqli_num_rows($res)-1);
				
				$sql = "SELECT idmascota, nombre, especie, sexo, nacimiento, precio, foto
						FROM mascotas AS M, especies AS E
						WHERE M.idespecie = E.idespecie LIMIT $rand,1";
				$res = mysqli_query($conexion,$sql) or die(mysqli_error($conexion).",$sql");
				$mascota = mysqli_fetch_array($res);
				?>
				<p><?php echo $mascota["nombre"]; ?><br />
                	<?php echo $mascota["especie"];?><br />
                	<?php echo $mascota["sexo"];?><br />
					<?php if($mascota["nacimiento"]!=NULL){
				echo fechaDMA ($mascota["nacimiento"]);}?><br />
					$<?php echo number_format($mascota["precio"],2,".",",");?> 
				</p>
				<figure>
               	<?php 
				echo "<img src='fotos/$mascota[foto]' width='120' height='120' />
					<figcaption>Foto de: $mascota[nombre]</figcaption>"
				?>
				</figure>
				<footer><a href="mascotas.php?id=" title="ver detalles de '' ">ver detalles</a></footer>  
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
				<figure>
					<img src="imagenes/mascotas_block.jpg" alt="bienvenidos a MMascotas!!!" width="226" height="155" />
				</figure>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras euismod dictum posuere. Ut vehicula, urna et vehicula dapibus, nisl lectus gravida ligula, non commodo massa leo eget dui. Pellentesque gravida ligula vel metus pharetra adipiscing. Sed sit amet augue nec dolor lacinia cursus non sagittis libero. Proin suscipit gravida tellus, id egestas lacus suscipit adipiscing. In risus magna, blandit vitae tristique et, scelerisque quis felis. Etiam in tortor sapien, semper imperdiet leo. Donec venenatis vehicula ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque pulvinar metus a dolor suscipit sagittis pretium urna fringilla. Ut elementum imperdiet congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean ut eros felis, id semper nunc. Sed pretium porttitor sagittis. Nullam ut orci tellus. Morbi lacus velit, pellentesque at semper non, accumsan sed augue. Quisque tellus tortor, interdum elementum ullamcorper ut, vestibulum tristique purus. Nam id velit mauris, acscelerisque libero. Aliquam erat volutpat. Etiam vehicula tempor mauris.</p>
			</article>
			<aside id="comentarios"> <!-- inicia comentarios -->
				<div id="comentarios_izquierda"> <!-- inicia comentarios_izquierda -->
					<h2>Deja un comentario</h2>
					<form name="form1" action="index.php" method="post">
						<p>Autor:<br />
							<input type="text" readonly 
							<?php 
							if(!isset($_SESSION["idususario"])){
								echo "value = '$_SESSION[nombre]'";}
							?>>
						</p>
						<p>Comentario:<br />
							<textarea name="comentario" cols="20" rows="5" id="comentario"></textarea>
						</p>
						<p><input name="button" type="submit" id="button" value="Enviar comentarios" 
						<?php
							if(!isset($_SESSION['idusuario'])){
								echo "disabled = 'disabled'";}
						?>
						</p>
					</form>
				<?php
					if(!isset($_SESSION['idusuario'])){
						echo "<p>Para dejar un comentario <br/> tiene que estar registrado como <a href=usuario.php>usuario</a>.</p>";
					}
				?>
				</div> <!-- finaliza comentarios_izquierda -->
      			<div id="comentarios_derecha"> <!-- inicia comentarios_derecha --> 
      			<?php
					$sql = "SELECT comentario, tiempo, nombre, email
							FROM comentarios AS C, usuarios AS U
							WHERE C.idusuario = U.idusuario
							ORDER BY idcomentario DESC";
					$res = mysqli_query($conexion,$sql) or die(mysqli_error($conexion).",$sql");
					while($comentarios = mysqli_fetch_array($res))
					{
						$temp = explode(" ",$comentarios["tiempo"]);
						echo"<p>
							<img src='imagenes/comentarios.jpg'/>
							<br><strong>$comentarios[nombre]dice:</strong>
							<br>$comentarios[comentario]
							<br><br>escrito el ". fechaDMA($temp[0])."
							$temp[1]
							<br>email: $comentarios[email]
							<br>___________________________________________
							<br>
							<p>";
					}
					?>
				</div> <!-- finaliza comentarios_derecha -->
				<div class="clear"></div>
			</aside> <!-- finaliza comentarios -->
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