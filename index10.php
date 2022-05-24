<?php
ini_set('display_errors', 1);
error_reporting(-1);

//データベース関数を使用する
require_once( dirname(__FILE__). '/DbLib.php');
$dbLib = new DbLib();

$users = $dbLib->getUsers();

if (!empty($_POST['inputName']) && is_string($_POST['inputName'])) {
	$dbLib->insertUser($_POST['inputName']);
}

if (!empty($_POST['id'])
 && !empty($_POST['left'])
 && !empty($_POST['top'])
) {
	$dbLib->updateUser($_POST['id'], $_POST['left'], $_POST['top']);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/style10.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
	<title>Document</title>
</head>
<script>
$(function(){
	$('.drag').draggable({       /* class="drag"が指定されている要素をdraggableに */
    containment:'#drag-area',  /* ドラッグできる範囲 */
    cursor:'move',             /* ドラッグ時のカーソル形状 */
    opacity:0.6,               /* ドラッグ中の透明度 */
    scroll:true,               /* ウィンドウ内をスクロールしたい */
    zIndex:10,                 /* ドラッグ中の重ね順を一番上に */
	stop:function(event, ui){
			var myNum = $(this).data('num');
			var myLeft = (ui.offset.left - $('#drag-area').offset().left);
			var myTop = (ui.offset.top - $('#drag-area').offset().top);

			$.ajax({
				type:'POST',
				url:'http://localhost/cbc/index10.php',
				data: {
					id:myNum,
					left:myLeft,
					top:myTop
				}
			}).done(function(){
				console.log('成功');
			}).fail(function(XMLHttpRequest, textStatus, errorThrown){
				console.log(XMLHttpRequest.status);
				console.log(textStatus);
				console.log(errorThrown);
			});
			console.log(myLeft);
			console.log(myTop);
	}
  });
});
</script>
<body>
	<div id="wrapper">
		<div id="input_form">
			<form action="index10.php" method="POST">
				<input type="text" name="inputName">
				<input type="submit" value="登録">
			</form>
		</div>
		<div id="drag-area">
			drag area
			<?php foreach ($users as $user) { ?>
				<div class="drag" data-num="<?php echo $user['id'] ?>" style="left: <?php echo $user['left_X'] ?>px; top: <?php echo $user['top_Y'] ?>px;">
				<p><span class="name"><?php echo $user['id']; echo $user['name'] ?></span></p>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>