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
  $updateSQL = sprintf(" CALL `editadmin`(%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['idadmin'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['estado'], "int")
                       );

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "superusuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$id_adminEdit = "0";
if (isset($_GET["id"])) {
  $id_adminEdit = $_GET["id"];
}
mysql_select_db($database_config, $config);
$query_adminEdit = sprintf("SELECT * FROM `admin` WHERE `admin`.idadmin = %s", GetSQLValueString($id_adminEdit, "int"));
$adminEdit = mysql_query($query_adminEdit, $config) or die(mysql_error());
$row_adminEdit = mysql_fetch_assoc($adminEdit);
$totalRows_adminEdit = mysql_num_rows($adminEdit);
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->

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
<SCRIPT languaje="JavaScript">
function pulsar() {
alert("Registro Editado con Exito!!");
}
</SCRIPT>
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
                    <div class="col-lg-12"><!-- InstanceBeginEditable name="Contenido" -->
                      <h1 class="page-header">Editando Usuario:<?php echo $row_adminEdit['nombre']; ?> <?php echo $row_adminEdit['apellido']; ?> </h1>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <table align="center">
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Nombre:</label></td>
                            <td><input class="form-control" type="text" name="nombre" value="<?php echo htmlentities($row_adminEdit['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Apellido:</label></td>
                            <td><input class="form-control" type="text" name="apellido" value="<?php echo htmlentities($row_adminEdit['apellido'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Correo:</label></td>
                            <td><input class="form-control" type="text" name="correo" value="<?php echo htmlentities($row_adminEdit['correo'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Contraseña:</label></td>
                            <td><input class="form-control" type="text" name="contrasena" value="<?php echo htmlentities($row_adminEdit['contrasena'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Telefono:</label></td>
                            <td><input class="form-control" type="text" name="telefono" value="<?php echo htmlentities($row_adminEdit['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Cargo:</label></td>
                            <td><input class="form-control" type="text" name="cargo" value="<?php echo htmlentities($row_adminEdit['cargo'], ENT_COMPAT, 'utf-8'); ?>" size="32" required></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right"><label>Estado:</label></td>
                            <td><select class="form-control" name="estado">
                              <option value="1" <?php if (!(strcmp(1, htmlentities($row_adminEdit['estado'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Activo</option>
                              <option value="0" <?php if (!(strcmp(0, htmlentities($row_adminEdit['estado'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Inactivo</option>
                            </select></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" class="btn btn-primary" value="Actualizar registro"></td>
                          </tr>
                        </table>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="idadmin" value="<?php echo $row_adminEdit['idadmin']; ?>">
                      </form>
                      <p>&nbsp;</p>
                    <!-- InstanceEndEditable --></div>
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
    </script>


</body>

<!-- InstanceEnd --></html>
<?php
mysql_free_result($adminEdit);
?>
