<?php require_once('../Connections/config.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO direccion_facturacion (nombre, apellido, telefono, correo, codigo_postal, direccion, usuario_correo, usuario_rol_id_rol, municipio_id_municipio, municipio_departamento_id_departamento) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['codigo_postal'], "int"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['usuario_correo'], "text"),
                       GetSQLValueString($_POST['usuario_rol_id_rol'], "int"),
                       GetSQLValueString($_POST['municipio_id_municipio'], "int"),
                       GetSQLValueString($_POST['municipio_departamento_id_departamento'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "direccionfac.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_config, $config);
$query_usuario = "SELECT usuario.correo FROM usuario";
$usuario = mysql_query($query_usuario, $config) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_config, $config);
$query_municipio = "SELECT municipio.id_municipio, municipio.municipio FROM municipio";
$municipio = mysql_query($query_municipio, $config) or die(mysql_error());
$row_municipio = mysql_fetch_assoc($municipio);
$totalRows_municipio = mysql_num_rows($municipio);

mysql_select_db($database_config, $config);
$query_depto = "SELECT * FROM departamento";
$depto = mysql_query($query_depto, $config) or die(mysql_error());
$row_depto = mysql_fetch_assoc($depto);
$totalRows_depto = mysql_num_rows($depto);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administración</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Administracion</a>
            </div>
            <!-- /.navbar-header -->
			<?php include("../includes/header.php");?>
            
            <?php include("../includes/admin_menu.php");?>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <div class="row">
                    <div class="col-lg-12">
                      <h1 class="page-header">Añadir Dirección de Facturación</h1>
                    <p>&nbsp;</p>
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                       <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                     
                        <tr valign="baseline">
                          <td nowrap align="right">Nombre:</td>
                          <td><p><span id="sprytextfield1">
                          <label for="nombre"></label>
                          <input type="text" name="nombre" id="nombre" maxlength="45" pattern="[A-Za-z ]{1,45}">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Apellido:</td>
                          <td><p><span id="sprytextfield2">
                          <label for="apellido"></label>
                          <input type="text" name="apellido" id="apellido" maxlength="45" pattern="[A-Za-z ]{1,45}">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Telefono:</td>
                          <td><p><span id="sprytextfield3">
                          <label for="telefono"></label>
                          <input type="text" name="telefono" id="telefono" maxlength="8">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Correo:</td>
                          <td><p><span id="sprytextfield4">
                          <label for="correo"></label>
                          <input type="email" name="correo" id="correo" maxlength="45">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Codigo Postal:</td>
                          <td><p><span id="sprytextfield5">
                          <label for="codigo_postal"></label>
                          <input type="text" name="codigo_postal" id="codigo_postal" maxlength="8">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Direccion:</td>
                          <td><p><span id="sprytextfield6">
                          <label for="direccion"></label>
                          <input type="text" name="direccion2" id="direccion" maxlength="100" >
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span> </p></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Usuario:</td>
                          <td><select name="usuario_correo">
                            <?php 
do {  
?>
                            <option value="<?php echo $row_usuario['correo']?>" ><?php echo $row_usuario['correo']?></option>
                            <?php
} while ($row_usuario = mysql_fetch_assoc($usuario));
?>
                          </select></td>
                        <tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Rol:</td>
                          <td><select name="usuario_rol_id_rol">
                            <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Usuario</option>
                          </select></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Municipio:</td>
                          <td><select name="municipio_id_municipio">
                            <?php 
do {  
?>
                            <option value="<?php echo $row_municipio['id_municipio']?>" ><?php echo $row_municipio['municipio']?></option>
                            <?php
} while ($row_municipio = mysql_fetch_assoc($municipio));
?>
                          </select></td>
                        <tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Departamento:</td>
                          <td><select name="municipio_departamento_id_departamento">
                            <?php 
do {  
?>
                            <option value="<?php echo $row_depto['id_departamento']?>" ><?php echo $row_depto['departamento']?></option>
                            <?php
} while ($row_depto = mysql_fetch_assoc($depto));
?>
                          </select></td>
                        <tr>
                        <tr valign="baseline">
                          <td nowrap align="right">&nbsp;</td>
                          <td><input type="submit" value="Insertar registro"></td>
                        </tr>
                      </table>
                      
                      <a href="direccionfac.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Atrás"> <i class="glyphicon glyphicon-arrow-left"></i> Atrás</a>             

                      <input type="hidden" name="MM_insert" value="form1">
                    </form>
                    <p>&nbsp;</p>
<p>&nbsp;</p>
                  </div>
                  <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:0, maxChars:45});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:0, maxChars:45});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {minChars:0, maxChars:45});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "zip_code", {format:"zip_custom"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {minChars:0, maxChars:100});
    </script>


</body>

</html>
<?php
mysql_free_result($usuario);

mysql_free_result($municipio);

mysql_free_result($depto);
?>
