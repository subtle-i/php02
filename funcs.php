<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function db_conn(){
    try{
       //localhostの場合
       $db_name = "mil_kadai_db";    //データベース名
       $db_id   = "root";      //アカウント名
       $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
       $db_host = "localhost"; //DBホスト

       //localhost以外＊＊自分で書き直してください！！＊＊
       if($_SERVER["HTTP_HOST"] != 'localhost'){
           $db_name = "isubtle_mil_kadai_db";  //データベース名
           $db_id   = "isubtle";  //アカウント名（さくらコントロールパネルに表示されています）
           $db_pw   = "inoue12phpdb";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
           $db_host = "mysql618.db.sakura.ne.jp"; //例）mysql**db.ne.jp...
       }
       return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
   } catch (PDOException $e) {
       exit('DB Connection Error:'.$e->getMessage()); 
    }
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError: ".$error[2]);
}
 
//リダイレクト関数: redirect($file_name)
//：の後の半角スペース必須
function redirect($file_name){
    header("Location: " .$file_name);
    exit();
}
