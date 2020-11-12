<?php 

// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/function.php';

$data    = array();
$err_msg = array();

try {

  $link = get_db_connect();

  $data = get_item_list($link);

  $data = entity_assoc_array($data);

} catch (PDOException $e) {
  $err_msg[] = 'DBエラーです。理由：'.$e->getMessage();
}

// テンプレートファイル読み込み
include_once './view/index.php';

?>