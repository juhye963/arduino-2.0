<?php
require_once("db_conn.php");
$pdo = DB_conn();

#페이징
##전체 데이터 수 count
try
{   
    $cnt_sql = "SELECT count(id) as total FROM temp_tb";
    $cnt_stmh=$pdo->prepare($cnt_sql);
    $cnt_stmh->execute();
}
catch(PDOException $e)
{   print 'err: '. $e->getMessage();   }


##페이징 구현 변수
$cnt_row=$cnt_stmh->fetch(PDO::FETCH_ASSOC);
$total = $cnt_row['total']; //전체데이터수
$page = 1; //현재페이지 넣는 변수. default 1
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
$list = 10; //페이지당 데이터수
$block = 5; //한 블록당 페이지 수

$total_page = ceil($total/$list); 
//총 페이지 수 = 전체유저수를 페이지당 데이터수로 나누면 나옴(소수점은 의미 없 = 반올림)
$total_block = ceil($total_page/$block); //총 블록 수 = 총 페이지수 / 한블록당 페이지수
$nowBlock = ceil($page/$block); //현재블록 =현재페이지/한 블록당 페이지수 ->반올림

$s_page = ($nowBlock*$block)-($block-1); //블록에서 시작페이지
if($s_page <= 1){
    $s_page = 1;
}
$e_page=$nowBlock*$block; //블록에서 마지막페이지
if($total_page<=$e_page){
    $e_page=$total_page;
}

// 쿼리문에서 시작포인트부터 $list(페이지당 데이터수)만큼 읽어오면 한 페이지에 뿌릴 데이터만 갖고옴
$s_point = ($page-1)*$list; 

$prev_page = $page-1;//[prev] 버튼(이전페이지)
if($prev_page<=0){ 
    $prev_page = 1;
} //이전페이지가 0보다 작다면 1 할당

$next_page = $page+1; // 다음페이지 [next]버튼
if($next_page >= $total_page){
    $next_page = $total_page;
}//다음페이지가 총 페이지수보다 크다면 총페이지수 할당



?>


<html>
<head>
<title>온도</title>
<meta http-equiv="content-type" content="txt/html" ; charset="utf-8">
</head>
<body text-align="center">
<h1>온도 리스트</h1>
<h4>총 데이터 수 <?=$total?></h4> 
<table width='500' border='1'>
<tr>
<th align='center'>온도</th>
<th align='center'>시간</th>

<?php

try
{
    $sql="SELECT * FROM temp_tb order by id desc limit $s_point,$list;";
    $stmh=$pdo->prepare($sql);
    $stmh->execute();
}
catch(PDOException $e)
{   print 'err: '. $e->getMessage();   }

while($row=$stmh->fetch(PDO::FETCH_ASSOC))
{
?>
    <tr>
    <td align='center'><?=$row['temp']?></td>
    <td align='center'><?=$row['dt']?></td>
    <tr>
<?php
}
?>
</tr>
</table>
<?php
for ($p=$s_page; $p<=$e_page; $p++) 
    {
        print ($p != $page) ? "<a style='text-decoration:none' href='".$_SERVER['PHP_SELF']."?page=".$p."'> ".$p." </a></li>\n" : "<b>$p</b> ";   
    }
?>
</body>
</html>
