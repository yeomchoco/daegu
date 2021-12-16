<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorite</title>
</head>
<body>
    <div class=top><h2>즐겨찾기</h2></div>
    <button class=no onclick="window.location.href='main.php'">메인으로</button>
    <hr>
       <?php
            $conn = mysqli_connect('localhost', 'choco', '7173', 'jy');
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

            if(mysqli_num_rows($res_page)){ 
        ?>
        <table class=middle>
            <thead>
                <tr align=center>
                    <th>일련번호</th>
                    <th>도면번호</th>
                    <th>구역/사업/단지명</th>
                    <th>위치</th>
                    <th>구역/대지면적</th>
                    <th>예정구역사업유형</th>
                    <th>사업추진단계</th>
                </tr>
            </thead>
        <?php
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
                    <td><input type=button value=삭제 onclick="window.location.href='unfavorite_ok.php?idx=<?=$row['idx']?>';"></td>
                </tr>
            </tbody>
        <?php }
            } else { echo "즐겨찾기에 추가한 사업이 없습니다."; } ?>
        </table>
        <hr>
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