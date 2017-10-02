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
  $insertSQL = sprintf(" CALL `addscatego` (%s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['categoria_id_categoria'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "subcategoria.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Categorias = 10;
$pageNum_Categorias = 0;
if (isset($_GET['pageNum_Categorias'])) {
  $pageNum_Categorias = $_GET['pageNum_Categorias'];
}
$startRow_Categorias = $pageNum_Categorias * $maxRows_Categorias;

mysql_select_db($database_config, $config);
$query_Categorias = "SELECT * FROM `subcategorias_productos`";
$query_limit_Categorias = sprintf("%s LIMIT %d, %d", $query_Categorias, $startRow_Categorias, $maxRows_Categorias);
$Categorias = mysql_query($query_limit_Categorias, $config) or die(mysql_error());
$row_Categorias = mysql_fetch_assoc($Categorias);

if (isset($_GET['totalRows_Categorias'])) {
  $totalRows_Categorias = $_GET['totalRows_Categorias'];
} else {
  $all_Categorias = mysql_query($query_Categorias);
  $totalRows_Categorias = mysql_num_rows($all_Categorias);
}
$totalPages_Categorias = ceil($totalRows_Categorias/$maxRows_Categorias)-1;

mysql_select_db($database_config, $config);
$query_Categoria = "SELECT * FROM categoria";
$Categoria = mysql_query($query_Categoria, $config) or die(mysql_error());
$row_Categoria = mysql_fetch_assoc($Categoria);
$totalRows_Categoria = mysql_num_rows($Categoria);
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
                      
                                               <div class="panel panel-default">
                        <div class="panel-heading">
                           Sub Categorias
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Administrar SubCategoria</a>
                                </li>
                                <li><a href="#agregar-pills" data-toggle="tab">Agregar SubCategoria</a>
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
                  <th>Categoria</th>
                     <th>SubCategoria</th>
                      <th>Descripcion</th>
                         <th>Acciones</th>
                                      
                  </tr>
                   </thead>
                    <tbody>
                
                     
                        <?php do { ?>
                          <tr class="odd gradeX">
                            <td><?php echo $row_Categorias['Categoria']; ?></td>
                            <td><?php echo $row_Categorias['SubCategoria']; ?></td>
                            <td><?php echo $row_Categorias['Descripcion']; ?></td>
                            <td class="text-center">
                              <div class="btn-group">
                              <a href="subcategoria_edit.php?id=<?php echo $row_Categorias['id_categoria']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                              <a href="subcategoria_delete.php?id=<?php echo $row_Categorias['id_categoria']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Editar">
                                <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </td>
                          </tr>
                          <?php } while ($row_Categorias = mysql_fetch_assoc($Categorias)); ?>
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
                                      <td nowrap align="right"><label>Nombre:</label></td>
                                      <td><input class="form-control" type="text" name="nombre" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Descripcion:</label></td>
                                      <td><input class="form-control" type="text" name="descripcion" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Categoria:</label></td>
                                      <td><select class="form-control" name="categoria_id_categoria">
                                        <?php 
do {  
?>
                                        <option value="<?php echo $row_Categoria['id_categoria']?>" ><?php echo $row_Categoria['nombre']?></option>
                                        <?php
} while ($row_Categoria = mysql_fetch_assoc($Categoria));
?>
                                      </select></td>
                                    <tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right">&nbsp;</td>
                                      <td><input type="submit" class="btn btn-primary" value="Insertar registro"></td>
                                    </tr>
                                  </table>
                                  <input type="hidden" name="MM_insert" value="form1">
                                </form>
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
mysql_free_result($Categorias);

mysql_free_result($Categoria);
?>