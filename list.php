<?php
    include 'db.inc';
    session_start();

    if(!isset($_SESSION['id']) || !isset($_SESSION['name'])){
        echo "<script>alert('비회원입니다!');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }

    $conn = mysqli_connect('localhost', 'choco', '7173', 'jy');
    $id = $_SESSION['id'];
    $modified = 0;

    if(isset($_GET['align_cate'])){
        $align_cate = $_GET['align_cate'];
        if($align_cate!="idx"){
            $modified += 1;
        }
    } else {
        $align_cate = "idx";
    }

    if(isset($_GET['align_by'])){
        $align_by = $_GET['align_by'];
        if($align_by!="asc"){
            $modified += 1;
        }
    } else {
        $align_by = "asc";
    }

    switch($align_cate){
        case "idx":
            $al = "식별자";
            break;
        case "bunho":
            $al = "일련번호";
            break;
        case "myunjuck":
            $al = "구역/대지면적";
            break;
        case "dangye":
            $al = "사업추진단계";
            break;
    }

    switch($align_by){
        case "asc":
            $by = "오름차순";
            break;
        case "desc":
            $by = "내림차순";
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List</title>
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
            padding: 2px 6px;
        }
        input[type="button"]{
            border:none;
            border-radius:8px;
            background-color:blueviolet;
            color:white;
            font-weight:500;
            padding: 2px 6px;
        }
        table.list{
            margin-top: 6px;
            margin-bottom: 6px;
            border-collapse:separate;
            border-spacing:2px;
            background: #f8f8f8;
        }
        table.list th{
            background: #EDC9FF;
        }
        .align{
            margin-top: 6px;
            margin-bottom: 6px;
        }
        .form{
            margin-top: 3px;
        }
        .info{
            margin-top: 6px;
        }
    </style>
    <script>
        function info() {
            var opt = document.getElementById("search_opt");
            var opt_val = opt.options[opt.selectedIndex].value;
            var info = ""
            if (opt_val=='guyuck'){
                info = "구역/사업/단지명을 입력하세요.";
            } else if (opt_val=='where'){
                info = "위치를 입력하세요.";
            } else if (opt_val=='yuhyung'){
                info = "예정구역사업유형을 입력하세요.";
            }
            document.getElementById("search_box").placeholder = info;
        }
    </script>
</head>
<body>
    <h4><a href="main.php" style="color:white;">대구대구</a></h4>
    <div class=res><h2>리스트</h2></div>
    <div class="align"><button onclick="window.location.href='main.php'">메인으로</button>
    <button onclick="window.location.href='myfavorite.php'">즐겨찾기</button></div>
    <form method="get" action="list.php">
        <select name="align_cate">
            <option value="idx">식별자</option>
            <option value="bunho">일련번호</option>
            <option value="myunjuck">구역/대지면적</option>
            <option value="dangye">사업추진단계</option>
        </select>
        <select name="align_by">
            <option value="asc">오름차순</option>
            <option value="desc">내림차순</option>
        </select>
        <input type=submit value=검색>
    </form>
<?php
    if($modified != 0){ ?>
        <div class="info" style="color:red;"><?=$al?> 기준 <?=$by?> 정렬되었습니다.</div>
<?php } ?>
       <?php
            $id = $_SESSION['id'];
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql_fav = "SELECT favorite FROM member where id='$id'";
            $res_fav = mysqli_fetch_array(mysqli_query($conn, $sql_fav));
            $my_fav = explode("|", $res_fav['favorite']);

            $sql = "SELECT * FROM daegu";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 10;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql_page = "SELECT * FROM daegu ORDER BY $align_cate $align_by limit $start, $per";
            $res_page = mysqli_query($conn, $sql_page);
        ?>
        <table class="list">
            <thead>
                <tr align=center>
                    <th>식별자</th>
                    <th>일련번호</th>
                    <th>도면번호</th>
                    <th>구역/사업/단지명</th>
                    <th>위치</th>
                    <th>구역/대지면적</th>
                    <th>예정구역사업유형</th>
                    <th>사업추진단계</th>
                    <th>💜</th>
                </tr>
            </thead>
        <?php
            while($row = mysqli_fetch_array($res_page)){
                $dan = explode(" ", $row['dangye'])[0];
                switch($dan){
                    case "07":
                        $dan_color = "#de3ab2";
                        break;
                    case "06":
                        $dan_color = "#cc402b";
                        break;
                    case "05":
                        $dan_color = "#fabc41";
                        break;
                    case "04":
                        $dan_color = "#d6d631";
                        break;
                    case "03":
                        $dan_color = "#1dd153";
                        break;
                    case "02":
                        $dan_color = "#2796d6";
                        break;
                    case "01":
                        $dan_color = "#185ec7";
                        break;
                }
        ?>
            <tbody>
                <tr align=center>
                    <td><?php echo $row['idx'];?></td>
                    <td><?php echo $row['bunho'];?></td>
                    <td><?php echo $row['domyun'];?></a></td>
                    <td><?php echo $row['guyuck'];?></td>
                    <td><?php echo $row['dong']." ".$row['jibun'];?></td>
                    <td><?php echo $row['myunjuck'];?></td>
                    <td><?php echo $row['yuhyung'];?></td>
                    <td style="color:<?=$dan_color?>;"><?php echo $row['dangye'];?></td>
                    <td><?php
                            if(in_array($row['idx'], $my_fav)){ ?>
                                <input type=button value=삭제 onclick="window.location.href='unfavorite_ok.php?idx=<?=$row['idx']?>';">
                        <?php }else{ ?>
                                <input type=button value=즐겨찾기 onclick="window.location.href='favorite_ok.php?idx=<?=$row['idx']?>';">
                        <?php } ?>
                        </td>
                </tr>
            </tbody>
        <?php } ?>
        </table>
        <?php
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"list.php?page=1&align_cate=$align_cate&align_by=$align_by&modified=$modified\">[처음] </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"list.php?page=$page_num&align_cate=$align_cate&align_by=$align_by&modified=$modified\">$page_num </a>";
                } else {
                    echo "<a href=\"list.php?page=$page_num&align_cate=$align_cate&align_by=$align_by&modified=$modified\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"list.php?page=$total_page&align_cate=$align_cate&align_by=$align_by&modified=$modified\">[끝]</a>";
            }
        ?>
        <form class="form" method="get" action="search.php">
            <select name="cate" id="search_opt" onchange="info()">
                    <option value=guyuck>구역/사업/단지명</option>
                    <option value=where>위치</option>
                    <option value=yuhyung>예정구역사업유형</option>
            </select>
            <input type=text name=search id="search_box" autocomplete="off" placeholder="구역/사업/단지명을 입력하세요." required>
            <input type=submit value=검색>
        </form>
</body>
</html>