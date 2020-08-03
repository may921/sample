<?php
$errors = [];

//DB接続情報
if($_POST){
    $id = null;
    $name = $_POST["name"];
	$contents = $_POST["contents"];
	
	//エラーチェック
	if(!$name) {
		$errors[] .= "名前を入力してください";
	}
	if(!$contents){
        $errors[] .= "投稿内容を入力してください";
	}
	
	if(!$errors){
		date_default_timezone_set('Asia/Tokyo');
		$created_at = date("Y-m-d H:i:s");
		
		//DB接続情報を設定します。
		$pdo = new PDO(
			"mysql:dbname=sample;host=localhost","root","Passw0rd",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
		);
		//ここで「DB接続NG」だった場合、接続情報に誤りがあります。
		if ($pdo) {
			echo "DB接続OK";
		} else {
        echo "DB接続NG";
		}
		//SQLを実行。
		$regist = $pdo->prepare("INSERT INTO post(id, name, contents, created_at) VALUES (:id,:name,:contents,:created_at)");
		$regist->bindParam(":id", $id);
		$regist->bindParam(":name", $name);
		$regist->bindParam(":contents", $contents);
		$regist->bindParam(":created_at", $created_at);
		$regist->execute();
		//ここで「登録失敗」だった場合、SQL文に誤りがあります。
		if ($regist) {
			echo "登録成功";
		} else {
			echo "登録失敗";
		}
	}
}
$pdo = new PDO(
	"mysql:dbname=sample;host=localhost","root","Passw0rd",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
);


//SQL
//$regist = $pdo->prepare("SELECT * FROM post");
$regist = $pdo->prepare("SELECT * FROM post order by created_at DESC limit 20");
$regist->execute();


?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>掲示板サンプル</title>
<h1>掲示板サンプル</h1>
<section>
	<h2>新規投稿</h2>
	<div id="error"><?php foreach($errors as $error){echo $error.'<br>';}?></div>
	<form action="index.php" method="post">
	名前：<input type="text" name="name" value=""><br>
	投稿内容:<input type="text" name="contents" value=""><br>
	<button type="submit">投稿</button>
	</form>
</section>


<section>
	<h2>投稿内容一覧</h2>
		<?php foreach($regist as $loop):?>
			<div>No:<?php echo $loop['id']?></div>
			<div>名前:<?php echo $loop['name']?></div>
			<div>投稿内容:<?php echo $loop['contents']?></div>
			<div>投稿日時:<?php echo $loop['created_at']?></div>
			<div>----------------------------------------</div>
		<?php endforeach;?>
</section>
