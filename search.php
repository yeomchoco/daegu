<?php
    include 'db.inc';
    session_start();
    

    $cate = $_GET['cate'];
    $search = $_GET['search'];

    switch($cate){
        case "bunho":
            $ct = "일련번호";
            break;
        case "guyuck":
            $ct = "구역/사업/단지명";
            break;
        case "where":
            $ct = "위치";
            break;
    }

    $last = iconv_substr($search, -1, 1, "utf-8");
    $dec = substr(mb_convert_encoding($last,'HTML-ENTITIES','UTF-8'),2,-1);
    $nums = array("3","6","0");

    if($dec>=44032 && $dec<=55203){
        if(($dec-0xAC00)%28!=0){
            $josa = "으로";
        }else{
            $josa = "로";
        }
    }elseif(in_array($last, $nums)){
        $josa = "으로";
    }else{
        $josa = "로";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="deco.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <script>
        function info() {
            var opt = document.getElementById("search_opt");
            var opt_val = opt.options[opt.selectedIndex].value;
            var info = ""
            if (opt_val=='bunho'){
                info = "일련번호를 입력하세요.";
            } else if (opt_val=='guyuck'){
                info = "구역/사업/단지명을 입력하세요.";
            } else if (opt_val=='where'){
                info = "위치를 입력하세요.";
            }
            document.getElementById("search_box").placeholder = info;
        }
    </script>
</head>
<h2>[<?=$ct?> : <?=$search?>] <?=$josa?> 검색했습니다.</h2>
<button onclick="window.location.href='main.php'">메인으로</button>
<hr>
<body>
    <table>
        <thead>
                <tr align=center>
                    <th>일련번호</th>
                    <th>도면번호</th>
                    <th>구역/사업/단지명</th>
                    <th>위치</th>
                    <th>구역/대지면적</th>
                    <th>예정구역사업유형</th>
                    <th>사업추진단계</th>
                    <th>즐겨찾기</th>
                </tr>
        </thead>
        <?php
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $sql = "SELECT * FROM daegu WHERE $cate LIKE '%$search%'";
            
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 10;

            $start = ($page-1)*$per;
        
            //일련번호, 구역, 위치 나눠서 검색해줘야함. 위치는 동,지번으로 파싱해서 ㅎ;

            $sql_page = "SELECT * FROM daegu WHERE $cate LIKE '%$search%' ORDER BY idx ASC limit $start, $per";

            $res_page = mysqli_query($conn, $sql_page);

            while($row = mysqli_fetch_array($res_page)){
        ?>
            <tbody>
                <tr align=center>
                    <td><?php echo $row['bunho'];?></td>
                    <td><?php echo $row['domyun'];?></a></td>
                    <td><?php echo $row['guyuck'];?></td>
                    <td><?php echo $row['dong']." ".$row['jibun'];?></td>
                    <td><?php echo $row['myunjuck'];?></td>
                    <td><?php echo $row['yuhyung'];?></td>
                    <td><?php echo $row['dangye'];?></td>
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
    <hr>
    <?php
        if($page > 1){
            echo "<a href=\"search.php?page=1&cate=$cate&search=$search\">[처음] </a>";
        }
        if($page > 1){
            $pre = $page - 1;
            echo "<a href=\"search.php?page=$pre&cate=$cate&search=$search\">이전 </a>";
        }
        $total_page = ceil($total_post / $per);
        $page_num = 1;
        while($page_num <= $total_page){
            if($page==$page_num){
                echo "<a style=\"color:hotpink;\" href=\"search.php?page=$page_num&cate=$cate&search=$search\">$page_num </a>";
            } else {
            echo "<a href=\"search.php?page=$page_num&cate=$cate&search=$search\">$page_num </a>"; }
            $page_num++;
        }
        if($page < $total_page){
            $next = $page + 1;
            echo "<a href=\"search.php?page=$next&cate=$cate&search=$search\">다음 </a>";
        }
        if($page < $total_page){
            echo "<a href=\"search.php?page=$total_page&cate=$cate&search=$search\">[끝]</a>";
        }
    ?>
    </div>
    <div class=search>
    <form method="get" action="search.php">
        <select name="cate" id="search_opt" onchange="info()">
                <option value=bunho>일련번호</option>
                <option value=guyuck>구역/사업/단지명</option>
                <option value=where>위치</option>
        </select>
        <input type=text name=search id="search_box" autocomplete="off" value="<?=$search?>" placeholder="일련번호를 입력하세요." required>
        <input type=submit value=검색>
    </form>
    </div>
</body>
</html>