<?php
$dir = "./archives/" ;
if( !is_dir( $dir ) || !$handle = opendir( $dir ) ) return;

$files = array();
$item_json = file_get_contents('item.json');
$item_array = json_decode($item_json, true);
while( ($file = readdir($handle)) !== false ) {
  if( $file === '.htaccess' ) continue;
  if( filetype( $path = $dir . $file ) == "file" ) {
    $time = isset($item_array[$file]) ? $item_array[$file]['time'] : '';
    $files[] = array(
      'name' => $file,
      'time' => $time
    );
  }
}
echo json_encode($files);
