<?php
$dsn="mysql:dbname=tb250572db;host=localhost";
$user="tb-250572";
$password="Xhg3h7zutc";
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql ='SHOW TABLES';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[0];
        echo '<br>';
    }
    echo "<hr>";
?>    