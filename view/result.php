<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>自動販売機結果</title>
</head>
<body>
    <h1>自動販売機結果</h1>
<?php if (count($err_msg) === 0) { ?>
        <img src="<?php print IMG_DIR . $data[0]['img']; ?>">
        <p>がしゃん！【<?php print $data[0]['item_name']; ?>】が買えました！</p>
        <p>おつりは【<?php print $change; ?>円】です</p>
<?php } else { ?>
<?php foreach ($err_msg as $value) { ?>
        <p><?php print $value; ?></p>
<?php } ?>
<?php } ?>
    <footer><a href="index.php">戻る</a></footer>
</body>
</html>