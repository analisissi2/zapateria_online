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
  $updateSQL = sprintf("UPDATE orden SET fecha=%s, total=%s, usuario_correo=%s, usuario_rol_id_rol=%s, costo_envio_id_costo=%s WHERE id_orden=%s",
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['total'], "text"),
                       GetSQLValueString($_POST['usuario_correo'], "text"),
                       GetSQLValueString($_POST['usuario_rol_id_rol'], "int"),
                       GetSQLValueString($_POST['costo_envio_id_costo'], "int"),
                       GetSQLValueString($_POST['id_orden'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "orden.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varOrden_ordenes = "0";
if (isset($_GET['recordID'])) {
  $varOrden_ordenes = $_GET['recordID'];
}
mysql_select_db($database_config, $config);
$query_ordenes = sprintf("SELECT * FROM orden WHERE orden.id_orden=%s", GetSQLValueString($varOrden_ordenes, "int"));
$ordenes = mysql_query($query_ordenes, $config) or die(mysql_error());
$row_ordenes = mysql_fetch_assoc($ordenes);
$totalRows_ordenes = mysql_num_rows($ordenes);

mysql_select_db($database_config, $config);
$query_usuario = "SELECT usuario.correo FROM usuario";
$usuario = mysql_query($query_usuario, $config) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);

mysql_select_db($database_config, $config);
$query_costo = "SELECT costo_envio.id_costo, costo_envio.costo FROM costo_envio";
$costo = mysql_query($query_costo, $config) or die(mysql_error());
$row_costo = mysql_fetch_assoc($costo);
$totalRows_costo = mysql_num_rows($costo);
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
                      <h1 class="page-header">Editar Ordenes</h1>
                      <p>&nbsp;</p>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                       <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                          <tr valign="baseline">
                            <td nowrap align="right">Id:</td>
                            <td><?php echo $row_ordenes['id_orden']; ?></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Fecha:</td>
                            <td>
                            <p><span id="sprytextfield2">
                            <label for="Fecha"></label>
                            <input type="text" name="fecha" id="Fecha" value="<?php echo htmlentities($row_ordenes['fecha'], ENT_COMPAT, 'utf-8'); ?>">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> </p></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Total:</td>
                            <td><p><span id="sprytextfield1">
                            <label for="Total"></label>
                            <input type="text" name="total" id="Total" value="<?php echo htmlentities($row_ordenes['total'], ENT_COMPAT, 'utf-8'); ?>">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span> </p></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Usuario:</td>
                            <td><select name="usuario_correo">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_usuario['correo']?>" <?php if (!(strcmp($row_usuario['correo'], htmlentities($row_ordenes['usuario_correo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_usuario['correo']?></option>
                              <?php
} while ($row_usuario = mysql_fetch_assoc($usuario));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Rol:</td>
                            <td><select name="usuario_rol_id_rol">
                              <option value="1" <?php if (!(strcmp(1, htmlentities($row_ordenes['usuario_rol_id_rol'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Usuario</option>
                            </select></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Costo envio:</td>
                            <td><select name="costo_envio_id_costo">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_costo['id_costo']?>" <?php if (!(strcmp($row_costo['id_costo'], htmlentities($row_ordenes['costo_envio_id_costo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_costo['costo']?></option>
                              <?php
} while ($row_costo = mysql_fetch_assoc($costo));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" value="Actualizar registro"></td>
                          </tr>
                        </table>
                        <h1 class="page-header"> <a href="orden.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Atrás"> <i class="glyphicon glyphicon-arrow-left"></i> Atrás</a>                    </h1>
                        </div>
                        </div>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id_orden" value="<?php echo $row_ordenes['id_orden']; ?>">
                      </form>
                   
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency", {hint:"100.00", minValue:0, maxValue:1e+31});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd"});
    </script>


</body>

</html>
<?php
mysql_free_result($ordenes);

mysql_free_result($usuario);

mysql_free_result($costo);
?>
