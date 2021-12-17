<?php
    include 'db.inc';

    $user_id = $_POST['user_id'];
    $user_pw = $_POST['user_pw'];
    $sql = "SELECT * FROM member where id='$user_id' and pw='$user_pw'";
    $res = mysqli_fetch_array(mysqli_query($conn,$sql));
    if($res){
        session_start();
        $_SESSION['id'] = $res['id'];
        $_SESSION['name'] = $res['name'];
        echo "<script>alert('로그인에 성공했습니다!');";
        echo "window.location.replace('main.php');</script>";
        exit;
    }
    else{
       echo "<script>alert('아이디 혹은 비밀번호가 잘못되었습니다.');";
       echo "window.location.replace('login.php');</script>";
    }
?>
<meta http-equiv="refresh" content="0;url=main.php">