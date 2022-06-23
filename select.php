<?php
//関数を別のファイルから持ってくる
// require_once("funcs.php");
//1.  DB接続します
// try {
//   //Password:MAMP='root'＝ユーザー名,XAMPP=''＝パスワード//XAMPPの初期設定
//   //$pdo = new PDO('mysql:dbname=mil_kadai_db;charset=utf8;host=localhost','root','');
//   $pdo = new PDO('mysql:dbname=isubtle_mil_kadai_db;charset=utf8;host=mysql618.db.sakura.ne.jp','isubtle','inoue12phpdb');
// } catch (PDOException $e) {
//   exit('DBConnection Error:'.$e->getMessage());
// }
include("funcs.php"); 
$pdo = db_conn(); 

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT*FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<a href="detail.php?id='.h($res["id"]).'">';
    $view .=h($res["id"]).":".h($res["indate"])."|".h($res["name"]).",".h($res["url"]).",".h($res["comment"]);
    // $view .=h($res["id"]).",".h($res["name"]);
    // $view .=h($res["id"]).",".h($res["comment"]);
    // $view .=h($res["id"]). "," .h($res["comment"]) ;
    // $view .=h($res["id"]). "," .h($res["name"]). "," .h($res["comment"]) ;
    $view .="</a>";
    $view .= '<a href="delete.php?id='.h($res["id"]).'">';
    $view .= "[削除]<br>";
    $view .= '</a>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマークリスト</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
