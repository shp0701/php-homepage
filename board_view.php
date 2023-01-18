<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/board.css">
</head>

<body>
  <header>
    <?php include "header.php";?>
  </header>
  <section>

    <div id="board_box">
      <h3 class="title">
        게시판 > 내용보기
      </h3>

      <?php
  include("./db/db_connector.php");  
  //점검해서 오류가 발생하면 알림창을 보여주고 이전페이지로 갈것
  $num    = $_GET["num"];
  $page   = $_GET["page"];
	$sql    = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);
	$row    = mysqli_fetch_array($result);

  $id     = $row["id"];
	$name   = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$file_name  = $row["file_name"];
	$file_type  = $row["file_type"];
	$copied_file_name = $row["file_copied"];
	$hit        = $row["hit"];

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);
	$new_hit = $hit + 1;
  $sql = "update board set hit = $new_hit where num = $num ";   
	mysqli_query($con, $sql);
?>
      <ul id="view_content">
        <li>
          <span class="col1"><b>제목 :</b> <?=$subject?></span>
          <span class="col2"><?=$name?> | <?=$regist_day?></span>
        </li>
        <li>
          <?php
  if($file_name) {
     //$copied_file_name = 2023_01_10_10_08_10flower.png 
    $real_name = $copied_file_name;
    $file_path = "./data/".$real_name;
    $file_size = filesize($file_path);
    //board_download.php  프라이머리키 num, 2023_01_10_10_08_10flower.png, flower, png
    echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
        <a href='board_download.php?real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
          }
				?>
          <?=$content?>
        </li>
      </ul>
      <ul class="buttons">
        <li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
        <li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
        <li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
        <li><button onclick="location.href='board_form.php'">글쓰기</button></li>
      </ul>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>

</html>