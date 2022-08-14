<?php
$dir = "./archives/";
if( !is_dir( $dir ) || !$handle = opendir( $dir ) ) return;

$item_json = file_get_contents('item.json');
$item_array = json_decode( $item_json, true );

if( empty($_POST['file']) ) return;
$remove_file = $_POST['file'];

$require_password = array();
if( isset($item_array[$remove_file]) )
{
  if( empty($_POST['password']) )
  {
    $require_password = array(
      'file' => $remove_file,
      'require' => 'password',
      'verify' => 'unverified'
    );
  }else {
    $password = $_POST['password'];
    $verify = password_verify( $password, $item_array[$remove_file]['password'] );

    if( !$verify ) {
      $require_password = array(
        'file' => $remove_file,
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

$return_text_array['result'] = $remove_file . 'の削除に';
$return_text_array['result'] .= unlink($dir . $remove_file) ? '成功しました' : '失敗しました';

echo json_encode( $return_text_array );