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
  $updateSQL = sprintf("UPDATE paypal SET correo=%s, monto=%s, forma_pago_id_tipo_pago=%s WHERE id=%s",
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['monto'], "double"),
                       GetSQLValueString($_POST['forma_pago_id_tipo_pago'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "paypal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varpaypal_editpaypal = "0";
if (isset($_GET['recordID'])) {
  $varpaypal_editpaypal = $_GET['recordID'];
}
mysql_select_db($database_config, $config);
$query_editpaypal = sprintf("SELECT * FROM paypal WHERE paypal.id=%s", GetSQLValueString($varpaypal_editpaypal, "int"));
$editpaypal = mysql_query($query_editpaypal, $config) or die(mysql_error());
$row_editpaypal = mysql_fetch_assoc($editpaypal);
$totalRows_editpaypal = mysql_num_rows($editpaypal);
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
                      <h1 class="page-header">Editar Registro</h1>
                      <p>&nbsp;</p>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                     
                          <tr valign="baseline">
                            <td nowrap align="right">Id:</td>
                            <td><?php echo $row_editpaypal['id']; ?></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Correo:</td>
                            <td><p><span id="sprytextfield1">
                            <label for="correo"></label>
                            <input type="email" name="correo" id="correo" value="<?php echo htmlentities($row_editpaypal['correo'], ENT_COMPAT, 'utf-8'); ?>">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span> </p></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Monto:</td>
                            <td><p><span id="sprytextfield2">
                            <label for="monto"></label>
                              <input type="text" name="monto" id="monto" value="<?php echo htmlentities($row_editpaypal['monto'], ENT_COMPAT, 'utf-8'); ?>">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> </p></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Forma pago:</td>
                            <td><select name="forma_pago_id_tipo_pago">
                              <option value="2" <?php if (!(strcmp(2, htmlentities($row_editpaypal['forma_pago_id_tipo_pago'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Paypal</option>
                            </select></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" value="Actualizar registro"></td>
                          </tr>
                        </table>
                        <a href="paypal.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Atrás"> <i class="glyphicon glyphicon-arrow-left"></i> Atrás</a>             

                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id" value="<?php echo $row_editpaypal['id']; ?>">
                      </form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
    </script>


</body>

</html>
<?php
mysql_free_result($editpaypal);
?>
