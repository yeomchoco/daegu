<?php
    include 'db.inc';
    session_start();
    

    $id = $_SESSION['id'];
    $idx = $_GET['idx'];

    $pre = "SELECT * FROM member WHERE id='$id'";
    $pre_res = mysqli_fetch_array(mysqli_query($conn, $pre));
    $pre_fav = $pre_res['favorite'];

    $my_fav = explode("|", $pre_fav);

    if(in_array($idx, $my_fav)){
        $index = array_search("$idx", $my_fav);
        unset($my_fav[$index]);
        $new_fav = implode("|",$my_fav);
    }

    $sql = "UPDATE member SET favorite='$new_fav' where id='$id'";
    $res = mysqli_query($conn, $sql);

    if($res){
        echo "<script>alert('즐겨찾기가 삭제되었습니다!');</script>";
    }else{
        echo "<script>alert('모종의 이유로 실패함;');</script>";
    }

    echo "<script>history.back();</script>";
    exit;
?>