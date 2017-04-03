<?php

/**
 * Created by PhpStorm.
 * User: ahchang6
 * Date: 3/12/17
 * Time: 5:31 PM
 */
class parsed_log
{
    public $revision_message = array();

    public function __construct($xml_log)
    {
       foreach($xml_log->children() as $log){
           $revision = (string)$log['revision'];
           $message = (string)$log->msg;
           $this->revision_message[$revision] = $message;
       }
    }
}