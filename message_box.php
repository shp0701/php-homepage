<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/message.css">
</head>

<body>
  <header>
    <?php include "header.php";?>
  </header>
  <section>

    <div id="message_box">
      <h3>
        <?php
		//1. 페이지 보이는 부분에서 반드시 해야된다. 
		//리스트목록보여줄때 페이지를 지정하지 않으면 기본페이지느 1페이지를 셋팅한다. 
 		if (isset($_GET["page"]) || !empty($_GET["page"]))
			$page = $_GET["page"];
		else
			$page = 1;
		//2. 한페이지에 보여줘야할 갯수 설정한다.
		//$start  1페이지 limit $start(0) , $scale
		//$start  2페이지 limit $start(10), $scale
		$scale = 4;
		$start = ($page -1) * $scale;

		$mode = $_GET["mode"];

		if ($mode=="send")
			echo "송신 쪽지함 > 목록보기";
		else
			echo "수신 쪽지함 > 목록보기";
?>
      </h3>
      <div>
        <ul id="message">
          <li>
            <span class="col1">번호</span>
            <span class="col2">제목</span>
            <span class="col3">
              <?php						
						if ($mode=="send")
							echo "받은이";
						else
							echo "보낸이";
?>
            </span>
            <span class="col4">등록일</span>
          </li>
          <?php
					 include("./db/db_connector.php");  
					// $con = mysqli_connect("localhost", "root", "12345", "sample");
					//3번 $total_page 전체페이지를 구한다. 
					if ($mode=="send")
						$sql = "select count(*) from message where send_id='$userid' order by num desc";
					else
						$sql = "select count(*) from message where rv_id='$userid' order by num desc";
					$result = mysqli_query($con, $sql);
					$row = mysqli_fetch_array($result); // 전체 글 수
					$total_record = intval($row[0]); 
					$total_page = ceil($total_record / $scale); //전체페이지
					
					//4번 우리가 원하는 페이지에 있는 시작위치 ~ 끝위치 레코드셋을 가져온다. 
					if ($mode=="send")
						$sql = "select * from message where send_id='$userid' order by num desc limit $start , $scale";
					else
						$sql = "select * from message where rv_id='$userid' order by num desc limit $start , $scale";
		
					$result = mysqli_query($con, $sql);

					//5. 전체갯수 34개  2페이지(10) 34 -10 = 24 보여줘야할 번호 순서
					$number = $total_record - $start;

					//6. 해당된 페이지 가져올 레코드수 출력한다. 
				  while($row = mysqli_fetch_array($result)){
						//$row["num"] 해당된 레코드의 primary key
						$num    = $row["num"];
						$subject     = $row["subject"];
						$regist_day  = $row["regist_day"];
						if ($mode=="send")
							$msg_id = $row["rv_id"];
						else
							$msg_id = $row["send_id"];
	
						$result2 = mysqli_query($con, "select name from members where id='$msg_id'");
						$record = mysqli_fetch_array($result2);
						$msg_name = $record["name"];	  
?>
          <li>
            <span class="col1"><?=$number?></span>
            <span class="col2"><a href="message_view.php?mode=<?=$mode?>&num=<?=$num?>"><?=$subject?></a></span>
            <span class="col3"><?=$msg_name?>(<?=$msg_id?>)</span>
            <span class="col4"><?=$regist_day?></span>
          </li>
          <?php
							$number--;
					}//end of while
					mysqli_close($con);
?>
        </ul>
        <ul id="page_num">
          <?php
					$url = "message_box.php?mode=".$mode."&page=1";
					echo get_paging(5, $page, $total_page, $url);
					// //7. 전체페이지가 2페이지이상이고 , 현재 페이지 2페이지 이상을 나타날때 이전페이지 작동시킨다.
					// if ($total_page >=2 && $page >= 2){
					// 	$new_page = $page-1;
					// 	echo "<li><a href='message_box.php?mode=$mode&page=$new_page'>◀ 이전</a> </li>";
					// }else{
					// 	echo "<li>&nbsp;</li>";
					// } 

					// //8 페이지 목록 하단에 페이지 링크 번호 출력 (1페이지부터 ~ 마지막페이지출력)
					// //현재 페이지번호 링크 안함, 다른페이지는 링크를 처리한다.
					// for ($i=1; $i<=$total_page; $i++){
					// 	if ($page == $i){
					// 		echo "<li><b style='color:blue'> ".$i."</b></li>";
					// 	}else{
					// 		echo "<li> <a href='message_box.php?mode=$mode&page=$i'> $i </a> <li>";
					// 	}
					// }
					// //9. 전체페이지가 2페이지이상이고 , 현재 페이지 마지막페이지가 아닐때 다음페이지 작동시킨다.
					// if ($total_page>=2 && $page != $total_page){
					// 	$new_page = $page+1;	
					// 	echo "<li> <a href='message_box.php?mode=$mode&page=$new_page'>다음 ▶</a> </li>";
					// }else{
					// 	echo "<li>&nbsp;</li>";
					// } 
?>
        </ul> <!-- page -->
        <ul class="buttons">
          <li><button onclick="location.href='message_box.php?mode=rv'">수신 쪽지함</button></li>
          <li><button onclick="location.href='message_box.php?mode=send'">송신 쪽지함</button></li>
          <li><button onclick="location.href='message_form.php'">쪽지 보내기</button></li>
        </ul>
      </div> <!-- message_box -->
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>

</html>