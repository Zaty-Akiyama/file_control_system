<?php
$dir = "./archives/";
if( !is_dir( $dir ) || !$handle = opendir( $dir ) ) return;

$item_json = file_get_contents('item.json');
$item_array = json_decode( $item_json, true );

if( empty($_POST['file']) ) return;
$download_file = $_POST['file'];

if( isset($item_array[$download_file]) )
{
  if( empty($_POST['password']) )
  {
    $require_password = array(
      'file' => $download_file,
      'require' => 'password'
    );
    echo json_encode( $require_password );
    exit;
  }else {
    $password = $_POST['password'];
    $verify = password_verify( $password, $item_array[$download_file]['password'] );

    if( !$verify ) return;
  }
}
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="'.$download_file.'"');

readfile($dir . $download_file);
