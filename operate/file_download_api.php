<?php
$dir = "./archives/";
if( !is_dir( $dir ) || !$handle = opendir( $dir ) ) return;

$item_json = file_get_contents('item.json');
$item_array = json_decode( $item_json, true );

if( empty($_POST['file']) ) return;
$download_file = $_POST['file'];

$require_password = array();

if( isset($item_array[$download_file]) )
{
  if( empty($_POST['password']) )
  {
    $require_password = array(
      'file' => $download_file,
      'require' => 'password',
      'verify' => 'unverified'
    );
  }else {
    $password = $_POST['password'];
    $verify = password_verify( $password, $item_array[$download_file]['password'] );

    if( !$verify ) {
      $require_password = array(
        'file' => $download_file,
        'require' => 'password',
        'verify' => 'false'
      );
    }
  }
}

if( !empty($require_password) )
{
  echo json_encode( $require_password );
  exit;
}
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="'.$download_file.'"');
header('AjaxType: download');

readfile($dir . $download_file);
