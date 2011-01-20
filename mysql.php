<?PHP

$mysql_user="";
$mysql_pass="";
$mysql_server="localhost:8889";
$mysql_db="";

$mysql=mysql_connect($mysql_server, $mysql_user, $mysql_pass);
mysql_select_db($mysql_db, $mysql);

?>
