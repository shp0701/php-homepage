<?php
// 세션값체크 :세션값이 있으면 세션값으로 변수에 저장하고 , 없으면 "" 취급한다. 
    session_start();
    $userid = $username = $userlevel = $userpoint = "";
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";
?>
<link rel="stylesheet" href="./css/font.css" />
<link rel="stylesheet" href="./css/menu.css" />
<!-- 프로그램 로고 -->
<!-- <div id="top" style="background-image: url('./img/headerImg.jpg');"> -->
<div id="top">
  <h3>
    <a class="title" href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/index.php">COOK COMMUNITY</a>
  </h3>

  <!--로그인이전, 로그인이후, 관리자모드  -->
  <ul id="top_menu">
    <?php
    if(!$userid) {
?>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/member_form.php">회원 가입</a> </li>
    <li> | </li>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/login_form.php">로그인</a></li>
    <?php
    } else {
?>
    <li><?=$username."(".$userid.")님[Level:".$userlevel.", Point:".$userpoint."]"?> </li>
    <li> | </li>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/logout.php">로그아웃</a> </li>
    <li> | </li>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/member_modify_form.php">정보 수정</a></li>
    <?php
    }
?>

    <?php
    if($userlevel==1) {
?>
    <li> | </li>
    <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/admin.php">관리자 모드</a></li>
    <?php
    }
?>
  </ul>
</div>

  <nav class="menu">
    <div class="gnb">
      <a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/index.php" data-link="HOME"></a>
      <a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/board_list.php" data-link="자유게시판"></a>
      <a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/imageboard_list.php" data-link="요리정보"></a>
      <a href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/message_form.php" data-link="쪽지함"></a>
    </div>
  </nav>
