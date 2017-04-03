<?php
/**
 * PHP Comment Class
 * @author vishv23@yahoo.com - http://v23.in
 * @version 1.0.0
 * @date November 17, 2015
*/

include_once "config.php";
include_once "bootstrapcomment.php";

//----------edit if require-------------------------------
$fieldRequire=array("name"=>"","comment"=>"");
//-----------------------------------------

$co = new bootstrapcomment("localhost",$dbuser, $dbpass,$dbname);

//------------------Save Comment---------------


//-----------------------------------



$totalRow=$co->totalRows(substr($_SERVER['REQUEST_URI'], 0,-1));

if($totalRow > $perPageDisplay )
$tgroup=round($totalRow / $perPageDisplay );
else
$tgroup=1;

$output['script'] = '<script>
  $(".replyin").hide();


	
	  $(".rreply").click(function(){
		var id = $(this).attr("aria-value");
		
            if($(".replyin").is(":visible")){
                $(".replyin").hide();
				$("#id").val(0);
				 $("#freply").show();
            } else {
			$("#id").val(id);
                $(".replyin").show();
				  $("#freply").hide();
				  $("#name").focus();
            }
           
            return false;
        });
		
$(document).ready(function() {

$("#optionOne").attr("value",window.location.href.slice(0,-1) + "0");
$("#optionTwo").attr("value",window.location.href.slice(0,-1) + "1");
$("#optionThree").attr("value",window.location.href.slice(0,-1) + "2");

$(".glyphicon-thumbs-up").one("click",function(){
var id = $(this).attr("aria-value");
$.post("like-dislike.php",{"type":"like","id":id}, function(data){

  
   


					$("#UP"+id).text(" " +data);
				})
});

$(".glyphicon-thumbs-down").one("click",function(){
var id = $(this).attr("aria-value");
 $.ajax({
    url : "like-dislike.php",
    type: "POST",
    data : {"type": "dislike","id":id},
    success: function(data)
    {
       $("#DOWN"+id).text(" " +data);
    }
});
$(this).text(d + "v");
});	




});	

</script>

<script>
</script>
';

$output['maincontent'] ='
<p>ALL COMMENTS '.$totalRow.'</p>
<div class="form-group rreply" id="freply">
      <input type="text" class="form-control ">
  </div>
 
<div class="form-group replyin">
<!-- 
 <form method="post" action="'.substr($_SERVER['REQUEST_URI'], 0,-1).'" id="foo">
-->
<input type="hidden" name="tm" id = "time" value="'.time().'"/>
<input type="hidden" name="uri" id = "uri" value="'.substr($_SERVER['REQUEST_URI'], 0,-1).'"/>
<input type="hidden" name="id" id="id" value="0"/>
 <div class="form-group">
      <input type="text" class="form-control" id="name" name="name"  placeholder="Name...">
  </div>
  
   <div class="form-group">
      <textarea class="form-control" id="comment" name="comment" row="5" placeholder="Add a public comment..."></textarea>
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-info" id="submit">Comment</button>
  </div>
  <select onchange="location = this.options[this.selectedIndex].value;">
    <option>Different Sorting</option>
    <option id = "optionOne" value="">Likes (Default)</option>
    <option id = "optionTwo" value="">Time</option>
    <option id = "optionThree" value="">Dislikes</option>
</select>
</form>
  </div>

';

$output['maincontent'] .='<ul id="insert-block">';

$res=$co->fetchCategoryTree(0,substr($_SERVER['REQUEST_URI'], 0,-1),3," LIMIT 20",intval(substr($_SERVER['REQUEST_URI'],-1)));

  foreach ($res as $r) {
    $output['maincontent'] .=  $r;
  }

$output['maincontent'] .= '</ul>';





$output['title']="Demo COMMENT";

$output['style']='
<style>
.showmore{padding: 10px;width: 80%; border: 1px solid #777;}
.showmore:hover{background-color: #ddd;}
.bg-info{padding: 10px;border: 1px solid #6CA6CD;font-weight: 700;}
#fo{
background-color: #e5f1ff;
border: 1px solid #b2d7ff;
padding-top: 10px;
margin-bottom: 10px;
}
.panel-body{padding: 10px; color: #777;}
span{
margin-right: 12px;
cursor: pointer;
}

span:hover{
opacity: .2;
}

glyphicon{

}
</style>';


if(is_file( "comment-template.php"))
echo $co->render_temp(   "comment-template.php",array("output"=>$output));


unset($output);
?>