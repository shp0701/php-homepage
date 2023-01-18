<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/slide.css" />
    <link rel="stylesheet" type="text/css" href="./css/imgboard.css">
    <script
      src="https://kit.fontawesome.com/6a2bc27371.js"
      crossorigin="anonymous"
    ></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Oswald&family=Source+Sans+Pro:ital,wght@0,400;0,900;1,400&display=swap"
      rel="stylesheet"
    />

    <style>
      body {
        margin: 0;
      }
      .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: rgb(60, 60, 68);
      }
      .navbar_title {
        display: flex;
        align-items: baseline;
        font-size: 32px;
        color: rgb(224, 131, 132);
      }
      .navbar_title h3 {
        margin: 0;
        margin-left: 20px;
        color: rgb(248, 247, 247);
        font-family: 'Source Sans Pro', sans-serif;
      }
      .navbar_menu {
        list-style-type: none;
        display: flex;
        font-size: 24px;
        margin-left: 0;
      }
      .navbar_menu li {
        padding: 5px;
        color: rgb(248, 247, 247);
        font-family: 'Source Sans Pro', sans-serif;
        margin-right: 10px;
      }

      .navbar_menu li:hover {
        background-color: rgb(208, 129, 166);
        border-radius: 5px;
      }
      .navbar_icon {
        display: flex;
        list-style-type: none;
        color: rgb(204, 74, 169);
        font-size: 24px;
      }
      .navbar_icon li {
        padding: 5px;
      }

      .navbar_toggle {
        display: none;
        position: absolute;
        right: 30px;
        top: 20px;
        color: rgb(239, 241, 242);
      }

      @media screen and (max-width: 768px) {
        .navbar {
          flex-direction: column;
          align-items: flex-start;
        }
        .navbar_menu {
          flex-direction: column;
          align-items: center;
          width: 100%;
          display: none;
        }
        .navbar_menu li {
          width: 100%;
          text-align: center;
        }
        .navbar_icon {
          justify-content: center;
          width: 100%;
          display: none;
        }
        .navbar_toggle {
          display: block;
        }
        .navbar_menu.active,
        .navbar_icon.active {
          display: flex;
        }
      }
    </style>
    <script src="./js/main.js" defer></script>
    <title>Document</title>
  </head>
  <body onload="call_js()">
    <div class="main">
      <div class="slideshow">
        <div class="slideshow_slides">
          <a href="#"><img src="./img/food1.jpg" alt="slide1" /></a>
          <a href="#"><img src="./img/food2.jpg" alt="slide1" /></a>
          <a href="#"><img src="./img/food3.jpg" alt="slide1" /></a>
          <a href="#"><img src="./img/food4.jpg" alt="slide1" /></a>
        </div>
        <div class="slideshow_nav">
          <a href="#" class="prev"
            ><i class="fa-solid fa-circle-chevron-left"></i
          ></a>
          <a href="#" class="next"
            ><i class="fa-solid fa-circle-chevron-right"></i
          ></a>
        </div>
        <div class="indicator">
          <a href="#" class="active"><i class="fa-solid fa-circle-dot"></i></a>
          <a href="#"><i class="fa-solid fa-circle-dot"></i></a>
          <a href="#"><i class="fa-solid fa-circle-dot"></i></a>
          <a href="#"><i class="fa-solid fa-circle-dot"></i></a>
        </div>
      </div>
      <div style="text-align: center; margin-top: 10px;">

      <!-- -----------------------이미지 게시판--------------------- -->
      <h3>이미지 게시판</h3>
      <ul id="board_list">
      <?php
        $list = array(); 

        $sql = "select * from image_board order by num desc LIMIT 0, 7";
        $result = mysqli_query($con, $sql);
        $i = 0;
        while($row = mysqli_fetch_array($result)){
          $list[$i] = $row;
          //번호순서
          $list_num = 7; 
          $list[$i]['no'] = $list_num -$i;
          $i++;
        }

        $image_width = 200;
        $image_height = 200;

        for($i=0; $i< count($list); $i++){
          $file_image = (!empty($list[$i]['file_name'])) ? "<img src='./img/file.gif'>" : " ";
          $date = substr($list[$i]['regist_day'], 0, 10);
          
          if (!empty($list[$i]['file_name'])) {
            $image_info   = getimagesize("./data/".$list[$i]['file_copied']);
            $image_width  = $image_info[0];
            $image_height = $image_info[1];
            $image_type   = $image_info[2];
            if ($image_width > 200 ) $image_width = 200;
            if ($image_height > 200 ) $image_height = 200;
            $file_copied_0 = $list[$i]['file_copied'];
          }
      ?>
              <li>
                <span>
                <a href="imageboard_view.php?num=<?= $list[$i]['num'] ?>&page=1">
                    <?php 
        if (strpos($list[$i]['file_type'],"image") !== false) 
              echo "<img src='./data/$file_copied_0' width='$image_width' height='$image_height'><br>";
        else 
              echo "<img src='./img/user.jpg' width='$image_width' height='$image_height'><br>"; 
      ?>
                    <?= $list[$i]['subject'] ?></a><br>
                  <?= $list[$i]['id'] ?><br>
                  <?= $date ?>
                </span>
              </li>
              <?php
          }//end of form
          mysqli_close($con);
      ?>
      </ul>

      <ul id="page_num">
        <a href="imageboard_list.php?page=1">더보기</a>
      </div>


      <!-- //---------------------이미지 게시판-------------------// -->
    </div>
  </body>
</html>
