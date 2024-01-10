<?php
$dsn="mysql:dbname=tb250572db;host=localhost";
$user="tb-250572";
$password="Xhg3h7zutc";
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$name = 'sakai';
    $comment = 'GMN'; 

    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
?>    