<?php
  include 'connection.php';
  $value=$_POST['value'];
  $value_type=gettype($value);


  $records1 = "select sprint_id from user_story where story_id ='$value'";  
  $query1=mysqli_query($db,$records1);
  $row1=mysqli_fetch_array($query1); 
$new=$row1[0];
// echo json_encode(is_null($new));
if(is_null($new)){
  echo json_encode('Select a sprint first');
} else{
  



  $records2 = "update user_story set story_status ='ToDo' where story_id='$value'";  
  $query2=mysqli_query($db,$records2);
  echo json_encode('Added User Story to ToDo');
}

// if(is_null($new)){
  
//     $records2 = "update user_story set story_status ='ToDo' where story_id='$value'";  
//   $query2=mysqli_query($db,$records2)


 
// }else{
  
 
 
//   $records2 = "update user_story set story_status ='DoTo' where story_id='$value'";  
//   $query2=mysqli_query($db,$records2)

//  }


?>