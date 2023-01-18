<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="./css/common.css">
  <link rel="stylesheet" type="text/css" href="./css/imgboard.css">
  <script>
  function check_input() {
    if (!document.board_form.subject.value) {
      alert("제목을 입력하세요!");
      document.board_form.subject.focus();
      return;
    }
    if (!document.board_form.content.value) {
      alert("내용을 입력하세요!");
      document.board_form.content.focus();
      return;
    }
    document.board_form.submit();
  }
  </script>
</head>

<body>
  <header>
    <?php include "header.php";?>
  </header>
  <section>

    <div id="board_box">
      <h3 id="board_title">
        이미지게시판 > 수정하기
      </h3>
      <?php
  if (!$userid) {
    echo("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
      exit;
  }
 
  include("./db/db_connector.php");  
  if (isset($_POST["mode"]) && $_POST["mode"] === "modify") {
      $num = $_POST["num"];
      $page = $_POST["page"];

      $sql = "select * from image_board where num=$num";
      $result = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($result);

      $writer = $row["id"];
      if (!isset($userid) || ($userid !== $writer && $userlevel !== '1')) {
          alert_back('수정권한이 없습니다.');
          exit;
      }
      $name = $row["name"];
      $subject = $row["subject"];
      $content = $row["content"];
      $file_name = $row["file_name"];
      // var_dump($row);
      // exit; 
      if (empty($file_name)) $file_name = "없음";
  }

?>
      <!-- enctype="multipart/form-data" 이것을 하지 않으면 파일업로드 되지 않음 : 명심 -->
      <form name="board_form" method="post" action="imageboard_dml.php" enctype="multipart/form-data">
        <input type="hidden" name="mode" value="modify">
        <input type="hidden" name="num" value=<?= $num ?>>
        <input type="hidden" name="page" value=<?= $page ?>>
        <ul id="board_form">
          <li>
            <span class="col1">이름 : </span>
            <span class="col2"><?=$username?></span>
          </li>
          <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value=<?= $subject ?>></span>
          </li>
          <li id="text_area">
            <span class="col1">내용 : </span>
            <span class="col2">
              <textarea name="content"><?= $content ?></textarea>
            </span>
          </li>
          <li>
            <span class="col1"> 첨부 파일</span>
            <span class="col2"><input type="file" name="upfile">
              <input type="checkbox" value="yes" name="file_delete">&nbsp;파일 삭제하기
              <br>현재 파일 : <?= $file_name ?>
            </span>
          </li>
        </ul>
        <ul class="buttons">
          <li><button type="button" onclick="check_input()">수정완료</button></li>
          <li><button type="button" onclick="location.href='imageboard_list.php'">목록</button></li>
        </ul>
      </form>
    </div> <!-- board_box -->
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>

</html>