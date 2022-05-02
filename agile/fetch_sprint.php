<?php
  include 'connection.php';
  $value=$_POST['value'];

  $records1 = "select id from sprint where sprint_name ='$value'";  
  $query1=mysqli_query($db,$records1);
  $row1=mysqli_fetch_array($query1); 
$new=$row1[0];

  $records2 = "update user_story set sprint_id ='$new'";  
$query2=mysqli_query($db,$records2);

$records3="select sprint_name from sprint where id ='$new'";
$query3=mysqli_query($db,$records3);
$row3=mysqli_fetch_array($query3); 
$new3=$row3[0];
  echo json_encode($new3);
?>