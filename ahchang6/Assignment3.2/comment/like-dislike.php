<?php
/**
 * PHP Comment Class
 * @author vishv23@yahoo.com - http://v23.in
 * @version 1.0.0
 * @date November 17, 2015
*/

include "config.php";
include "bootstrapcomment.php";

//----------edit if require-------------------------------
$fieldRequire=array("name"=>"","comment"=>"","uri"=>"","tm"=>"","pid"=>"");
//-------------------------------------------------------

//$co = new bootstrapcomment("localhost",$dbuser, $dbpass,$dbname);

if(isset($_REQUEST["name"]) && isset($_REQUEST["id"]))
{
foreach($fieldRequire as $k=>$v){
		if(isset($_REQUEST[$k]))
		$fieldRequire[$k]=$_REQUEST[$k];
	}
if(isset($_REQUEST['id']))	
$fieldRequire['pid']=$_REQUEST['id'];
if(isset($_REQUEST['uri']))	
$fieldRequire['url']=$_REQUEST['uri'];

 $co->save($fieldRequire['comment'],$fieldRequire['name'],$fieldRequire['url'],$fieldRequire['tm'],$_SERVER['REMOTE_ADDR'],$fieldRequire['pid']);	
exit;
}


if(isset($_REQUEST["group_no"]) && $_REQUEST["type"] == "showcomment")
{
$items_per_group=10;
	$group_number = filter_var($_REQUEST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	if(!is_numeric($group_number)){
		exit();
	}
	$position = ($group_number * $items_per_group);
	$co->url=$_REQUEST["uri"];
	
	
echo '<ul>';
$res = $co->fetchCategoryTree(0,$_REQUEST["uri"]," LIMIT $position, $items_per_group");
foreach ($res as $r) {
echo  $r;
}
echo '</ul>';
exit;
}	


if(isset($_REQUEST["type"]) && $_REQUEST["type"] == "like"){
$co->like($_REQUEST["id"]);
 if($r=$co->findDisLike($_REQUEST["id"]))
 echo $r->like;
}

if(isset($_REQUEST["type"]) && $_REQUEST["type"] == "dislike"){
$co->dislike($_REQUEST["id"]);
 if($r=$co->findDisLike($_REQUEST["id"]))
 echo $r->dislike;
}

exit;
?>