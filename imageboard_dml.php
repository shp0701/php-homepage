<?php
  include("./db/db_connector.php");  
	//1.데이타베이스 include 
	//2. 전역변수선언 한줄
	//3. $_POST isset()
	//4. 보안코딩
	//5. 에러코딩 체크
	//7. insert 진행함.
	session_start();
	if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
	else $userid = "";
	if (isset($_SESSION["username"])) $username = $_SESSION["username"];
	else $username = "";
	if (!$userid ){
			echo("
        <script>
        alert('이미지게시판 글쓰기는 로그인 후 이용해 주세요!');
        history.go(-1)
        </script>
			");
      exit;
	}
  
  if (isset($_POST["mode"]) && $_POST["mode"] === "delete") {
        $num = $_POST["num"];
        $page = $_POST["page"];
        $sql = "select * from image_board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $writer = $row["id"];

        if (!isset($userid) || ($userid !== $writer && $userlevel !== '1')) {
            alert_back('수정권한이 없습니다.');
            exit;
        }
        $copied_name = $row["file_copied"];

        if ($copied_name) {
            $file_path = "./data/" . $copied_name;
            unlink($file_path);
        }

        $sql = "delete from image_board where num = $num";
        mysqli_query($con, $sql);
        mysqli_close($con);
        echo "
        <script>
            location.href = 'imageboard_list.php?page=$page';
        </script>
        ";
    } else if (isset($_POST["mode"]) && $_POST["mode"] === "insert") {
      $subject = $_POST["subject"];
      $content = $_POST["content"];
      $subject = htmlspecialchars($subject, ENT_QUOTES);
	    $content = htmlspecialchars($content, ENT_QUOTES);
      $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
      $upload_dir = "./data/";

      $upfile_name = $_FILES["upfile"]["name"];
      $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
      $upfile_type = $_FILES["upfile"]["type"];
      $upfile_size = $_FILES["upfile"]["size"];  // 안되면 php init 에서 최대 크기 수정!
      $upfile_error = $_FILES["upfile"]["error"];

      if ($upfile_name && !$upfile_error) { // 업로드가 잘되었는지 판단
        $file = explode(".", $upfile_name); 
        $file_name = $file[0]; //(memo)
        $file_ext = $file[1]; //(sql)

        $new_file_name = date("Y_m_d_H_i_s");
        $new_file_name = $new_file_name . "_" . $file_name;
        $copied_file_name = $new_file_name . "." . $file_ext;
        $uploaded_file = $upload_dir.$copied_file_name;
        if ($upfile_size > 1000000) {
          echo("
            <script>
            alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
            history.go(-1)
            </script>
				  ");
          exit;
        }

        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
          echo("
            <script>
            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
            history.go(-1)
            </script>
  				");
          exit;
        }
      } else {
            $upfile_name = "";
            $upfile_type = "";
            $copied_file_name = "";
      }
      
      $sql = "insert into image_board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
      $sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
      $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
      error_log ($sql);
      mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

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
          location.href = 'imageboard_list.php';
        </script>
     	";
  }else if (isset($_POST["mode"]) && $_POST["mode"] === "modify"){
        // var_dump($_POST);
        // echo "<br>==========<br>";
        // var_dump($_FILES);
        // exit;
        $num = $_POST["num"];
        $page = $_POST["page"];

        $subject = $_POST["subject"];
        $content = $_POST["content"];
        $file_delete = (isset($_POST["file_delete"])) ? $_POST["file_delete"] : 'no';

        $sql = "select * from image_board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $copied_name = $row["file_copied"];
        $upfile_name = $row["file_name"];
        $upfile_type = $row["file_type"];
        $copied_file_name = $row["file_copied"];

        //체크박스 기존의 파일삭제
        if($file_delete === "yes"){
            if ($copied_name) {
                $file_path = "./data/" . $copied_name;
                unlink($file_path);
            }
            $upfile_name = "";
            $upfile_type = "";
            $copied_file_name = "";
            $copied_name = "";
        }else{
                 //새로운파일이 존재하면 기존파일삭제후 저장
        if (isset($_FILES["upfile"])) {
          //기존파일삭제
          if ($copied_name) {
              $file_path = "./data/" . $copied_name;
              unlink($file_path);
          }
          $upload_dir = "./data/";
          $upfile_name = $_FILES["upfile"]["name"];
          $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
          $upfile_type = $_FILES["upfile"]["type"];
          $upfile_size = $_FILES["upfile"]["size"];  
          $upfile_error = $_FILES["upfile"]["error"];
          if ($upfile_name && !$upfile_error) { 
              $file = explode(".", $upfile_name); 
              $file_name = $file[0]; 
              $file_ext = $file[1]; 
              $new_file_name = date("Y_m_d_H_i_s");
              $new_file_name = $new_file_name . "_" . $file_name;
              $copied_file_name = $new_file_name . "." . $file_ext; 
              $uploaded_file = $upload_dir . $copied_file_name; 
              if ($upfile_size > 1000000) {
                  echo("
                  <script>
                  alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
                  history.go(-1)
                  </script>
                  ");
                  exit;
              }
              if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
                  echo("
                  <script>
                  alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                  history.go(-1)
                  </script>
                ");
                  exit;
              }
              
          }else{
            $upfile_name = $row["file_name"];
            $upfile_type = $row["file_type"];
            $copied_file_name = $row["file_copied"];
          }
        }
      }
        $sql = "update image_board set subject='$subject', content='$content',  file_name='$upfile_name', file_type='$upfile_type', file_copied= '$copied_file_name'";
        $sql .= " where num=$num";
        mysqli_query($con, $sql);
        mysqli_close($con);

        echo "
          <script>
              location.href = 'imageboard_list.php?page=$page';
          </script>
	      ";
    }else if (isset($_POST["mode"]) && $_POST["mode"] == "insert_ripple") {
        if (empty($_POST["ripple_content"])) {
            echo "<script>alert('내용입력요망!');history.go(-1);</script>";
            exit;
        }
        //"덧글을 다는사람은 로그인을 해야한다." 말한것이다.
        $q_userid = mysqli_real_escape_string($con, $userid);
        $sql = "select * from members where id = '$q_userid'";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
        $rowcount = mysqli_num_rows($result);

        if (!$rowcount) {
            echo "<script>alert('없는 아이디!!');history.go(-1);</script>";
            exit;
        } else {
            $content = input_set($_POST["ripple_content"]);
            $page = input_set($_POST["page"]);
            $parent = input_set($_POST["parent"]);
            $hit = input_set($_POST["hit"]);
            $q_usernick = isset($_SESSION['usernick']) ? mysqli_real_escape_string($con, $_SESSION['usernick']) : null;
            $q_username = mysqli_real_escape_string($con, $_SESSION['username']);
            $q_content = mysqli_real_escape_string($con, $content);
            $q_parent = mysqli_real_escape_string($con, $parent);
            $regist_day = date("Y-m-d (H:i)");

            $sql = "INSERT INTO `image_board_ripple` VALUES (null,'$q_parent','$q_userid','$q_username', '$q_usernick','$q_content','$regist_day')";
            $result = mysqli_query($con, $sql);
            if (!$result) {
                die('Error: ' . mysqli_error($con));
            }
            mysqli_close($con);
            echo "
            <script>
              location.href='./imageboard_view.php?num=$parent&page=$page&hit=$hit';
            </script>
            ";
        }//end of if rowcount
    } else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple") {
        $page = input_set($_POST["page"]);
        $hit = input_set($_POST["hit"]);
        $num = input_set($_POST["num"]);
        $parent = input_set($_POST["parent"]);
        $q_num = mysqli_real_escape_string($con, $num);

        $sql = "DELETE FROM `image_board_ripple` WHERE num=$q_num";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
        echo "
        <script>
          location.href='./imageboard_view.php?num=$parent&page=$page&hit=$hit';</script>";
    }

?>