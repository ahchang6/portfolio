<?

include "config.php";
include "bootstrapcomment.php";

//----------edit if require-------------------------------
//-----------------------------------------

$co = new bootstrapcomment("localhost",$dbuser, $dbpass,$dbname);

//------------------Save Comment---------------
if(isset($_REQUEST['uri'])){
$co->save($_REQUEST['comment'],$_REQUEST['name'],$_REQUEST['uri'],time(),$_SERVER['REMOTE_ADDR'],$_REQUEST['id']);
$print = "";
$res=$co->fetchCategoryTree(0,$_REQUEST['uri'],4," LIMIT 1",1);
  foreach ($res as $r) {
  	$print .= (string)$r;
  	  
  }
  
    echo $print;
}
else{
echo "500";
}


?>