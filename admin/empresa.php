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
  $insertSQL = sprintf(" CALL addempresa(%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre_empresa'], "text"),
                       GetSQLValueString($_POST['mision'], "text"),
                       GetSQLValueString($_POST['Vision'], "text"),
                       GetSQLValueString($_POST['imgSlider'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($insertSQL, $config) or die(mysql_error());

  $insertGoTo = "empresa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Empresa = 10;
$pageNum_Empresa = 0;
if (isset($_GET['pageNum_Empresa'])) {
  $pageNum_Empresa = $_GET['pageNum_Empresa'];
}
$startRow_Empresa = $pageNum_Empresa * $maxRows_Empresa;

mysql_select_db($database_config, $config);
$query_Empresa = "SELECT * FROM dato_empresa ORDER BY dato_empresa.nombre_empresa ASC";
$query_limit_Empresa = sprintf("%s LIMIT %d, %d", $query_Empresa, $startRow_Empresa, $maxRows_Empresa);
$Empresa = mysql_query($query_limit_Empresa, $config) or die(mysql_error());
$row_Empresa = mysql_fetch_assoc($Empresa);

if (isset($_GET['totalRows_Empresa'])) {
  $totalRows_Empresa = $_GET['totalRows_Empresa'];
} else {
  $all_Empresa = mysql_query($query_Empresa);
  $totalRows_Empresa = mysql_num_rows($all_Empresa);
}
$totalPages_Empresa = ceil($totalRows_Empresa/$maxRows_Empresa)-1;
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
<script>
function subirimagen(){
      self.name='opener';
      remote= open('gestionimagen.php', 'remote', 'width=400, height=150, location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no,statur=yes');
      remote.focus();
      }
        
        </script>
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
                     
                     
                                          <div class="panel panel-default">
                        <div class="panel-heading">
                           Empresa
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#home-pills" data-toggle="tab">Administrar empresa</a>
                                </li>
                                <li><a href="#agregar-pills" data-toggle="tab">Agregar Empresa</a>
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
                                      <th>Nombre</th>
                                      <th>Correo</th>
                                      <th>Telefono</th>
                                      <th>Logo</th>
                                      <th>Mision</th>
                                      <th>Vision</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php do { ?>
  <tr class="odd gradeX">
    <td><?php echo $row_Empresa['nombre_empresa']; ?></td>
    <td><?php echo $row_Empresa['correo']; ?></td>
    <td><?php echo $row_Empresa['telefono']; ?></td>
     <td><img src="../images/<?php echo $row_Empresa['logo']; ?>" width="50" height="50"></td>
        <td><?php echo $row_Empresa['mision']; ?></td>
    <td><?php echo $row_Empresa['Vision']; ?></td>
    <td class="text-center">
      <div class="btn-group">
        <a href="empresa_edit.php?id=<?php echo $row_Empresa['id_dato']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
          <i class="glyphicon glyphicon-pencil"></i>
          </a>
             <a href="empresa_delete.php?id=<?php echo $row_Empresa['id_dato']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar" onclick="del()">
                            <i class="glyphicon glyphicon-remove"></i>
                            </a>

    </td>
  </tr>
  <?php } while ($row_Empresa = mysql_fetch_assoc($Empresa)); ?>
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
							  &nbsp;
                                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                  <table align="center">
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Nombre :</label></td>
                                      <td>
                                        <input name="nombre_empresa" type="text" class="form-control" value="" size="32" maxlength="45" required>
                                     </td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right" valign="top"><label>Mision:</label></td>
                                      <td><textarea class="form-control" name="mision" cols="50" rows="5" required></textarea></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right" valign="top"><label>Vision:</label></td>
                                      <td><textarea class="form-control" name="Vision" cols="50" rows="5" required></textarea></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Logo:</label></td>
                                      <td> <input class="form-control" type="text" name="imgSlider" value="" size="32" readonly>		
									  <input type="button"  class="btn btn-primary" name="btnimagen" id="btnimagen" value="subir imagen" onClick="javascript:subirimagen();"></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Correo:</label></td>
                                      <td><span id="sprytextfield1">
                                      <input name="correo" type="text" class="form-control" placeholder="ejemplo@dominio.com" value="" size="32" maxlength="45" required>
                                      <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right"><label>Telefono:</label></td>
                                      <td><span id="sprytextfield2">
                                      <input class="form-control" maxlength="8" type="text" name="telefono" value="" size="32" placeholder="ingrese el numero sin guiones" required>
                                     <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                                    </tr>
                                    <tr valign="baseline">
                                      <td nowrap align="right">&nbsp;</td>
                                      <td><input class="btn btn-success" type="submit" value="ingresar registro"></td>
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
                 <!-- InstanceEndEditable --> </div>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {hint:"ejemplo@dominio.com"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer");
    </script>


</body>

<!-- InstanceEnd --></html>
<?php
mysql_free_result($Empresa);
?>
