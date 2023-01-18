<?php
	include("./db/db_connector.php");  
	session_start();
	if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
	else $userid = "";
	if (isset($_SESSION["username"])) $username = $_SESSION["username"];
	else $username = "";

	if ( !$userid ){
			echo("
									<script>
									alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
									history.go(-1)
									</script>
			");
							exit;
	}

	$subject = $_POST["subject"];
	$content = $_POST["content"];
	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	//서버에서 자료를 저장할 장소를 한곳을 정한다.
	//데이타베이스를 자료를 저장하지 않는다. 서버 외장하드에 저장한다.  
	$upload_dir = './data/';

	//input type="files" => $_FILES 
	$upfile_name	   = $_FILES["upfile"]["name"];
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
	$upfile_type     = $_FILES["upfile"]["type"];
	$upfile_size     = $_FILES["upfile"]["size"];
	//에러가 없으면 0
	$upfile_error    = $_FILES["upfile"]["error"];   

	//!0 => true
	if ($upfile_name && !$upfile_error){
		//"flower.png" => $file[0] ="flower" $file[1]="png" 
		// 중복되지않는 파일명을 만들기위해서
		$file = explode(".", $upfile_name);
		$file_name = $file[0];
		$file_ext  = $file[1];
		//2023_01_10_10_08_10flower.png  중복되지않는 파일명
		$copied_file_name = date("Y_m_d_H_i_s"). $upfile_name;    
		$uploaded_file = $upload_dir.$copied_file_name;
	
		//용량제한걸릴경우에는 php.ini  upload_max_filesize = 200M 용량사이즈를 크게할것 
		if( $upfile_size  > 1000000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
		}
		//move_uploaded_file():C:\Windows\temp\php7905.tmp => ./data/2023_01_10_10_08_10flower.png
		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
	}else{
		//파일을 업로드 하지 않는다면 
		$upfile_name      = "";
		$upfile_type      = "";
		$copied_file_name = "";
  } //end of if(isset($upfile_name) && !$upfile_error)

	// $con = mysqli_connect("localhost", "root", "12345", "sample");
  //$copied_file_name = 2023_01_10_10_08_10flower.png 
	$sql = "insert into board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
	$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
	$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	//insert문이 잘 진행이 되었는지 점검유무가 빠졌음. 집어넣어주고 돌아갈것.

	// 포인트 부여하기
	$point_up = 100;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;

  $sql = "update members set point=$new_point where id='$userid'";
  mysqli_query($con, $sql);

  mysqli_close($con);                // DB 연결 끊기

	echo "
			<script>
			location.href = 'board_list.php';
			</script>
	";
?>