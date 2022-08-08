<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header("Content-type: application/json; charset=UTF-8");

if( empty($_POST['operate']) ) return;
$operate = $_POST['operate'];

switch( $operate )
{
  case 'fetch' : 
    include_once('./operate/file_fetch_api.php');
    exit;

  case 'download' : 
    include_once('./operate/file_download_api.php');
    exit;
}
