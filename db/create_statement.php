<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/source/part3/db/db_connector.php";
  include_once $_SERVER['DOCUMENT_ROOT']."/source/part3/db/create_table.php";

  //테이블
  create_table($con, "board");
  create_table($con, "members");
  create_table($con, "message");
  create_table($con, "image_board");
  create_table($con, "image_board_ripple");



?>