<?php
  include("./db/db_connector.php");
  //1.데이타베이스 include 
  //2. 전역변수선언 한줄
  //3. $_GET isset()
  //4. 보안코딩
  //5. 에러코딩 체크
  //7. delete 진행함.
  $num   = $_GET["num"];
  $page   = $_GET["page"];

  //삭제시 그 해당되는 데이타 파일까지 지워줘야한다. 
  // $con = mysqli_connect("localhost", "root", "12345", "sample");
  $sql = "select * from board where num = $num";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);
  $copied_name = $row["file_copied"];

  //파일이 존재하면 파일삭제하는 기능
	if ($copied_name){
		$file_path = "./data/".$copied_name;
		unlink($file_path);
  }

  $sql = "delete from board where num = $num";
  mysqli_query($con, $sql);
  mysqli_close($con);

  echo "
	<script>
	  location.href = 'board_list.php?page=$page';
	</script>
	";
?>