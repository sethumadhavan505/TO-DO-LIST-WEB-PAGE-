<?php

//if var is set
if(isset($_POST['title'])){ 
    require '../db_conn.php';

    $title = $_POST['title'];

    if (empty($title)){
        header("Location: ../index.php?mess=error"); //error mex
    } else {
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)"); //add title
        $res = $stmt->execute([$title]);

        if ($res) {
            header("Location: ../index.php?mess=success"); //success mex query
        }else{
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}

?>