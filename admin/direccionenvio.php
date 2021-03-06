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

mysql_select_db($database_config, $config);
$query_selectdireccionenvio = "SELECT * FROM direccionenvioproducto";
$selectdireccionenvio = mysql_query($query_selectdireccionenvio, $config) or die(mysql_error());
$row_selectdireccionenvio = mysql_fetch_assoc($selectdireccionenvio);
$totalRows_selectdireccionenvio = mysql_num_rows($selectdireccionenvio);
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
                      <h1 class="page-header">Dirección Envío</h1>
                      <a href="direccionenvio_add.php" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Añadir"> <i class="glyphicon glyphicon-plus"></i> Añadir una nueva dirección de envio</a>

                     <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                     
                      <tr>
                          <td>id</td>
                          <td>Nombre</td>
                          <td>Apellido</td>
                          <td>Tel</td>
                          <td>Correo</td>
                          <td>Zip</td>
                          <td>Direccion envio</td>
                          <td>Usuario</td>
                          <td>Rol</td>
                          <td>Departamento</td>
                          <td>Municipio</td>
                          <td>Acciones</td>
                        </tr>
                      <?php do { ?>
                      <tr>
                          <td><?php echo $row_selectdireccionenvio['id']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['nombre']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['apellido']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['tel']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['correo']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['Zip']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['detalles de direccion']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['usuario']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['Rol']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['Departamento']; ?></td>
                          <td><?php echo $row_selectdireccionenvio['municipio']; ?></td>
                          <td><a href="direccionenvio_edit.php?recordID=<?php echo $row_selectdireccionenvio['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                          <i class="glyphicon glyphicon-pencil"></i>
                          </a>
                            <a href="direccionenvio_delete.php?recordID=<?php echo $row_selectdireccionenvio['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                                <i class="glyphicon glyphicon-remove"></i>
                            </a></td>
                        </tr>
                          <?php } while ($row_selectdireccionenvio = mysql_fetch_assoc($selectdireccionenvio)); ?>
                    </table>
                    
                    <p></p>
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
mysql_free_result($selectdireccionenvio);
?>
