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
  $updateSQL = sprintf(" CALL `editcoment`(%s,%s,%s)",
    GetSQLValueString($_POST['id_comentario'], "int"),
                       GetSQLValueString($_POST['comentario'], "text"),
                       GetSQLValueString($_POST['estado'], "int")
                       );

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "comentario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$id_comenEdit = "0";
if (isset($_GET["id"])) {
  $id_comenEdit = $_GET["id"];
}
mysql_select_db($database_config, $config);
$query_comenEdit = sprintf("SELECT * FROM comentario WHERE comentario.id_comentario = %s", GetSQLValueString($id_comenEdit, "int"));
$comenEdit = mysql_query($query_comenEdit, $config) or die(mysql_error());
$row_comenEdit = mysql_fetch_assoc($comenEdit);
$totalRows_comenEdit = mysql_num_rows($comenEdit);
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
                      <h1 class="page-header">Editando Comentario hecho por : <?php echo $row_comenEdit['usuario_correo']; ?></h1>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <table align="center">
                          <tr valign="baseline">
                            <td nowrap align="right">Comentario:</td>
                            <td><input name="comentario" type="text" required value="<?php echo htmlentities($row_comenEdit['comentario'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="45"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Estado:</td>
                            <td><select name="estado">
                              <option value="1" <?php if (!(strcmp(1, htmlentities($row_comenEdit['estado'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Activo</option>
                              <option value="0" <?php if (!(strcmp(0, htmlentities($row_comenEdit['estado'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Inactivo</option>
                            </select></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" value="Actualizar registro"></td>
                          </tr>
                        </table>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id_comentario" value="<?php echo $row_comenEdit['id_comentario']; ?>">
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
mysql_free_result($comenEdit);
?>
