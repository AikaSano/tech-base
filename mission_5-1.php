<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <?php
        //データベースへ接続
        $dsn = 'mysql:dbname=データベース名;host=localhost';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //データベース内にテーブルを作成
        $sql = "CREATE TABLE IF NOT EXISTS tbm5_1"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "comment TEXT,"
        . "password TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
        //passwordのカラムが存在しないことになっているため、追加する
        $sql_check_password_column = "SHOW COLUMNS FROM tbm5_1 LIKE 'password';";
        $stmt_check_password_column = $pdo->query($sql_check_password_column);
        $existing_password_column = $stmt_check_password_column->fetch();
        if (!$existing_password_column) {
        $sql_add_password_column = "ALTER TABLE tbm5_1 ADD COLUMN password TEXT;";
        $pdo->exec($sql_add_password_column);
        }

        // テーブルの構造詳細
        // $sql ='SHOW CREATE TABLE tbm5_1';
        // $result = $pdo -> query($sql);
        // foreach ($result as $row){
        //     echo $row[1];
        // }
        // echo "<hr>";
         
        if(!empty($_POST["name"])){
              $name=$_POST["name"];
          }
           if(!empty($_POST["comment"])){
              $comment=$_POST["comment"];
          }
          if(!empty($_POST["password"])){
              $password=$_POST["password"];
          }
        $date=date("Y年m月d日　H時i分s秒");
       
        //投稿機能と編集機能（テーブルデータの編集したい行を差し替える）
       if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["password"])){
        if(empty($_POST["edit_number"])){ 
            $sql = "INSERT INTO tbm5_1 (name, comment, password) VALUES (:name, :comment, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
        }else{
            $edit_num=$_POST["edit_number"];
            $edit_name=$_POST["name"];
            $edit_comment=$_POST["comment"];
            $sql = 'UPDATE tbm5_1 SET name=:name,comment=:comment,password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $edit_name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $edit_comment, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $edit_num, PDO::PARAM_INT);
            $stmt->execute();
            }
        }

        //削除機能
        if(!empty($_POST["delete_num"])&&isset($_POST["delete_num"])&&!empty($_POST["delete_password"])){
            $delete_num=$_POST["delete_num"];
            $delete_password=$_POST["delete_password"];
            $sql_check_password="SELECT * FROM tbm5_1 WHERE id=:id AND password=:password";
            $stmt_check_password=$pdo->prepare($sql_check_password);
            $stmt_check_password->bindParam(':id', $delete_num, PDO::PARAM_INT);
            $stmt_check_password->bindParam(':password', $delete_password, PDO::PARAM_STR);
            $stmt_check_password->execute();
            $password_matched=$stmt_check_password->fetch();
            if($password_matched){
              $sql_delete='DELETE FROM tbm5_1 WHERE id=:id';
              $stmt_delete=$pdo->prepare($sql_delete);
              $stmt_delete->bindParam(':id', $delete_num, PDO::PARAM_INT);
              $stmt_delete->execute();
            }
        } 
             
        //編集機能（edit_numberの欄に編集したい投稿を表示させる）
        $edit_name="";
        $edit_comment="";
        if(!empty($_POST["edit_num"])&&isset($_POST["edit_num"])&&!empty($_POST["edit_password"])){
            $edit_num=$_POST["edit_num"];
             $edit_password=$_POST["edit_password"];
             $sql = 'SELECT * FROM tbm5_1';
             $stmt = $pdo->query($sql);
             $results = $stmt->fetchAll();
             foreach ($results as $row){
                if($edit_num==$row['id']){
                    if($edit_password==$row['password']){
                    $edit_name=$row['name'];
                    $edit_comment=$row['comment'];
                    }
                }
            }
        }
         ?>

        <form action="" method="post" >
        <input type="text" name="name" placeholder="名前" value="<?php if(!empty($_POST["edit_num"])){echo $edit_name;}?>">
        <input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($_POST["edit_num"])){echo $edit_comment;}?>">
        <input type="password" name="password" placeholder="パスワードを入力">    
        <input type="hidden" name="edit_number" value="<?php if(!empty($_POST["edit_num"])&&($row['id']==$edit_num)){echo $edit_num;}?>" readonly>
        <input type="submit" name="submit" value="送信"><br>
        <input type="text" name="delete_num" placeholder="削除対象番号">
        <input type="password" name="delete_password" placeholder="パスワードを入力"> 
        <input type="submit" name="delete" value="削除"><br>
        <input type="number" name="edit_num" placeholder="編集対象番号">
        <input type="password" name="edit_password" placeholder="パスワードを入力"> 
        <input type="submit" name="edit" value="編集"> 
        </form>
       
       <?php
        //ブラウザ上に表示
        $sql = 'SELECT * FROM tbm5_1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
            echo "<hr>";
        }
        ?>
    </body>
</html>