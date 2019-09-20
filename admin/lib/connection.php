
<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','Kasuna#96');
define('DB_DATABASE','bt');
define('DB_PORT','3306');

//define('DB_HOST','localhost');
//define('DB_USER','root');
//define('DB_PASSWORD','');
//define('DB_DATABASE','fnhagent');

$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE,DB_PORT);
$GLOBALS['conn'];
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>