<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <style>
            @font-face {
                font-family: 'IM_Hyemin-Bold';
                src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2106@1.1/IM_Hyemin-Bold.woff2') format('woff');
                font-weight: normal;
                font-style: normal;
            }
            * {
                font-family: 'IM_Hyemin-Bold';
            }
            h4{
                background-color:blueviolet;
                color:white;
                text-align:right;
                padding:2%;
            }
            h2{
                display:inline;
                margin-right:10px;
            }
            .res{
                margin-bottom:14px;
            }
            a{
                text-decoration: none;
                color:black;
            }
            button{
                border:none;
                border-radius:8px;
                background-color:blueviolet;
                color:white;
                font-weight:500;
                padding: 2px 6px;
            }
            input[type="submit"]{
                border:none;
                border-radius:8px;
                background-color:purple;
                color:white;
                font-weight:500;
                padding: 4px 8px;
            }
        </style>
    </head>
    <body>
        <h4><a href="main.php" style="color:white;">대구대구</a></h4>
        <div class=res><h2>로그인</h2></div>
        <?php if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) { ?>
        <form method="post" action="login_ok.php" autocomplete="off">
            <p>ID <input type="text" name="user_id" required autofocus></p>
            <p>PW <input type="password" name="user_pw" required></p>
            <p><input type="submit" value="로그인"></p>
        </form>
        <small><a href="join.php">처음 오셨나요?</a><small>
        <?php } else {
            $user_id = $_SESSION['id'];
            $user_name = $_SESSION['name'];
            echo "<p>$user_name($user_id)님은 이미 로그인되어 있습니다.";
            echo "<p><button onclick=\"window.location.href='main.php'\">메인으로</button> <button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        } ?>
    </body>
</html>