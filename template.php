<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content=""><meta name="author" content="">
	<title>1 Col Portfolio - Start Bootstrap Template</title>
	<link href="css/stylin.css" rel="stylesheet" /><!-- Custom CSS -->
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet" /><!-- Custom CSS -->
	<link href="css/1-col-portfolio.css" rel="stylesheet" /><!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --><!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>--!>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        
         <!-- jquery extension -->
<script type="text/javascript" src="jquery/jquery.min.js"></script> 
<script>
$(document).ready(function(){
    $("#iframe-toggler").click(function(){
        $("iframe").toggle();
    });
    
    
$("#submit").click(function(){
var id = $(this).attr("aria-value");
//alert(prepend);
var name = $("#name").val();
var comment = $("#comment").val();
var uri = $("#uri").attr("value");
var time = $("#time").attr("value");
var id = $("#id").attr("value");

 $.ajax({
    url : "comment-helper.php",
    type: "POST",
    data : {"type": "comment","comment": comment, "name": name, "id":id, "uri":uri, "time":time},
    success: function(data)
    {
    	$("#insert-block").prepend(data.trim());
    	$('#name').val('');
	$('#comment').val('');
    }
    
    
});
$(this).text(d + "v");
});	
    
});
</script>


<!-- method for saving and retrieving data without refreshing the page. -->
<!-- remove for now
<script type="text/javascript" > 

$(document).on("click", "#submit", function () {

 jQuery("#display").fadeIn(900, 0); 
 /* load all variables */
 var name = document.getElementById('name').value
 var COMMENT = document.getElementById('COMMENT').value 
 var PAGE = "<?php echo $_GET['page']; ?>"
 
 $.ajax({ //create an ajax request to load_page.php
 type:"POST", 
 url: "process.php", 
 dataType: "text", //expect html to be returned 
 data:{NAME:name,COMMENT:COMMENT,PAGE:PAGE}, 
 success: function(data){ 
 $("#display").html(data); 
 
 }
 }); 
}); 
</script>
        
        -->
        
    <![endif]-->
</head>
<body><!-- Navigation -->

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container"><!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header"><button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span></button><a class="navbar-brand" href="index.php">Projects</a></div>
<!-- Collect the nav links, forms, and other content for toggling -->

<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">
	<li><a href="about.html">About</a></li>
	<li><a href="#">Contact</a></li>
</ul>
</div>
<!-- /.navbar-collapse --></div>
<!-- /.container --></nav>
<!-- Page Content -->

<div class="container"><!-- Page Heading -->
<div class="row">
<div class="col-lg-12">
<h1 class="page-header">CS 242 <small>
        <?php
	echo substr($_GET['page'],0,-1);
	?>
        </a>
</small></h1>
</div>
</div>
<button id="iframe-toggler"> Toggle Viewing Window </button>
<?php 
include 'templateHelper.php';
include 'comment.php';
 ?>


<div id="contentLeft">
<iframe name="codeViewerLeft" id="codeViewerLeft" src="direction.html"></iframe>
</div>

<div id="contentRight">
<iframe name="codeViewerRight" id="codeViewerRight" src="direction.html"></iframe>
</div>

<hr /><!-- Footer -->
<footer>
<div class="row">
<div class="col-lg-12">
<p>Copyright &copy; Your Website 2014</p>
</div>
</div>
<!-- /.row --></footer>
</div>
<!-- /.container --><!-- jQuery --><script src="js/jquery.js"></script><!-- Bootstrap Core JavaScript --><script src="js/bootstrap.min.js"></script></body>
</html>