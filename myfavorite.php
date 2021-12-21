<?php
    session_start();

    if(!isset($_SESSION['id']) || !isset($_SESSION['name'])){
        echo "<script>alert('비회원입니다!');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorite</title>
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
        .info{
            color: red;
        }
    </style>
</head>
<body>
    <h4><a href="main.php" style="color:white;">대구대구</a></h4>
    <div class=res><h2>즐겨찾기</h2></div>
    <div class=align><button class=no onclick="window.location.href='main.php'">메인으로</button>
    <button class=no onclick="window.location.href='list.php'">리스트</button></div>
       <?php
            include 'db.inc';
            $id = $_SESSION['id'];
            
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            
            $pre = "SELECT * FROM member WHERE id='$id'";
            $pre_res = mysqli_fetch_array(mysqli_query($conn, $pre));
            $pre_fav = $pre_res['favorite']; 

            $my_fav = join("','", explode("|", $pre_fav));

            $sql = "SELECT * FROM daegu where idx in ('$my_fav')";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 10;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql_page = "SELECT * FROM daegu where idx in ('$my_fav') ORDER BY idx ASC limit $start, $per";
            $res_page = mysqli_query($conn, $sql_page);

            if($total_post){ 
        ?>
        <table class=list>
            <thead>
                <tr align=center>
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
                    <td><?php echo $row['bunho'];?></td>
                    <td><?php echo $row['domyun'];?></a></td>
                    <td><?php echo $row['guyuck'];?></td>
                    <td><?php echo $row['dong']." ".$row['jibun'];?></td>
                    <td><?php echo $row['myunjuck'];?></td>
                    <td><?php echo $row['yuhyung'];?></td>
                    <td style="color:<?=$dan_color?>;"><?php echo $row['dangye'];?></td>
                    <td><input type=button value=삭제 onclick="window.location.href='unfavorite_ok.php?idx=<?=$row['idx']?>';"></td>
                </tr>
            </tbody>
        <?php }
            } else { echo "<div class=info>즐겨찾기에 추가한 사업이 없습니다.</div>"; } ?>
        </table>
        <?php
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"myfavorite.php?page=1\">[처음] </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"myfavorite.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"myfavorite.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"myfavorite.php?page=$total_page\">[끝]</a>";
            }
        ?>
</body>
</html>