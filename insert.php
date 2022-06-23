<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name=$_POST['name'];
$url=$_POST['url'];
$comment=$_POST['comment'];


//2. DB接続します
// try {
//   //Password:MAMP='root'＝ユーザー名,XAMPP=''＝パスワード//XAMPPの初期設定
//   $pdo = new PDO('mysql:dbname=isubtle_mil_kadai_db;charset=utf8;host=mysql618.db.sakura.ne.jp','isubtle','inoue12phpdb');
//   //$pdo = new PDO('mysql:dbname=mil_kadai_db;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
//   exit('DBConnection Error:'.$e->getMessage());
// }
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
//．で文字列をつなぐと、脆弱性がある。→置き換えたい箇所はbindvalueを使う。stmt=statement
$stmt = $pdo->prepare("insert into gs_bm_table(name,url,comment,indate) values(:name,:url,:comment,sysdate())");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  //：の後の半角スペースはマスト
  header("Location: index.php");
  exit();
}
?>
