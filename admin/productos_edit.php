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
  $updateSQL = sprintf("UPDATE producto SET precio=%s, descripcion=%s, imagen=%s, nombre=%s, descuento=%s, proveedor_id_proveedor=%s, talla_id_talla=%s, color_id_color=%s, categoria_id_categoria=%s, marca_id_marca=%s WHERE id_producto=%s",
                       GetSQLValueString($_POST['precio'], "double"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['imagen'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['descuento'], "int"),
                       GetSQLValueString($_POST['proveedor_id_proveedor'], "int"),
                       GetSQLValueString($_POST['talla_id_talla'], "int"),
                       GetSQLValueString($_POST['color_id_color'], "int"),
                       GetSQLValueString($_POST['categoria_id_categoria'], "int"),
                       GetSQLValueString($_POST['marca_id_marca'], "int"),
                       GetSQLValueString($_POST['id_producto'], "int"));

  mysql_select_db($database_config, $config);
  $Result1 = mysql_query($updateSQL, $config) or die(mysql_error());

  $updateGoTo = "productos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$id_productos = "0";
if (isset($_GET["id"])) {
  $id_productos = $_GET["id"];
}
mysql_select_db($database_config, $config);
$query_productos = sprintf("SELECT * FROM producto WHERE producto.id_producto = %s", GetSQLValueString($id_productos, "int"));
$productos = mysql_query($query_productos, $config) or die(mysql_error());
$row_productos = mysql_fetch_assoc($productos);
$totalRows_productos = mysql_num_rows($productos);

mysql_select_db($database_config, $config);
$query_categoria = "SELECT * FROM categoria";
$categoria = mysql_query($query_categoria, $config) or die(mysql_error());
$row_categoria = mysql_fetch_assoc($categoria);
$totalRows_categoria = mysql_num_rows($categoria);

mysql_select_db($database_config, $config);
$query_color = "SELECT * FROM color";
$color = mysql_query($query_color, $config) or die(mysql_error());
$row_color = mysql_fetch_assoc($color);
$totalRows_color = mysql_num_rows($color);

mysql_select_db($database_config, $config);
$query_talla = "SELECT * FROM talla";
$talla = mysql_query($query_talla, $config) or die(mysql_error());
$row_talla = mysql_fetch_assoc($talla);
$totalRows_talla = mysql_num_rows($talla);

mysql_select_db($database_config, $config);
$query_proveedor = "SELECT * FROM proveedor";
$proveedor = mysql_query($query_proveedor, $config) or die(mysql_error());
$row_proveedor = mysql_fetch_assoc($proveedor);
$totalRows_proveedor = mysql_num_rows($proveedor);

mysql_select_db($database_config, $config);
$query_marca = "SELECT * FROM marca";
$marca = mysql_query($query_marca, $config) or die(mysql_error());
$row_marca = mysql_fetch_assoc($marca);
$totalRows_marca = mysql_num_rows($marca);
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                      <h1 class="page-header">Editar Producto</h1>
                      <p></p>
                      <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                        <table align="center">
                          <tr valign="baseline">
                            <td nowrap align="right">Precio:</td>
                            <td><input class="form-control" type="text" name="precio" value="<?php echo htmlentities($row_productos['precio'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Descripcion:</td>
                            <td><input class="form-control" type="text" name="descripcion" value="<?php echo htmlentities($row_productos['descripcion'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Imagen:</td>
                            <td><input class="form-control" type="text" name="imagen" value="<?php echo htmlentities($row_productos['imagen'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Nombre:</td>
                            <td><input class="form-control" type="text" name="nombre" value="<?php echo htmlentities($row_productos['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Descuento:</td>
                            <td><input class="form-control" type="text" name="descuento" value="<?php echo htmlentities($row_productos['descuento'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Proveedor:</td>
                            <td><select class="form-control" name="proveedor_id_proveedor">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_proveedor['id_proveedor']?>" <?php if (!(strcmp($row_proveedor['id_proveedor'], htmlentities($row_productos['proveedor_id_proveedor'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_proveedor['empresa']?></option>
                              <?php
} while ($row_proveedor = mysql_fetch_assoc($proveedor));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Talla:</td>
                            <td><select class="form-control" name="talla_id_talla">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_talla['id_talla']?>" <?php if (!(strcmp($row_talla['id_talla'], htmlentities($row_productos['talla_id_talla'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_talla['medida']?></option>
                              <?php
} while ($row_talla = mysql_fetch_assoc($talla));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Color:</td>
                            <td><select class="form-control" name="color_id_color">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_color['id_color']?>" <?php if (!(strcmp($row_color['id_color'], htmlentities($row_productos['color_id_color'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_color['descripcion']?></option>
                              <?php
} while ($row_color = mysql_fetch_assoc($color));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Categoria:</td>
                            <td><select class="form-control" name="categoria_id_categoria">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_categoria['id_categoria']?>" <?php if (!(strcmp($row_categoria['id_categoria'], htmlentities($row_productos['categoria_id_categoria'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_categoria['descripcion']?></option>
                              <?php
} while ($row_categoria = mysql_fetch_assoc($categoria));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">Marca_id_marca:</td>
                            <td><select class="form-control" name="marca_id_marca">
                              <?php
do {  
?>
                              <option value="<?php echo $row_marca['id_marca']?>"<?php if (!(strcmp($row_marca['id_marca'], htmlentities($row_productos['marca_id_marca'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_marca['marca']?></option>
                              <?php
} while ($row_marca = mysql_fetch_assoc($marca));
  $rows = mysql_num_rows($marca);
  if($rows > 0) {
      mysql_data_seek($marca, 0);
	  $row_marca = mysql_fetch_assoc($marca);
  }
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input class="form-control" type="submit" value="Editar"></td>
                          </tr>
                        </table>
                        <input type="hidden" name="id_producto" value="<?php echo $row_productos['id_producto']; ?>">
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="id_producto" value="<?php echo $row_productos['id_producto']; ?>">
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
mysql_free_result($productos);

mysql_free_result($categoria);

mysql_free_result($color);

mysql_free_result($talla);

mysql_free_result($proveedor);

mysql_free_result($marca);
?>
