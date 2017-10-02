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
  $insertSQL = sprintf(" CALL `addadmin`(%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"),
                       GetSQLValueString($_POST['cargo'], "text"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['rol_id_rol'], "int"),
                       GetSQLValueString($_POST['dato_empresa_id_dato'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "superusuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_admin = 10;
$pageNum_admin = 0;
if (isset($_GET['pageNum_admin'])) {
  $pageNum_admin = $_GET['pageNum_admin'];
}
$startRow_admin = $pageNum_admin * $maxRows_admin;

mysql_select_db($database_config, $config);
$query_admin = "SELECT * FROM `datos_administrados`";
$query_limit_admin = sprintf("%s LIMIT %d, %d", $query_admin, $startRow_admin, $maxRows_admin);
$admin = mysql_query($query_limit_admin, $config) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);

if (isset($_GET['totalRows_admin'])) {
  $totalRows_admin = $_GET['totalRows_admin'];
} else {
  $all_admin = mysql_query($query_admin);
  $totalRows_admin = mysql_num_rows($all_admin);
}
$totalPages_admin = ceil($totalRows_admin/$maxRows_admin)-1;

mysql_select_db($database_config, $config);
$query_Empresa = "SELECT * FROM dato_empresa";
$Empresa = mysql_query($query_Empresa, $config) or die(mysql_error());
$row_Empresa = mysql_fetch_assoc($Empresa);
$totalRows_Empresa = mysql_num_rows($Empresa);
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
                      <h1 class="page-header">SuperUsuarios</h1>
                    	              <div class="panel panel-default">

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Administrar Usuarios</a>
                                </li>
                                <li><a href="#agregar-pills" data-toggle="tab">Agregar Administrador</a>
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
                     <th>Nombre</th>
                      <th>Apellido</th>
                        <th>Contraseña</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Cargo en la empresa</th>
                        <th>Empresa</th>
   
                                      
                                      <th>Acciones</th>
                                      
                  </tr>
                   </thead>
                    <tbody>
                      <?php do { ?>
  <tr class="odd gradeX">
    <td><?php echo $row_admin['email']; ?></td>
    <td><?php echo $row_admin['Nombre']; ?></td>
    <td><?php echo $row_admin['Apellido']; ?></td>
    <td><?php echo $row_admin['Contrasena']; ?></td>
    <td><?php echo $row_admin['Telefono']; ?></td>
    <td><?php echo $row_admin['Rol']; ?></td>
    <td class="center"><?php if($row_admin['Estado'] === '1'): ?>
      <span class="label label-success"><?php echo "Activo"; ?></span>
      <?php else: ?>
      <span class="label label-danger"><?php echo "Inactivo"; ?></span>
      <?php endif;?></td>
    <td><?php echo $row_admin['Cargo']; ?></td>
    <td><?php echo $row_admin['Nombre_empresa']; ?></td>
    <td class="text-center">
      <div class="btn-group">
      <a href="suario_edit.php?id=<?php echo $row_admin['idadmin']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
        <i class="glyphicon glyphicon-pencil"></i>
        </a>
      <a href="susuario_delete.php?id=<?php echo $row_admin['idadmin']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Editar" onclick="del()">
        <i class="glyphicon glyphicon-remove"></i>
        </a>
    </td>
  </tr>
  <?php } while ($row_admin = mysql_fetch_assoc($admin)); ?>
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
                                      <td><input class="form-control" type="text" name="nombre" value="" size="32"  required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Apellido:</label></td>
                                      <td><input class="form-control" type="text" name="apellido" value="" size="32"  required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Correo:</label></td>
                                      <td><input class="form-control" type="text" name="correo" value="" size="32" placeholder="nombre@dominio.com" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Contraseña:</label></td>
                                      <td><input class="form-control" type="text" name="contrasena" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Telefono:</label></td>
                                      <td><input class="form-control" type="text" name="telefono" value="" size="32"></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Cargo:</label></td>
                                      <td><input class="form-control" type="text" name="cargo" value="" size="32" required></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Estado:</label></td>
                                      <td><select class="form-control" name="estado">
                                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
                                        <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Inactivo</option>
                                      </select></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Rol:</label></td>
                                      <td><select class="form-control" name="rol_id_rol">
                                        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Administrador</option>
                                      </select></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>empresa:</label></td>
                                      <td><select class="form-control" name="dato_empresa_id_dato">
                                        <?php 
do {  
?>
                                        <option value="<?php echo $row_Empresa['id_dato']?>" ><?php echo $row_Empresa['nombre_empresa']?></option>
                                        <?php
} while ($row_Empresa = mysql_fetch_assoc($Empresa));
?>
                                      </select></td>
                                    <tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right">&nbsp;</td>
                                      <td><input class="btn btn-primary" type="submit" value="Insertar registro"></td>
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
mysql_free_result($admin);

mysql_free_result($Empresa);
?>
