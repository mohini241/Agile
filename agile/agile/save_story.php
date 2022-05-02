<?php
if (isset($_POST['create_story']))
{

    
    $SESSION['create_story']=$_POST['create_story'];

    // var_dump(isset($SESSION['create_story']));
}

include 'connection.php';



if (isset($SESSION['create_story'])) 
{ 
   
        $project_id=mysqli_real_escape_string($db, $_POST['project_id']);
        $story_name = mysqli_real_escape_string($db, $_POST['story_name']);
        $story_description = mysqli_real_escape_string($db, $_POST['story_description']);
        $story_outcome = mysqli_real_escape_string($db, $_POST['story_outcome']);
        $priority = mysqli_real_escape_string($db, $_POST['priority']);
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        

        $check_story= "SELECT IF( EXISTS(
            SELECT *
            FROM user_story
            WHERE `project_id` =  '$project_id' AND story_name = '".$story_name."'),1,0)";
        $check_story_array= mysqli_query($db, $check_story);
        $check_story_array_result=  mysqli_fetch_array($check_story_array);
        //   echo $array9[0];
        
        if($check_story_array_result[0]==0)
        {
        $save_story = "INSERT INTO `user_story`(`story_name`, `story_description`, `story_outcome`, `story_priority`, `story_category`, `story_status`, `project_id`) VALUES ('$story_name', '$story_description', '$story_outcome', '$priority','$category','$status','$project_id')";
        mysqli_query($db, $save_story);
        }
        else{
          echo '<div class="alert alert-danger" role="alert">
          Story already exists!! Please use a different story name!
        </div>';
        }
}