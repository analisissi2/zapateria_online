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
  $updateSQL = sprintf("UPDATE costo_envio SET costo=%s, departamento_id_departamento=%s WHERE id_costo=%s",
                       GetSQLValueString($_POST['costo'], "int"),
                       GetSQLValueString($_POST['departamento_id_departamento'], "int"),
                       GetSQLValueString($_POST['id_costo'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "costoenvio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE costo_envio SET costo=%s, departamento_id_departamento=%s WHERE id_costo=%s",
                       GetSQLValueString($_POST['costo'], "int"),
                       GetSQLValueString($_POST['departamento_id_departamento'], "int"),
                       GetSQLValueString($_POST['id_costo'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "costoenvio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varCosto_select = "0";
if (isset($_GET['recordID'])) {
  $varCosto_select = $_GET['recordID'];
}
mysql_select_db($database_config, $config);
$query_select = sprintf("SELECT * FROM costo_envio where id_costo=%s", GetSQLValueString($varCosto_select, "int"));
$select = mysql_query($query_select, $config) or die(mysql_error());
$row_select = mysql_fetch_assoc($select);
$totalRows_select = mysql_num_rows($select);

mysql_select_db($database_config, $config);
$query_departamento = "SELECT departamento,id_departamento FROM departamento, costo_envio WHERE departamento_id_departamento=id_departamento";
$departamento = mysql_query($query_departamento, $config) or die(mysql_error());
$row_departamento = mysql_fetch_assoc($departamento);
$totalRows_departamento = mysql_num_rows($departamento);
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
                      <h1 class="page-header">Editar costo envio</h1>
                      <p>&nbsp;</p>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                       <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                          <tr valign="baseline">
                            <td nowrap align="right">Id costo:</td>
                            <td><?php echo $row_select['id_costo']; ?></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Costo:</td>
                            <td><p><span id="sprytextfield1">
                            <label for="costo"></label>
                            <input type="text" name="costo" id="costo"  value="<?php echo htmlentities($row_select['costo'], ENT_COMPAT, 'utf-8'); ?>" maxlength="11">
                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span> </p></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Departamento:</td>
                            <td><select name="departamento_id_departamento">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_departamento['id_departamento']?>" <?php if (!(strcmp($row_departamento['id_departamento'], htmlentities($row_select['departamento_id_departamento'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_departamento['departamento']?></option>
                              <?php
} while ($row_departamento = mysql_fetch_assoc($departamento));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input type="submit" value="Actualizar registro"></td>
                          </tr>
                        </table>
                        <h1 class="page-header"> <a href="costoenvio.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Atrás"> <i class="glyphicon glyphicon-arrow-left"></i> Atrás</a>                    </h1>
                        </div>
                        </div>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id_costo" value="<?php echo $row_select['id_costo']; ?>">
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:1, maxChars:11, minValue:1, maxValue:99999999999});
    </script>


</body>

</html>
<?php
mysql_free_result($select);

mysql_free_result($departamento);
?>
