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
  $insertSQL = sprintf("CALL addtarjetac(%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['numero_tdc'], "int"),
                       GetSQLValueString($_POST['fecha_expiracion'], "int"),
                       GetSQLValueString($_POST['CCV2'], "int"),
                       GetSQLValueString($_POST['nombre_titular'], "text"),
                       GetSQLValueString($_POST['forma_pago_id_tipo_pago'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "tarjeta_credito.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_TDC = 10;
$pageNum_TDC = 0;
if (isset($_GET['pageNum_TDC'])) {
  $pageNum_TDC = $_GET['pageNum_TDC'];
}
$startRow_TDC = $pageNum_TDC * $maxRows_TDC;

mysql_select_db($database_config, $config);
$query_TDC = "SELECT * FROM pago_tarjeta_credito";
$query_limit_TDC = sprintf("%s LIMIT %d, %d", $query_TDC, $startRow_TDC, $maxRows_TDC);
$TDC = mysql_query($query_limit_TDC, $config) or die(mysql_error());
$row_TDC = mysql_fetch_assoc($TDC);

if (isset($_GET['totalRows_TDC'])) {
  $totalRows_TDC = $_GET['totalRows_TDC'];
} else {
  $all_TDC = mysql_query($query_TDC);
  $totalRows_TDC = mysql_num_rows($all_TDC);
}
$totalPages_TDC = ceil($totalRows_TDC/$maxRows_TDC)-1;
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
alert("Registro Agregado con Exito!!");
}
</SCRIPT>
<script type="text/javascript" language="javascript">

    function eliminartdc()
    {

             valor="<?php echo $row_TDC['id_tdc']; ?>"
             location.href='tdc_delete.php?id='+valor;
             alert("registro eliminado"+valor);

     }
</script>
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
                      <h1 class="page-header">Tarjeta de credito</h1>
                      
                         <div class="panel panel-default">
                        <div class="panel-heading">
                           Empresa
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Administrar Tajetas de credito</a>
                                </li>
                                <li><a href="#agregar-pills" data-toggle="tab">Agregar TC</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home-pills">
                             <!--IINICIO DE TABLA -->
                      
                        <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">

            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                 <thead>
                  <tr>
                  <th>Nombre del Titular</th>
                     <th>Numero TDC</th>
                      <th>Fecha Expiración</th>
                        <th>CCV2</th>
                                      
                                      <th>Acciones</th>
                                      
                  </tr>
                   </thead>
                    <tbody>
                      <?php do { ?>
  <tr class="odd gradeX">
    <td><?php echo $row_TDC['TITULAR']; ?></td>
    <td><?php echo $row_TDC['TDC']; ?></td>
    <td><?php echo $row_TDC['EXPIRACION']; ?></td>
    <td><?php echo $row_TDC['CCV']; ?></td>
    <td class="text-center">
      <div class="btn-group">
      <a href="tdc_edit.php?id=<?php echo $row_TDC['id_tdc']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
        <i class="glyphicon glyphicon-pencil"></i>
        </a>
		<a href="tdc_delete.php?id=<?php echo $row_TDC['id_tdc']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
        <i class="glyphicon glyphicon-remove"></i>
        </a>
    </td>
  </tr>
  <?php } while ($row_TDC = mysql_fetch_assoc($TDC)); ?>
                    </tbody>
                            </table>

                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                
                                <!-- FIN DE modal -->
                      <!-- FIN DE TABLA -->
                        
                                </div>

                                </div>
                              <div class="tab-pane fade" id="agregar-pills">
                                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                  <table align="center">
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Numero de la tarjeta:</label></td>
                                      <td><input class="form-control" type="text" name="numero_tdc" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Fecha de expiracion:</label></td>
                                      <td><input class="form-control" type="text" name="fecha_expiracion" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>CCV2:</label></td>
                                      <td><input class="form-control" type="text" name="CCV2" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Nombre del titular:</label></td>
                                      <td><input class="form-control" type="text" name="nombre_titular" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Tipo:</label></td>
                                      <td><select class="form-control" name="forma_pago_id_tipo_pago">
                                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Tarjeta de Credito</option>
                                      </select></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right">&nbsp;</td>
                                      <td><input type="submit" value="Insertar registro" class="btn btn-primary"></td>
                                    </tr>
                                  </table>
                                  <input type="hidden" name="MM_insert" value="form1">
                                </form>
                                <p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
                              </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
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
mysql_free_result($TDC);
?>
