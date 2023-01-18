<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/imgboard.css">
</head>

<body>
  <header>
    <?php include "header.php";?>
  </header>
  <section>

    <div id="board_box">
      <h3>
        이미지게시판 > 목록보기
      </h3>
      <ul id="board_list">
        <?php
	include("./db/db_connector.php");  

	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

  $sql = "select count(*) from image_board order by num desc";
	$result = mysqli_query($con, $sql);
	$row    = mysqli_fetch_array($result);
	$total_record = intval($row[0]); // 전체 글 수
  
	$scale = 3;
  $total_page = ceil($total_record / $scale);

	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      
	$number = $total_record - $start;

  //현재페이지 레코드 결과값을 저장하기 위해서 배열선언
  $list = array(); 

  $sql = "select * from image_board order by num desc LIMIT $start, $scale";
  $result = mysqli_query($con, $sql);
  $i = 0;
  while($row = mysqli_fetch_array($result)){
    $list[$i] = $row;
    //번호순서
    $list_num = $total_record - ($page - 1) * $scale; 
    $list[$i]['no'] = $list_num -$i;
    $i++;
  }
  // for (; $row = mysqli_fetch_assoc($result); $i++) {
  //   //$row 배열을 $list[$i] 저장하기 따라서 2차원배열이 진행이 됨. 
  //   $list[$i] = $row;
  //   //번호순서
  //   $list_num = $total_record - ($page - 1) * $scale; 
  //   $list[$i]['no'] = $list_num -$i;
  // }

  $image_width = 200;
  $image_height = 200;

  for($i=0; $i< count($list); $i++){
    $file_image = (!empty($list[$i]['file_name']))?"<img src='./img/file.gif'>" :" ";
    $date = substr($list[$i]['regist_day'], 0, 10);

    if (!empty($list[$i]['file_name'])) {
      $image_info = getimagesize("./data/".$list[$i]['file_copied']);
      $image_width = $image_info[0];
      $image_height = $image_info[1];
      $image_type = $image_info[2];
      if ($image_width > 200 ) $image_width = 200;
      if ($image_height > 200 ) $image_height = 200;
      $file_copied_0 = $list[$i]['file_copied'];
    }
?>
        <li>
          <span>
            <a href="imageboard_view.php?num=<?= $list[$i]['num'] ?>&page=<?= $page ?>">
              <?php 
  if (strpos($list[$i]['file_type'],"image") !== false) 
        echo "<img src='./data/$file_copied_0' width='$image_width' height='$image_height'><br>";
  else 
        echo "<img src='./img/user.jpg' width='$image_width' height='$image_height'><br>"; 
?>
              <?= $list[$i]['subject'] ?></a><br>
            <?= $list[$i]['id'] ?><br>
            <?= $date ?>
          </span>
        </li>
        <?php
    }//end of form
    mysqli_close($con);
?>
      </ul>

      <ul id="page_num">
        <?php
	$url = "imageboard_list.php?page=1";
	echo get_paging(3, $page, $total_page, $url);
?>
      </ul> <!-- page -->
      <ul class="buttons">
        <li><button onclick="location.href='imageboard_list.php'">목록</button></li>
        <li>
          <?php 
    if($userid){
?>
          <button onclick="location.href='imageboard_form.php'">글쓰기</button>
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