<?php
/**
 * Created by PhpStorm.
 * User: Alvin
 * Date: 3/11/2017
 * Time: 3:31 PM
 */
if(!file_exists('svn_xml/svn_list.xml')){
    echo "Project does not exist";
}
$xml_list = simplexml_load_file('svn_xml/svn_list.xml') or die("Error: Cannot create");
$xml_log = simplexml_load_file('svn_xml/svn_log.xml') or die("Error: Cannot create");
include 'parsed_log.php';

$parsed_log = new parsed_log($xml_log);


$assignment = array();
$assignment['chess'] = 'Assignment1';
$assignment['web_scraping'] = 'Assignment2';
$assignment['portfolio'] = 'Assignment3';

$target = $assignment[substr($_GET['page'],0,-1)];
$revision = 1000;
$date;
$files = array();

$origin = $xml_list->list['path'] . "/";

include 'entry.php';
//grabs children->children gives us the lists of entries
foreach($xml_list->children()->children() as $entry){
    if(strpos($entry->name, $target) !== false){

	//set up to add a new entry
	$entry_item = new entry($entry);
	
        $inbetween_file_name = (string)$entry->name;

        $file_name_array = explode('/', $inbetween_file_name, 2);
        if(sizeof($file_name_array)<=1){
        	continue;
        }
        $file_name = $file_name_array[1];
        //print_r($file_name);
        

        
        //if(!array_key_exists($file_name)){
        //   $files[$file_name] = array();
        //}
        $files[$file_name][] = $entry_item;
       // $files[$file_name] = $entry->commit['revision'];


        if((int)$entry->commit['revision'] > $revision) {
            $revision = $entry->commit['revision'];
            $date = $entry->commit->date;
        }
    }
}
	$rev = (string)$revision;
	echo '<h3>Current Revision: ' . $rev . '</h3></br';
	echo '<h3>Revision date: ' . $date . '</h3></br>';
	echo '<h3>Summary: ' . $parsed_log->revision_message[$rev] . '</h3><br>';
$divID = 2;
foreach(array_keys($files) as $file){
 echo '<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapse' . $divID . '">'
        . ' (' . current($files[$file])->kind . ') ' . $file . 
        '</a>
      </h4>
    </div>
    <div id="collapse' . $divID . '" class="panel-collapse collapse">';
    $item_value = 0;
    //dropdown panel for each version
    foreach($files[$file] as $entry){
    	$link_path = $origin . $entry->path;
    	$curRevision = (string)$entry->revision;
        echo '<div class="item' . $item_value .'"><font color="red">&nbsp;&nbsp;';
        echo '<a href=' . $link_path . ' target="codeViewerLeft">Left</a>&nbsp;';
        echo '<a href=' . $link_path . ' target="codeViewerRight">Right</a>&nbsp;&nbsp;';
        echo $curRevision . '</font>' . ' author:' . $entry->author . '  size:' . $entry->size . ' date:' . $entry->date . ' Summary:' . $parsed_log->revision_message[$curRevision] . '</div>';
        $item_value++;
    }


    echo '</div>
  </div>
</div>';


    $divID++;





}

//include 'comment.php';



