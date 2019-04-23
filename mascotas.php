<?php 
require_once("conexion.php");
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
					<h1>Conoce nuestras MMascotas!!!</h1>
				</header>
			</article>
			<div id="mascotas"> <!-- inicia mascotas -->
			<?php
				if(isset($_GET["id"]))
				{
				$sql = "SELECT idmascota, nombre, especie, detalles, sexo, nacimiento, precio, foto
						FROM mascotas AS M, especies AS E
						WHERE M.idespecie = E.idespecie AND idmascota = '$_GET[id]'";
				$res = mysqli_query($conexion,$sql) or die(mysqli_error().",$sql");
				$mascota = mysqli_fetch_array($res);
			?>
			
				<table border="0" cellpadding="2" cellspacing="2" align="center" width="650">	
          			<tr>
            			<td align="center"><?php 
						echo $mascota["idmascota"];?>&nbsp;</td>
                  	</tr>	
                  	<tr>
                    	<td align="center"><?php
						echo $mascota["nombre"]?>&nbsp;</td>
                  	</tr>	
                  	<tr>
                    	<td align="center"><?php
						echo $mascota["especie"]?>&nbsp;</td>
                  	</tr>		
                  	<tr>
                    	<td align="center"><?php
						echo $mascota["sexo"]?>&nbsp;</td>
                  	</tr>	
                  	<tr>
                    	<td align="center"><?php
						if(($mascota["nacimiento"])!= NULL){
							echo fechaDMA($mascota["nacimiento"]);}?>&nbsp;</td>
                  	</tr>	
                  	<tr>
                    	<td align="center"><?php
						echo number_format($mascota["precio"],2,".",",");?>$&nbsp;</td>
                  	</tr><!--Aqhí los numeros y comas despues de ["precio"] son para indicar cuantos decimales quieres, que separa a los decimales de los enteros y que separa a los miles-->
                  	<tr>
                    	<td align="center"><?php echo"<img src='fotos/$mascota[foto]' height='450' width='450'/>"?>&nbsp;</td>
                  	</tr>
                  	<tr>
                    	<td align="center"><?php echo $mascota["detalles"];?>&nbsp;</td>
                  	</tr>	
                  	<tr>
                    	<td align="center"><a href="mascotas.php">volver a ver todas las mascotas</a></td>
                  	</tr>	
				</table>
			<?php
				}
				else
				{
					$where = "";
					$sql = "SELECT idmascota, nombre, E.idespecie, especie, imagen, sexo, nacimiento, precio, foto FROM mascotas AS M, especies AS E
					WHERE M.idespecie = E.idespecie $where ORDER BY idmascota DESC";
					$res = mysqli_query($conexion,$sql) or die(mysqli_errno().",$sql");
					echo "<h2 class='center'>".mysqli_num_rows($res)."Mascotas Encontradas</h2>";
				
			?>
				<br />
        		<table border="0" cellpadding="2" cellspacing="2" width="450" align="center">
        	<?php
				while($mascotas = mysqli_fetch_array($res)){
							
			?>
					<tr>
            			<td width="160" align="center" valign="middle"><?php echo "<img src='fotos/$mascotas[foto]' width='150' height='150'/>";?><a href="?e=">ver + ''</a></td>
            <td align="center">
              <p>tengo el ID: <?php echo "$mascotas[idmascota]";?>
              <br>mi nombre es: <?php echo "$mascotas[nombre]";?>
              <br>soy de la especie: <?php echo "$mascotas[especie]";?>
              <br>mi sexo es: <?php echo "$mascotas[sexo]";?>
              <br>mi cumple es el: <?php 
				if($mascotas[nacimiento]!=NULL)
				{
				 echo fechaDMA($mascotas[nacimiento]);
				}?>
              <br>y mi precio es: $<?php echo number_format($mascotas["precio"],2,".",",");?></p>
              <p>
              <?php 
				echo "<a href='mascotas.php?id=$mascota[idmascota]'>ver detalles</a>"?></p>  
            </td>
          </tr>
          <tr>
            <td colspan="2"><hr /></td>	
          </tr>
          <?php
				}
		  ?>
        </table>
        <?php
				}
		?>
			</div> <!-- finaliza mascotas -->
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