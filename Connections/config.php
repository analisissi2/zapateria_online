<?php
error_reporting(E_ALL ^ E_DEPRECATED);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_config = "localhost";
$database_config = "id2617362_zapateriaonline";
$username_config = "id2617362_analisissi2";
$password_config = "analisis2";
$config = mysql_pconnect($hostname_config, $username_config, $password_config) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php 
 define( 'DB_HOST', 'localhost' );          // Set database host
  define( 'DB_USER', 'id2617362_analisissi2' );             // Set database user
  define( 'DB_PASS', 'analisis2' );             // Set database password
  define( 'DB_NAME', 'id2617362_zapateriaonline' );        // Set database name
?>