<?php
	include("./db/db_connector.php");
	//1.데이타베이스 include 
	//2. 전역변수선언 한줄
	//3. $_GET isset()
	//4. 보안코딩
	//5. 에러코딩 체크
	//7. delete 진행함.
	$num = $_GET["num"];
	$mode = $_GET["mode"];

	// $con = mysqli_connect("localhost", "root", "12345", "sample");
	$sql = "delete from message where num=$num";
	mysqli_query($con, $sql);
	mysqli_close($con);                // DB 연결 끊기

	if($mode == "send")
		$url = "message_box.php?mode=send";
	else
		$url = "message_box.php?mode=rv";
	echo "
	<script>
		location.href = '$url';
	</script>
	";
?>