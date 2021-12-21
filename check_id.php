<?php
    include 'db.inc';
    $id= $_GET["id"];
    $sql= "SELECT * FROM member where id='$id'";
    $result = mysqli_fetch_array(mysqli_query($conn, $sql));

    if(!$result){
        $can = 100;
        echo "<script>alert('[$id] 는 사용 가능한 ID입니다!'); window.location.href='join.php?id=$id&can=$can';</script>";
    } else {
        $can = 200;
        echo "<script>alert('[$id] 는 중복된 ID입니다.'); window.location.href='join.php?id=$id&can=$can';</script>";
    }
?>