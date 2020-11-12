<?php

// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/function.php';

$sql_kind   = '';
$result_msg = '';
$data       = array();
$err_msg    = array();

$sql_kind = get_post_data('sql_kind');

if ($sql_kind === 'insert') {

  $new_name   = '';
  $new_price  = '';
  $new_stock  = '';
  $new_img    = 'no_image.png';
  $new_status = '';

  $new_name = get_post_data('new_name');
  $new_name = trim_space($new_name);

  $new_price = get_post_data('new_price');
  $new_price = trim_space($new_price);

  $new_stock = get_post_data('new_stock');
  $new_stock = trim_space($new_stock);

  $new_status = get_post_data('new_status');

  if ($new_name === '') {
    $err_msg[] = '名前を入力してください。';
  }

  if ($new_price === '') {
    $err_msg[] = '値段を入力してください。';
  } else if (check_number($new_price) !== TRUE ) {
    $err_msg[] = '値段は半角数字を入力してください';
  } else if ($new_price > 10000) {
    $err_msg[] = '値段は1万円以下にしてください';
  }

  if ($new_stock === '') {
    $err_msg[] = '個数を入力してください。';
  } else if (check_number($new_stock) !== TRUE ) {
    $err_msg[] = '個数は半角数字を入力してください';
  }

  if (preg_match('/\A[01]\z/', $new_status) !== 1 ) {
    $err_msg[] = '不正な処理です';
  }

  //  HTTP POST でファイルがアップロードされたか確認
  if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {

    $new_img = $_FILES['new_img']['name'];

    // 画像の拡張子取得
    $extension = pathinfo($new_img, PATHINFO_EXTENSION);

    // 拡張子チェック
    if ($extension === 'jpg' || $extension == 'jpeg' || $extension == 'png') {

      // ユニークID生成し保存ファイルの名前を変更
      $new_img = md5(uniqid(mt_rand(), true)) . '.' . $extension;

      // 同名ファイルが存在するか確認
      if (is_file(IMG_DIR . $new_img) !== TRUE) {

        // ファイルを移動し保存
        if (move_uploaded_file($_FILES['new_img']['tmp_name'], IMG_DIR . $new_img) !== TRUE) {
          $err_msg[] = 'ファイルアップロードに失敗しました';
        }

      } else {
        $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
      }

    } else {
      $err_msg[] = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';
    }

  } else {
    $err_msg[] = 'ファイルを選択してください';
  }

} else if ($sql_kind === 'update') {

  $update_stock = '';
  $item_id     = '';

  $update_stock = get_post_data('update_stock');
  $update_stock = trim_space($update_stock);

  $item_id = get_post_data('item_id');

  if ($update_stock === '') {
    $err_msg[] = '個数を入力してください。';
  } else if (check_number($update_stock) !== TRUE ) {
    $err_msg[] = '個数は半角数字を入力してください';
  }

  if (check_number($item_id) !== TRUE ) {
    $err_msg[] = '不正な処理です';
  }

} else if ($sql_kind === 'change') {

  $change_status = '';
  $item_id      = '';

  $change_status = get_post_data('change_status');
  $item_id      = get_post_data('item_id');

  if (preg_match('/\A[01]\z/', $change_status) !== 1 ) {
    $err_msg[] = '不正な処理です';
  }

  if (check_number($item_id) !== TRUE ) {
    $err_msg[] = '不正な処理です';
  }

}


try {

  $link = get_db_connect();

  if (count($err_msg) === 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {

    // 現在日時を取得
    $now_date = date('Y-m-d H:i:s');

    if ($sql_kind === 'insert') {

      try {
        insert_item_data($link, $new_name, $new_price, $new_stock, $new_img, $new_status, $now_date);
        $result_msg =  '追加成功';

      } catch (PDOException $e) {
        $err_msg[] = '追加失敗';
      }

    } else if ($sql_kind === 'update') {

      try {
        update_item_stock($link, $item_id, $update_stock, $now_date);
        $result_msg = '在庫変更成功';

      } catch (PDOException $e) {
        $err_msg[] = '在庫変更失敗';
      }

    } else if ($sql_kind === 'change') {

      try {
        update_item_master_status($link, $item_id, $change_status, $now_date);
        $result_msg = 'ステータス変更成功';

      } catch (PDOException $e) {
        $err_msg[] = 'ステータス変更失敗';
      }
    }

  }

  $data = get_item_list($link);

  $data = entity_assoc_array($data);

} catch (PDOException $e) {
  $err_msg[] = 'DBエラーです。理由：'.$e->getMessage();
}

// テンプレートファイル読み込み
include_once './view/tool.php';

?>