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

$maxRows_comentario = 10;
$pageNum_comentario = 0;
if (isset($_GET['pageNum_comentario'])) {
  $pageNum_comentario = $_GET['pageNum_comentario'];
}
$startRow_comentario = $pageNum_comentario * $maxRows_comentario;

mysql_select_db($database_config, $config);
$query_comentario = "SELECT * FROM `comentarios`";
$query_limit_comentario = sprintf("%s LIMIT %d, %d", $query_comentario, $startRow_comentario, $maxRows_comentario);
$comentario = mysql_query($query_limit_comentario, $config) or die(mysql_error());
$row_comentario = mysql_fetch_assoc($comentario);

if (isset($_GET['totalRows_comentario'])) {
  $totalRows_comentario = $_GET['totalRows_comentario'];
} else {
  $all_comentario = mysql_query($query_comentario);
  $totalRows_comentario = mysql_num_rows($all_comentario);
}
$totalPages_comentario = ceil($totalRows_comentario/$maxRows_comentario)-1;
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
                      <h1 class="page-header">Comentario</h1>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                        Bienvenido
                        </div>
                        	 <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Comentarios sobre productos</a>
                                
                              </li>
                                
                            </ul>
                            <div class="tab-content">
                            <div class="tab-pane fade in active" id="home-pills">
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            <div class="panel-body">
                           
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                 <thead>
                  <tr>
                  <th>Usuario</th>
                     <th>Comentario</th>
                     <th>Estado</th>
                     <th>Producto</th>
                     <th>Categoria</th>
                     <th>Marca</th>
                     <th>Cargo</th> 
                                      <th>Acciones</th>
                                      
                  </tr>
                   </thead>
                    <tbody>
                      <?php do { ?>
  <tr class="odd gradeX">
    <td><?php echo $row_comentario['usuario_correo']; ?></td>
    <td><?php echo $row_comentario['comentario']; ?></td>
    <td class="center"><?php if($row_comentario['estado'] === '1'): ?>
      <span class="label label-success"><?php echo "Activo"; ?></span>
      <?php else: ?>
      <span class="label label-danger"><?php echo "Inactivo"; ?></span>
      <?php endif;?></td>
    <td><?php echo $row_comentario['producto']; ?></td>
    <td class="center"><?php echo $row_comentario['categoria']; ?></td>
    <td class="center"><?php echo $row_comentario['marca']; ?></td>
    <td class="center"><?php echo $row_comentario['cargo']; ?></td>
    <td class="text-center"><div class="btn-group">
      <a href="comentario_edit.php?id=<?php echo $row_comentario['id_comentario']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar"> <i class="glyphicon glyphicon-pencil"></i> </a> <a href="comentario_delete.php?id=<?php echo $row_comentario['id_comentario']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar"> <i class="glyphicon glyphicon-remove"></i> </a></td>
  </tr>
  <?php } while ($row_comentario = mysql_fetch_assoc($comentario)); ?>
                    </tbody>
                            </table>
                            </div>
                            </div>
                            </div>

                            </div>
                                        
                            </div>
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
mysql_free_result($comentario);
?>
