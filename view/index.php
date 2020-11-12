<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>自動販売機</title>
    <link type="text/css" rel="stylesheet" href="./css/index.css">
</head>
<body>
<?php if (count($err_msg) === 0) { ?>
    <h1>自動販売機</h1>
    <form action="result.php" method="post">
        <div>金額<input type="text" name="money" value=""></div>
        <div id="flex">
<?php foreach ($data as $value)  { ?>
<?php if ($value['status'] === '1') { ?>
            <div class="item">
                <span class="img_size"><img src="<?php print IMG_DIR . $value['img']; ?>"></span>
                <span><?php print $value['item_name']; ?></span>
                <span><?php print $value['price']; ?>円</span>
<?php if ($value['stock'] > 0) { ?>
                <input type="radio" name="item_id" value="<?php print $value['item_id']; ?>">
<?php } else { ?>
                <span class="red">売り切れ</span>
<?php } ?>
            </div>
<?php } ?>
<?php } ?>
        </div>
        <div id="submit">
            <input type="submit" value="◆ 購入 ◆">
        </div>
    </form>
<?php } else { ?>
<?php foreach ($err_msg as $value) { ?>
        <p><?php print $value; ?></p>
<?php } ?>
<?php } ?>
</body>
</html>