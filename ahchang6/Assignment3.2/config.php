<?
/**
 * PHP Comment Class
 * @author vishv23@yahoo.com - http://v23.in
 * @version 1.0.0
 * @date November 17, 2015
*/

//----------------------- edit-------------------
define("APP",$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
date_default_timezone_set("US/Central");
define('DB_HOST', 'localhost');
define('DB_NAME', 'ahchang6_portfolio');
define('DB_USER', 'ahchang6_admin');
define('DB_PASS', 'a8E.4RByhLcS');

$dbtable="comment";

$primeryKey="id";
$perPageDisplay=10;

$dbuser=DB_USER;
$dbpass=DB_PASS;
$dbname=DB_NAME;
$badwordFile = "badwordslist.txt";

//----------------------------------------------

?>




