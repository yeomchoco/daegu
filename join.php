<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Join</title>
        <script>
            function check_id(){
                var id = document.getElementById("id").value
                window.location.href='check_id.php?id='+id
            }
            function decide(id){
                document.getElementById("decide").innerHTML = "<span style='color:blue;'>사용 가능한 ID입니다.</span>"
                document.getElementById("decide_id").value = id
                document.getElementById("id").value = id
                document.getElementById("id").disabled = true
                document.getElementById("join_button").disabled = false
                document.getElementById("check_button").value = "다른 ID로 변경"
                document.getElementById("check_button").setAttribute("onclick", "change()")
            }
            function change(){
                document.getElementById("decide").innerHTML = "<span style='color:red;'>ID 중복 여부를 확인해주세요.</span>"
                document.getElementById("id").disabled = false
                document.getElementById("id").value = ""
                document.getElementById("join_button").disabled = true
                document.getElementById("check_button").value = "ID 중복 검사"
                document.getElementById("check_button").setAttribute("onclick", "check_id()")
                join_form = document.getElementById("join_form")
                join_form.elements[0].focus();
            }
            function check_pw(){
                var pw = document.getElementById("pw").value
                var pw2 = document.getElementById("pw2").value
                var name = document.getElementById("name").value
                join_form = document.getElementById("join_form")
                if(!pw){
                    window.alert("비밀번호를 입력해주세요!")
                    join_form.elements[3].focus();
                }else{
                    if(pw==pw2){
                        if(name){
                            join_form.submit();
                        }else{
                            window.alert("이름을 입력해주세요!")
                            join_form.elements[5].focus();
                        }
                    }else{
                        window.alert("비밀번호가 일치하지 않습니다!")
                        document.getElementById("pw2").value = ""
                        join_form.elements[4].focus();
                    }
                }
            }
        </script>
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
            input[type="button"]{
                border:none;
                border-radius:8px;
                background-color:purple;
                color:white;
                font-weight:500;
                padding: 4px 8px;
            }
            input[type="button"]:disabled{
                background-color:#D3C9E8;
                color:white;
                font-weight:500;
                padding: 4px 8px;
            }
        </style>
    </head>
    <body>
        <h4><a href="main.php" style="color:white;">대구대구</a></h4>
        <h2>회원가입</h2>
        <?php if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) { ?>
        <form id="join_form" method="post" action="join_ok.php" autocomplete="off">
            <p>✔️ ID <input type="text" name="join_id" id="id" value="<?=$decide?>" autofocus></p>
            <input type="hidden" name="decide_id" id="decide_id">
            <p><span id="decide" style='color:red;'>ID 중복 여부를 확인해주세요.</span>
            <input type="button" id="check_button" value="ID 중복 검사" onclick="check_id();"></p>
            <p>✔️ PW <input type="password" name="join_pw" id="pw"></p>
            <p>✔️ PW 확인 <input type="password" name="join_pw2" id="pw2"></p>
            <p>✔️ 이름 <input type="text" name="join_name" id="name"></p>
            <p>연락처 <input type="text" name="join_phone"></p>
            <p>Email <input type="email" name="join_email"></p>
            <p><input type="button" value="가입하기" id="join_button" onclick="check_pw();" disabled=true></p>
        </form>
        <small><a href="login.php">이미 회원이신가요?</a><small>
        <?php } else {
                $user_id = $_SESSION['id'];
                $user_name = $_SESSION['name'];
                echo "<p>$user_name($user_id)님은 이미 로그인되어 있습니다.";
                echo "<p><button onclick=\"window.location.href='main.php'\">메인으로</button> <button onclick=\"window.location.href='logout.php'\">로그아웃</button></p>";
        } ?>
    </body>
</html>
<?php
    $id = $_GET['id'];
    $can = $_GET['can'];
    
    if($can==100){
        $decide = $id;
        echo "<script>decide('$decide');</script>";
    }elseif($can==200){
        $decide = "";
    }
?>