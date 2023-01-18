<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>cook community</title>
  <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/css/common.css">
  <link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/css/login.css">
  <script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/js/login.js"></script>
</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT']."/source/part3/header.php";?>
  </header>
  <section>
    <!-- 로그인 폼 -->
    <div id="main_content">
      <div id="login_box">
        <div id="login_title">
          <span>로그인</span>
        </div>
        <div id="login_form">
          <!-- login -> login_server.php -->
          <form name="login_form" method="post" action="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/login.php">
            <ul>
              <li><input type="text" name="id" placeholder="아이디"></li>
              <li><input type="password" id="pass" name="pass" placeholder="비밀번호"></li> <!-- pass -->
            </ul>
            <!-- img -> button change -->
            <div id="login_btn">
              <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST'];?>/source/part3/img/login.png"
                  onclick="check_input()"></a>
            </div>
          </form>
        </div> <!-- login_form -->
      </div> <!-- login_box -->
    </div> <!-- main_content -->
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/source/part3/footer.php";?>
  </footer>
</body>

</html>