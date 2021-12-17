<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List</title>
</head>
<body>
    <div class=top><h2>리스트</h2></div>
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

            $sql_fav = "SELECT favorite FROM member where id='$id'";
            $res_fav = mysqli_fetch_array(mysqli_query($conn, $sql_fav));
            $my_fav = explode("|", $res_fav['favorite']);

            $sql = "SELECT * FROM daegu";
            $res = mysqli_query($conn, $sql);

            $total_post = mysqli_num_rows($res);
            $per = 10;

            $start = ($page-1)*$per + 1;
            $start -= 1;

            $sql_page = "SELECT * FROM daegu ORDER BY idx ASC limit $start, $per";
            $res_page = mysqli_query($conn, $sql_page);
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
                    <th>즐겨찾기</th>
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
            $total_page = ceil($total_post / $per);
            $page_num = 1;
            
            if($page > 1){
                echo "<a href=\"list.php?page=1\">[처음] </a>";
            }
            while($page_num <= $total_page){
                if($page==$page_num){
                    echo "<a style=\"color:hotpink;\" href=\"list.php?page=$page_num\">$page_num </a>";
                } else {
                    echo "<a href=\"list.php?page=$page_num\">$page_num </a>"; }
                $page_num++;
            }
            if($page < $total_page){
                echo "<a href=\"list.php?page=$total_page\">[끝]</a>";
            }
        ?>
</body>
</html>