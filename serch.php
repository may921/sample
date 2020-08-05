<?php

//検索されたときだけ処理をする
if($_POST){

	$serchText = $_POST["serchText"];


	//DB接続情報を設定します。
	$pdo = new PDO(
		"mysql:dbname=sample;host=localhost","root","Passw0rd",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
	);

	//SQLを実行。
	//$regist = $pdo->prepare("SELECT * FROM post");
	$regist = $pdo->prepare("SELECT * FROM post order by created_at DESC limit 20");

	//SQL文を実行して、結果を$serchResultに代入する。
	$serchResult = $pdo->query("SELECT * FROM post WHERE contents LIKE '%".$_POST["serchText"]."%'"); 
	$regist->execute();



}


?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>投稿内容検索</title>
<h1>投稿内容検索</h1>
<section>
	<h2>検索内容</h2>
	<form action="serch.php" method="post">
	<input type="text" name="serchText" value="<?php echo $_POST['serchText']?>"><br>
	<button type="submit">検索</button>
	</form>
</section>


<section>
	<h2>検索内容一覧</h2>
		<?php foreach($regist as $loop):?>
			<div>No:<?php echo $loop['id']?></div>
			<div>名前:<?php echo $loop['name']?></div>
			<div>投稿内容:<?php echo $loop['contents']?></div>
			<div>投稿日時:<?php echo $loop['created_at']?></div>
			<div>----------------------------------------</div>
		<?php endforeach;?>
</section>
