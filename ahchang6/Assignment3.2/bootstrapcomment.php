<?
/**
 * PHP Comment Class
 * @author vishv23@yahoo.com - http://v23.in
 * @version 1.0.0
 * @date November 17, 2015
*/


class bootstrapcomment{

var $link;
var $debug=false;
var $table;
var $fieldRequire;
var $primeryKey;
var $perPageDisplay;
var $badword;
var $iid;
var $rr;
var $url;
var $arr;
	public function __construct($host, $user, $pass, $db) 
	{
		$this->link = mysqli_connect($host, $user, $pass, $db);
			if (!$this->link && $debug) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
			}	
		//init	
		$this->arr=array();
		$this->url=substr($_SERVER['REQUEST_URI'], 0,-1);
		$this->table = "comment";
		$this->fieldRequire = array("name"=>"","comment"=>"");
		$this->primeryKey = "id";
		$this->perPageDisplay = 12;
		$this->badword = file("badwordslist.txt");
	}
  
	public function __destruct()
	{
	mysqli_close($this->link);
	}
	
  	public function close()
	{
	mysqli_close($this->link);
	}
	
	public function hit($durl)
	{
	
	$this->link->mysqli_query("UPDATE ".$this->table."  SET hit = hit + 1 WHERE `url`='".$durl."' LIMIT 1");
	}
	
	public function BadWordFilter($text, $replace, $bads)
	{	
	$text = preg_replace('/\s\s+/', ' ', $text);
	$text = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), ' ', $text);
		for($i=0;$i<sizeof($bads);$i++) {			
		$bads[$i]="/".trim($bads[$i])."/i";
		}
	$text = preg_replace($bads,'potato', $text);
	//$text = str_replace($bads,'potato', $text);
	
	return $text;
	}
	
	public function save($comment="",$name="",$uri='', $tm="",$ra="",$reply=false)
	{
	$na=array();
	$this->url=$uri;
		$commentprev = strlen($comment);
		if($this->badword){
		$name = $this->BadWordFilter($name,1,$this->badword); 
		$comment = $this->BadWordFilter($comment,1,$this->badword);

		}
		$commentnext = strlen($comment);
			$na['name']=(string)$name;
			$na['comment']=(string)$comment;
			//$na['name']=$this->link->real_escape_string((string)$name);
			//$na['comment']=$this->link->real_escape_string((string)$comment);
			//echo $na['name'];echo $na['comment'];
			$na['url']=$uri;
			$na['tm']=$tm;
			$na['ip']=$ra;
			$na['status']=1;
			//$na['like']=0;
			//$na['dislike']=0;
			if($reply)
			$na['pid']=$reply;
				foreach ($na as $key=>$value)
				{
				isset($vals) ? $vals .= ',' : $vals = '';
				isset($cols) ? $cols .= ',' : $cols = '';
				$vals .= '\''.$value.'\'';
				$cols .= '`'.$key.'`';
				}
        //--------- if time limit------------
        /*
			$ar = $this->link->query("SELECT * from ".$this->table." WHERE `tm` > '".$tm."'-1000 AND `tm` < '".$tm."' AND  `comment` = '".$comment."' AND  `url` = '".$this->url."' LIMIT 1");
            */
        
        $ar = $this->link->query("SELECT * from ".$this->table." WHERE  `tm` = '". $na['tm'] ."' AND  `url` = '".$this->url."' LIMIT 1");
        
		if( $ar->num_rows < 1){
		$this->link->query('INSERT INTO '.$this->table.' ('.$cols.') VALUES ('.$vals.')');
		$this->iid = mysqli_insert_id($this->link);
		
		}
		else{
		
		if ($this->debug){ 
		echo '<div class="alert alert-success"><strong>Error!</strong>All ready Exist.</div>';
        }
		}
	}
	
	public function like($id)
	{
	$this->link->query("UPDATE ".$this->table."  SET `like` = `like` + 1 WHERE `id`=".$id." LIMIT 1");
	}
	
	public function dislike($id)
	{
	$this->link->query("UPDATE ".$this->table."  SET `dislike` = `dislike` + 1 WHERE `id`=".$id." LIMIT 1");
	}
	
	
	public function totalRows($uri='',$condition='')
	{
	$sql = "SELECT * FROM ".$this->table." WHERE `url` = '".$uri."' ".$condition;
	$query = $this->link->query($sql);
		if ($query->num_rows > 0)
		return $query->num_rows;
		else
		return 0;
	}

	public function findDisLike($id)
	{
	$sql = "SELECT * FROM ".$this->table." WHERE  `id` = $id LIMIT 1";
	$query = $this->link->query($sql);
		if ($query->num_rows > 0)
		return mysqli_fetch_object($query);
		else
		return 0;
	}
  

	function fetchCategoryTree($parent = 0, $uri='', $level=0,$limit='', $key = 0) {
	error_log($key);
	if($key == 0){
		$key = "like";
		}
	else if($key == 1){
		$key = "tm";
	}
	else if($key == 2){
		$key = "dislike";
	}
		
	error_log($key);
		
		

	$sql = "SELECT * FROM ".$this->table." WHERE `url` = '".$uri."' AND `pid` = $parent ORDER BY `".$key."` DESC $limit";

	
	$query = $this->link->query($sql);
		if ($query->num_rows > 0) {
		
			while ($row = mysqli_fetch_object($query)) {
			
			$this->arr[] = '<ul><div class="media">';
			$this->arr[] =  '<div class="media-body"><div class="panel panel-info"><div class="panel-heading"><h4 class="media-heading text-primary">'. $row->name.'<small class="text-muted">   commented '. $this->timeAgo($row->date).'</small></h4></div><div class="panel-body">'. $row->comment .'<p class="pull-right"><span class="glyphicon glyphicon-pencil rreply" aria-hidden="true" aria-value="'. $row->id .'" id="REPLY'. $row->id .'"> Reply </span><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" aria-value="'. $row->id .'" id="UP'. $row->id .'"> '. $row->like .' </span><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" aria-value="'. $row->id .'" id="DOWN'. $row->id .'"> '. $row->dislike .' </span></p></div></div>';
			$this->arr = $this->fetchCategoryTree($row->id, $uri,$level+1,"LIMIT 1");
			$this->arr[] = '</div></div></ul>';
			}
		
		}
	return $this->arr;
	}
	



	public function findChild($uri,$cid)
	{
	$ar = $this->link->query("SELECT * FROM ".$this->table." WHERE  `id` = $cid AND  `url` = '".$uri."'  LIMIT 1");
		if( $ar->num_rows > 0){
		 while ($row = $ar->fetch_assoc()) {
		  if($row['pid'] != 0){
		 $this->findChild($uri,$row['pid']);
		 }
		
		}
}
	}
	
    
   
    
    public function render_temp($file, $data = array()) {

		if (file_exists($file)) {
			extract($data);
			ob_start();
			require($file);
			$out = ob_get_contents();
			ob_end_clean();
			return $out;
		} else {
		return false;
		}
	}
    
	public function timeAgo($time_ago){
		$cur_time = time();
		$time_elapsed = $cur_time - strtotime($time_ago);
		$seconds = $time_elapsed ;
		$minutes = round($time_elapsed / 60 );
		$hours = round($time_elapsed / 3600);
		$days = round($time_elapsed / 86400 );
		$weeks = round($time_elapsed / 604800);
		$months = round($time_elapsed / 2600640 );
		$years = round($time_elapsed / 31207680 );
			if($seconds <= 60){
			 return  "$seconds seconds ago";
			}
			else if($minutes <=60){
				 if($minutes==1){
				 return  "one minute ago";
				 }
				 else{
				 return  "$minutes minutes ago";
				 }
			}
			else if($hours <=24){
				 if($hours==1){
				 return  "an hour ago";
				 }else{
				 return  "$hours hours ago";
				 }
			}
			else if($days <= 7){
				 if($days==1){
				 return  "yesterday";
				 }else{
				 return  "$days days ago";
				 }
			}
			else if($weeks <= 4.3){
				 if($weeks==1){
				 return  "a week ago";
				 }else{
				 return  "$weeks weeks ago";
				 }
			}
			else if($months <=12){
				 if($months==1){
				 return  "a month ago";
				 }else{
				 return  "$months months ago";
				 }
			}
			else{
				 if($years==1){
				 return  "one year ago";
				 }else{
				 return  "$years years ago";
				 }
			}
	}
	



}

?>