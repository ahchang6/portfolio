<?php

/**
 * Created by PhpStorm.
 * User: ahchang6
 * Date: 3/11/17
 * Time: 7:42 PM
 */
class entry
{
    public $path;
    public $author;
    public $size;
    public $revision;
    public $date;
    public $kind;
    function __construct($entry)
    {
    	$this->kind = (string)$entry['kind'];
    	$this->path = (string)$entry->name;
        $this->author = $entry->commit->author;
        $this->date = $entry->commit->date;
        $this->size = $entry->size;
        $this->revision = $entry->commit['revision'];


    }


}