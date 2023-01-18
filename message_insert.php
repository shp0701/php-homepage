<?php
  include("./db/db_connector.php");  
	//1.데이타베이스 include 
	//2. 전역변수선언 한줄
	//3. $_POST isset()
	//4. 보안코딩
	//5. 에러코딩 체크
	//6. insert 진행함.

  $send_id = $_POST["send_id"];
	$rv_id = $_POST['rv_id'];
	$subject = $_POST['subject'];
	$content = $_POST['content'];
	//html tag 구조는 entity code 변환시켜줌 (trim, stripslashes 기능을 빼버린것이 맞다)
	//ENT_QUOTES :''(홑따옴표) 와 ""(겹따옴표) 둘다 변환
	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);
	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	if(!$send_id) {
		echo("
			<script>
			alert('로그인 후 이용해 주세요! ');
			history.go(-1)
			</script>
			");
		exit;
	}

	// $con = mysqli_connect("localhost", "root", "12345", "sample");
	$sql = "select * from members where id='$rv_id'";
	$result = mysqli_query($con, $sql);
	
	if(mysqli_num_rows($result) == 1)
	{
		$sql = "insert into message (send_id, rv_id, subject, content,  regist_day) ";
		$sql .= "values('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
		mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
	} else {
		echo("
			<script>
			alert('수신 아이디가 잘못 되었습니다!');
			history.go(-1)
			</script>
			");
		exit;
	}

	mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'message_box.php?mode=send';
	   </script>
	";
?>