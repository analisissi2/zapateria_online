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
  $insertSQL = sprintf(" CALL `addusuario` (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['rol_id_rol'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_config, $config);
$query_Usuarios = "SELECT * FROM usuario";
$Usuarios = mysql_query($query_Usuarios, $config) or die(mysql_error());
$row_Usuarios = mysql_fetch_assoc($Usuarios);
$totalRows_Usuarios = mysql_num_rows($Usuarios);
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
<SCRIPT languaje="JavaScript">
function del() {
alert("Registro Eliminado con Exito!!");
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
                      <h1 class="page-header">Usuarios</h1>
                                            
                         <div class="panel panel-default">
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Administrar Usuarios</a>
                                </li>
                                <li><a href="#agregar-pills" data-toggle="tab">Agregar Usuario</a>
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
                  <th>Correo</th>
                     <th>Contraseña</th>
                      <th>Nombre</th>
                        <th>Apellido</th>
                        <th>estado</th>
   
                                      
                                      <th>Acciones</th>
                                      
                  </tr>
                   </thead>
                    <tbody>
                
                      <?php do { ?>
                        <tr class="odd gradeX">
                          <td><?php echo $row_Usuarios['correo']; ?></td>
                          <td><?php echo $row_Usuarios['contrasena']; ?></td>
                          <td><?php echo $row_Usuarios['nombre']; ?></td>
                          <td><?php echo $row_Usuarios['apellido']; ?></td>
                          <td class="center"><?php if($row_Usuarios['estado'] === '1'): ?>
                            <span class="label label-success"><?php echo "Activo"; ?></span>
                            <?php else: ?>
                            <span class="label label-danger"><?php echo "Inactivo"; ?></span>
                            <?php endif;?></td>
                          <td class="text-center">
                            <div class="btn-group">
                            <a href="usuario_edit.php?id=<?php echo $row_Usuarios['correo']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                              <i class="glyphicon glyphicon-pencil"></i>
                              </a>
                            <a href="usuario_delete.php?id=<?php echo $row_Usuarios['correo']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar" onclick="del()">
                              <i class="glyphicon glyphicon-remove"></i>
                              </a>
                          </td>
                        </tr>
                        <?php } while ($row_Usuarios = mysql_fetch_assoc($Usuarios)); ?>
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
                                      <td nowrap align="right"><label>Correo:</label></td>
                                      <td><input class="form-control" type="text" name="correo" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Contraseña:</label></td>
                                      <td><input class="form-control" type="text" name="contrasena" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Nombre:</label></td>
                                      <td><input class="form-control" type="text" name="nombre" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Apellido:</label></td>
                                      <td><input class="form-control" type="text" name="apellido" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Estado:</label></td>
                                      <td><select class="form-control" name="estado">
                                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
                                      </select></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Rol:</label></td>
                                      <td><select class="form-control" name="rol_id_rol">
                                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Usuario</option>
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
mysql_free_result($Usuarios);
?>
