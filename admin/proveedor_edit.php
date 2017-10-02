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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE proveedor SET nombre=%s, apellido=%s, empresa=%s, telefono=%s, correo=%s WHERE id_proveedor=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['empresa'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['id_proveedor'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "proveedor.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varProveedor_editarProveedor = "0";
if (isset($_GET["RecordID"])) {
  $varProveedor_editarProveedor = $_GET["RecordID"];
}
mysql_select_db($database_config, $config);
$query_editarProveedor = sprintf("SELECT * FROM proveedor WHERE proveedor.id_proveedor=%s", GetSQLValueString($varProveedor_editarProveedor, "int"));
$editarProveedor = mysql_query($query_editarProveedor, $config) or die(mysql_error());
$row_editarProveedor = mysql_fetch_assoc($editarProveedor);
$totalRows_editarProveedor = mysql_num_rows($editarProveedor);
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
                      <h1 class="page-header">Editar datos de proveedor</h1>
                    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <tr valign="baseline">
                          <td nowrap align="right">Nombre:</td>
                          <td><span id="sprytextfield1">
                          <label for="nombre"></label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo htmlentities($row_editarProveedor['nombre'], ENT_COMPAT, 'utf-8'); ?>" pattern="[A-Za-z ]{1,45}" maxlength="45">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Apellido:</td>
                          <td><span id="sprytextfield2">
                          <label for="apellido"></label>
                          <input type="text" name="apellido" id="apellido" value="<?php echo htmlentities($row_editarProveedor['apellido'], ENT_COMPAT, 'utf-8'); ?>" pattern="[A-Za-z ]{1,45}" maxlength="45">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Empresa:</td>
                          <td><span id="sprytextfield3">
                          <label for="empresa"></label>
                            <input type="text" name="empresa" id="empresa" value="<?php echo htmlentities($row_editarProveedor['empresa'], ENT_COMPAT, 'utf-8'); ?>" pattern="[A-Za-z ]+{1,45}" maxlength="45"	>
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Teléfono:</td>
                          <td><span id="sprytextfield4">
                          <label for="telefono"></label>
                          <input name="telefono" type="text" id="telefono" value="<?php echo htmlentities($row_editarProveedor['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="8" maxlength="8">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Ingrese un número de teléfono válido.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">Correo:</td>
                          <td><span id="sprytextfield5">
                          <label for="correo"></label>
                            <input type="email" name="correo" id="correo" value="<?php echo htmlentities($row_editarProveedor['correo'], ENT_COMPAT, 'utf-8'); ?>">
                          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap align="right">&nbsp;</td>
                          <td><input type="submit" value="Actualizar registro"></td>
                        </tr>
                      </table>
                      <a href="proveedor.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Atrás"> <i class="glyphicon glyphicon-arrow-left"></i> Atrás</a>
                      </div>
                      
                      </div>
                      <input type="hidden" name="MM_update" value="form1">
                      <input type="hidden" name="id_proveedor" value="<?php echo $row_editarProveedor['id_proveedor']; ?>">
                    </form>
                    
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:1});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {minChars:8, maxChars:8});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
    </script>


</body>

</html>
<?php
mysql_free_result($editarProveedor);
?>
