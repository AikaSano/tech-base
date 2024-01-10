<?php
//DB接続設定.Sano
$dsn = 'mysql:dbname=tb250572db;host=localhost';
$user = 'tb-250572';
$password = 'Xhg3h7zutc';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

// テーブルの内容を表示する
$sql_select = "SELECT * FROM tbm5_1";
$stmt_select = $pdo->query($sql_select);
$results_select = $stmt_select->fetchAll();

// 結果を出力
foreach ($results_select as $row_select) {
    echo "ID: " . $row_select['id'] . "<br>";
    echo "Name: " . $row_select['name'] . "<br>";
    echo "Comment: " . $row_select['comment'] . "<br>";
    echo "Password: " . $row_select['password'] . "<br>";
    echo "<hr>";
}

?>