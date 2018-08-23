<!DOCTYPE html>
<html lang = "ja">
	<head>
		<meta charset = "UTF-8">
	</head>
	<body>
		<form action = "mission_4-4.php" method = "POST">
<?php
	//ログイン
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);
	//テーブル作成
	$sql= "CREATE TABLE comme"//テーブルの作成
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY," 
	. "name char(32),"
	. "comment TEXT,"
	. "date timestamp not null default current_timestamp,"
	. "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);
?>
<?php
	//ログイン
	$dsn = 'mysql:dbname=tt_272_99sv_coco_com;host=localhost';
	$user = 'tt-272.99sv-coco';
	$password = 'x2Z37agD';
	$pdo = new PDO($dsn,$user,$password);
	//コメント保存処理
	$pass = $_POST['pass'];
	$nam = $_POST['name'];
	$comment = $_POST['comment'];
	$Editing = $_POST['Editing'];
	$line = $_POST['line'];
	$delete = $_POST['delete'];
	if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['pass'])and empty($_POST['Editing']) and empty($_POST['line']) and empty($_POST['delete'])){
		if(ctype_alnum($pass)){
			$sql = $pdo -> prepare("INSERT INTO comme (name, comment,pass) VALUES (:name,:comment,:pass)");//コメント欄書き込み処理
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
			$name = $_POST['name'];
			$comment = $_POST['comment'];
			$pass = $_POST['pass'];
			$sql -> execute();
			$_POST['pass'] ="";
			$_POST['name'] ="";
			$_POST['comment'] ="";
		}else{
		echo'パスワードは英数字以外入力できません';//6に向けた準備
		}
	}
	//編集保存
	if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['pass'])and empty($_POST['Editing']) and !empty($_POST['line'])and empty($_POST['delete'])){
	$id = $_POST['line'];
	$nm = $_POST['name'];
	$kome = $_POST['comment'];
	$pas = $_POST['pass'];
	$date = date("Y/m/d H:i:s");
	$sql = "update comme set name='$nm' , comment='$kome',pass ='$pas',date ='$date' where id = $id";
	$result = $pdo->query($sql);
	$_POST['pass'] ="";
	$_POST['name'] ="";
	$_POST['comment'] ="";
	$_POST['line'] ="";
	}
	//編集表示
	if(empty($_POST['name']) and empty($_POST['comment']) and !empty($_POST['pass'])and !empty($_POST['Editing']) and empty($_POST['line'])and empty($_POST['delete'])){
	$sql = 'SELECT * FROM comme';//初期から使っているコメント欄
	$results = $pdo -> query($sql);
	foreach ($results as $row){
		if($row['id'] == "$Editing" and $row['pass'] =="$pass"){
			$_POST['line'] =$row['id'];
			$_POST['name'] =$row['name'];
			$_POST['comment'] =$row['comment'];
			$_POST['pass'] =$row['pass'];
			}
		}
	}
?>
			<!--名前入力用-->
			<p>投稿</p>
			<p><input type = "text" name ="name" value = "<?=$_POST['name'];?>"placeholder ="名前" ></p>
			<!--コメント入力用-->
			<p><input type = "text" name ="comment" value = "<?=$_POST['comment'];?>" placeholder ="コメント" ></p>
			<input type = "hidden" name = "line" value = "<?=$_POST['line'];?>">
			<p><input type = "text" name ="delete" placeholder ="削除対象番号"></p>
			<p><input type = "text" name ="Editing"placeholder ="編集対象番号" ></p>
			<p><input type = "text" name = "pass" value = "<?=$_POST['pass'];?>"placeholder ="パスワード">
			<!--送信ボタン-->
			<input type = "submit" value ="送信"></p>
			<!--削除入力-->
			<!--<p>削除対象番号</p>-->
			<!--<input type = "submit" value ="削除" ></p>-->
			<!--<p>編集対象番号</p>>-->
			<!--<input type = "submit" value ="編集" ></p>-->
			<!--<p>新規アカウント作成</p>
			<p><input type = "text" name ="myuser"placeholder ="新規アカウント作成" ></p>
			<p><input type = "text" name = "passe" placeholder ="パスワード">
			<input type = "submit" value ="編集" ></p>-->
		</form>
<?php
	//ログイン
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);
	//変数
	$pass = $_POST['pass'];
	$nam = $_POST['name'];
	$comment = $_POST['comment'];
	$Editing = $_POST['Editing'];
	$line = $_POST['line'];
	$delete = $_POST['delete'];
	//削除処理
	if(empty($_POST['name']) and empty($_POST['comment']) and !empty($_POST['pass'])and empty($_POST['Editing']) and empty($_POST['line'])and !empty($_POST['delete'])){
	$sql = "delete from comme where id=$delete and pass = $pass";
	$result = $pdo->query($sql);
	}
	//DB内のデータ表示
	$sql = 'select id, name, comment,date from comme ORDER BY id';//初期から使っているコメント欄
	$results = $pdo -> query($sql);
	echo "旧式コメント欄<br>";
	foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	}
	echo "<br>------------------------<br>";//ここより試験的に導入しているコメント欄
	echo 'リニューアル後コメント欄';
	$sql = 'select id, name, comment,date from comme ORDER BY id';//ORDER BY を入れることにより昇順に表示されるようにしている。
	$stmt = $pdo->query($sql);
	echo "<table>\n";
	echo "\t<tr><th>id</th><th>name</th><th>comment</th><th>date</th></tr>\n";
	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	    echo "\t<tr>\n";
	    echo "\t\t<td>{$result['id']}</td>\n";
	    echo "\t\t<td>{$result['name']}</td>\n";
	    echo "\t\t<td>{$result['comment']}</td>\n";
	    echo "\t\t<td>{$result['date']}</td>\n";
	    echo "\t</tr>\n";
	}
	echo "</table>\n";
	echo "<br>------------------------<br>";//新規コメント欄
?>
	</body>
</html>
