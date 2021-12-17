<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Join</title>
        <script>
            function check_id(){
                var userid = document.getElementById("id").value;
                if(userid)
                {
                    url = "check.php?userid="+userid;
                    window.open(url,"check","width=400,height=200");
                } else {
                    alert("아이디를 입력하세요.");
                }
            }
            function decide(){
                document.getElementById("decide").innerHTML = "<span style='color:blue;'>사용 가능한 ID입니다.</span>"
                document.getElementById("decide_id").value = document.getElementById("id").value
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
        </script>
    </head>
    <body>
        <h2>회원가입</h2>
        <?php if(!isset($_SESSION['id']) || !isset($_SESSION['name'])) { ?>
        <form id="join_form" method="post" action="join_ok.php" autocomplete="off">
            <p>아이디: <input type="text" name="join_id" id="id" autofocus></p>
            <input type="hidden" name="decide_id" id="decide_id">
            <p><span id="decide" style='color:red;'>ID 중복 여부를 확인해주세요.</span>
            <input type="button" id="check_button" value="ID 중복 검사" onclick="check_id();"></p>
            <p>비밀번호: <input type="password" name="join_pw" id="pw"></p>
            <p>비밀번호 확인: <input type="password" name="join_pw2" id="pw2"></p>
            <p>이름: <input type="text" name="join_name" id="name"></p>
            <p>연락처: <input type="text" name="join_phone"></p>
            <p>Email: <input type="email" name="join_email"></p>
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