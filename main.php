<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main</title>
    <style>
        h1{
            text-align: center;
            color:blueviolet;
            margin:25px;
            margin-top:50px;
        }
        a{
            text-decoration: none;
            text-align: center;
            color:black;
        }
        ul{
            /*margin:20px;*/
            margin:10%;
            padding-left:20%;
        }
        li{
            margin:20px;
            font-style: italic;
            font-size: large;
        }
        p{
            text-align: center;
        }
        button{
            margin:10px;
        }
    </style>
</head>
<body>
    <h1>대구대구</h1>
    <p>
        <ul>
            <li><a href="list.php">정비구역 리스트</a></li>
            <li><a href="myfavorite.php">즐겨찾기</a></li>
        </ul>
    </p>
    <?php
        if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
            echo "<p><button onclick=\"window.location.href='login.php'\">로그인</button> <button onclick=\"window.location.href='join.php'\">회원가입</button></p>";
        } else {
            $user_id = $_SESSION['id'];
            $user_name = $_SESSION['name'];
            echo "<p>$user_name($user_id)님 환영합니다.";
            echo "<p><button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        }
    ?>
</body>
</html>