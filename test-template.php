<?

include "config.php";
include "bootstrapcomment.php";
//----------edit if require-------------------------------
//-----------------------------------------

$co2 = new bootstrapcomment("localhost",$dbuser, $dbpass,$dbname);
$print = "";
sleep(1);
$res=$co2->fetchCategoryTree(0,$_SERVER['REQUEST_URI'],4," LIMIT 1");
  foreach ($res as $r) {
  	$print .= (string)$r;
  	  
  }
  
    echo json_encode(utf8_encode($print));

?>