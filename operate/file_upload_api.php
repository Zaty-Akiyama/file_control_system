<?php

$file = $_FILES['file'];
if( empty($file) ) return;

$file_tmp = $file['tmp_name'];
$file_name = $file['name'];
$return_array = array();

$dir = './archives/';
if ( !is_uploaded_file( $file_tmp ) )
{
  $return_array['error'] = '正しくファイルが選択されていません。';
}else
{
  $file_explode_extension = explode( '.', $file_name );
  $file_first_name = $file_explode_extension[0];
  $file_end_name = str_replace( $file_first_name, '', $file_name );

  $file_sufflx = '';
  $version = '';
  while( file_exists( $dir. $file_first_name . $version . $file_end_name ) )
  {
    $file_sufflx = $file_sufflx === '' ? 1 : $file_sufflx+1;
    $version = $file_sufflx === '' ? '' : "($file_sufflx)";
  }
  $file_path = $dir. $file_first_name . $version . $file_end_name;

  if( !move_uploaded_file( $file_tmp, $file_path ) )
  {
    $return_array['error'] = 'ファイルのアップロードに失敗しました。';
  }
}
$return_array['name'] = $file_name;

if( !isset($return_array['error']) )
{
  $return_array['upload'] = 'success';
}

echo json_encode( $return_array );
