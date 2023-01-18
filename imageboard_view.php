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
        이미지게시판 > 내용보기
      </h3>
      <ul id="board_list2">
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

  $num = $_GET["num"];
  $page = $_GET["page"];

  $sql = "select * from image_board where num=$num";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $id = $row["id"];
  $name = $row["name"];
  $regist_day = $row["regist_day"];
  $subject = $row["subject"];
  $content = $row["content"];
  $file_name = $row["file_name"];
  $file_type = $row["file_type"];
  $file_copied = $row["file_copied"];
  $hit = $row["hit"];
  $content = str_replace(" ", "&nbsp;", $content);
  $content = str_replace("\n", "<br>", $content);

  if ($userid !== $id) {
      $new_hit = $hit + 1;
      $sql = "update image_board set hit=$new_hit where num=$num";
      mysqli_query($con, $sql);
  }

  $file_name = $row['file_name'];
  $file_copied = $row['file_copied'];
  $file_type = $row['file_type'];
  //이미지 정보를 가져오기 위한 함수 width, height, type
  if (!empty($file_name)) {
      $image_info = getimagesize("./data/" . $file_copied);
      $image_width = $image_info[0];
      $image_height = $image_info[1];
      $image_type = $image_info[2];
      $image_width = 300;
      $image_height = 300;
      if ($image_width > 300) $image_width = 300;
  }
?>
        <ul id="view_content">
          <li>
            <span class="col1"><b>제목 :</b> <?= $subject ?></span>
            <span class="col2"><?= $name ?> | <?= $regist_day ?></span>
          </li>
          <li>
            <?php

          if (strpos($file_type, "image") !== false) {
              echo "<img src='./data/$file_copied' width='$image_width'><br>";
          } else if ($file_name) {
              $real_name = $file_copied;
              $file_path = "./data/" . $real_name;
              $file_size = filesize($file_path);  //파일사이즈를 구해주는 함수

              echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
<a href='board_download.php?real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
          }

?>
            <?= $content ?>
          </li>
        </ul>
        <!--덧글내용시작  -->
        <div id="ripple">
          <div id="ripple1">덧글</div>
          <div id="ripple2">
            <?php
          $sql = "select * from `image_board_ripple` where parent='$num' ";
          $ripple_result = mysqli_query($con, $sql);
          while ($ripple_row = mysqli_fetch_array($ripple_result)) {
              $ripple_num = $ripple_row['num'];
              $ripple_id = $ripple_row['id'];
              $ripple_nick = $ripple_row['nick'];
              $ripple_date = $ripple_row['regist_day'];
              $ripple_content = $ripple_row['content'];
              $ripple_content = str_replace("\n", "<br>", $ripple_content);
              $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
?>
            <div id="ripple_title">
              <ul>
                <li><?= $ripple_id . "&nbsp;&nbsp;" . $ripple_date ?></li>
                <li id="mdi_del">
                  <?php
                if ($_SESSION['userid'] == "admin" || $_SESSION['userid'] == $ripple_id) {
                    echo '
                  <form style="display:inline" action="imageboard_dml.php" method="post">
                    <input type="hidden" name="page" value="'.$page.'">
                    <input type="hidden" name="hit" value="' . $hit . '">
                    <input type="hidden" name="mode" value="delete_ripple">
                    <input type="hidden" name="num" value="' . $ripple_num . '">
                    <input type="hidden" name="parent" value="' . $num . '">
                    <span>' . $ripple_content . '</span>
                    <input type="submit" value="삭제">
                  </form>';
                }
?>
                </li>
              </ul>
            </div>
            <!--									<div id="ripple_content">-->
            <!--                                        -->
            <? //= $ripple_content ?>
            <!--									</div>-->
            <?php
           }//end of while
           mysqli_close($con);
?>
            <form name="ripple_form" action="imageboard_dml.php" method="post">
              <input type="hidden" name="mode" value="insert_ripple">
              <input type="hidden" name="parent" value="<?= $num ?>">
              <input type="hidden" name="hit" value="<?= $hit ?>">
              <input type="hidden" name="page" value="<?= $page ?>">
              <div id="ripple_insert">
                <div id="ripple_textarea"><textarea name="ripple_content" rows="3" cols="80"></textarea></div>
                <div id="ripple_button"><button>덧글입력</button>
                </div>
              </div>
              <!--end of ripple_insert -->
            </form>
          </div>
          <!--end of ripple2  -->
        </div>
        <!--end of ripple  -->

        <div id="write_button">
          <ul class="buttons">
            <li>
              <button onclick="location.href='imageboard_list.php?page=<?= $page ?>'">목록</button>
            </li>
            <li>
              <form action="imageboard_modify_form.php" method="post">
                <button>수정</button>
                <input type="hidden" name="num" value=<?= $num ?>>
                <input type="hidden" name="page" value=<?= $page ?>>
                <input type="hidden" name="mode" value="modify">
              </form>
            </li>
            <li>
              <form action="imageboard_dml.php" method="post">
                <button>삭제</button>
                <input type="hidden" name="num" value=<?= $num ?>>
                <input type="hidden" name="page" value=<?= $page ?>>
                <input type="hidden" name="mode" value="delete">
              </form>
            </li>
            <li>
              <button onclick="location.href='imageboard_form.php'">글쓰기</button>
            </li>
          </ul>
        </div> <!-- board_box -->
  </section>
  <footer>
    <?php include "footer.php";?>
  </footer>
</body>

</html>