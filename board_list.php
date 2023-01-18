<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/board.css">
  <link rel="stylesheet" type="text/css" href="./css/font.css">
</head>

<body>
  <header>
    <?php include "header.php";?>
  </header>
  <section>

    <div id="board_box">
      <h3>
        게시판 > 목록보기
      </h3>
      <ul id="board_list">
      <link rel="stylesheet" type="text/css" href="./css/font.css">
        <li>
          <span class="col1">번호</span>
          <span class="col2">제목</span>
          <span class="col3">글쓴이</span>
          <span class="col4">첨부</span>
          <span class="col5">날짜</span>
          <span class="col6">조회</span>
        </li>
        <?php
	include("./db/db_connector.php");  

	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

	// $con = mysqli_connect("localhost", "root", "12345", "sample");
	$sql = "select count(*) from board order by num desc";
	$result = mysqli_query($con, $sql);
	$row    = mysqli_fetch_array($result);
	$total_record = intval($row[0]); // 전체 글 수
	$scale = 4;
  $total_page = ceil($total_record / $scale);

	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      
	$number = $total_record - $start;

	$sql = "select * from board order by num desc limit $start , $scale";
	$result = mysqli_query($con, $sql);

	while($row = mysqli_fetch_array($result)){
	  $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
    $regist_day  = $row["regist_day"];
    $hit         = $row["hit"];
    if ($row["file_name"]){
     	$file_image = "<img src='./img/file.gif'>";
		}else{
     	$file_image = " ";
		}
?>
        <li>
          <span class="col1"><?=$number?></span>
          <span class="col2"><a href="board_view.php?num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></span>
          <span class="col3"><?=$name?></span>
          <span class="col4"><?=$file_image?></span>
          <span class="col5"><?=$regist_day?></span>
          <span class="col6"><?=$hit?></span>
        </li>
        <?php
   	   $number--;
  }//end of while
  
	mysqli_close($con);

?>
      </ul>

      <ul id="page_num">
        <?php
	$url = "board_list.php?mode=send&page=1";
	echo get_paging(5, $page, $total_page, $url);
	// if ($total_page>=2 && $page >= 2)	
	// {
	// 	$new_page = $page-1;
	// 	echo "<li><a href='board_list.php?page=$new_page'>◀ 이전</a> </li>";
	// }		
	// else 
	// 	echo "<li>&nbsp;</li>";

  //  	// 게시판 목록 하단에 페이지 링크 번호 출력
  //  	for ($i=1; $i<=$total_page; $i++)
  //  	{
	// 	if ($page == $i)     // 현재 페이지 번호 링크 안함
	// 	{
	// 		echo "<li><b> $i </b></li>";
	// 	}
	// 	else
	// 	{
	// 		echo "<li><a href='board_list.php?page=$i'> $i </a><li>";
	// 	}
  //  	}
  //  	if ($total_page>=2 && $page != $total_page)		
  //  	{
	// 	$new_page = $page+1;	
	// 	echo "<li> <a href='board_list.php?page=$new_page'>다음 ▶</a> </li>";
	// }
	// else 
	// 	echo "<li>&nbsp;</li>";
?>
      </ul> <!-- page -->
      <ul class="buttons">
        <li><button onclick="location.href='board_list.php'">목록</button></li>
        <li>
          <?php 
    if($userid){
?>
          <button onclick="location.href='board_form.php'">글쓰기</button>
          <?php
	  }else{
?>
          <a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
          <?php
	  }
?>
        </li>
      </ul>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>

</html>