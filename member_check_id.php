<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/source/part3/db/db_connector.php";
    //1.데이타베이스 include 
    //2. 전역변수선언 한줄
    $message = $id = ""; 
    //3. $_GET isset()
    //4. 보안코딩
    //5. 에러코딩 체크 메시지만보여준다.
    //6. select 진행  
    $id = $_GET["id"];

   if(!$id){
      $message = "<li>아이디를 입력해 주세요!</li>";
   }else{
      // $con = mysqli_connect("localhost", "root", "12345", "sample");

      $sql = "select * from members where id='$id'";
      $result = mysqli_query($con, $sql);

      if (mysqli_num_rows($result) == 1)
      {
         $message = "<li>".$id." 아이디는 중복됩니다.</li>";
         $message .= "<li>다른 아이디를 사용해 주세요!</li>";
      }
      else
      {
        $message = "<li>".$id." 아이디는 사용 가능합니다.</li>";
      }
      mysqli_close($con);
   }
?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <style>
  h3 {
    padding-left: 5px;
    border-left: solid 5px #edbf07;
  }

  #close {
    margin: 20px 0 0 80px;
    cursor: pointer;
  }
  </style>
</head>

<body>
  <h3>아이디 중복체크</h3>
  <p><?php echo $message ?></p>
  <div id="close">
    <img src="./img/close.png" onclick="javascript:self.close()">
  </div>
</body>

</html>