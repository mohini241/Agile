<?php
if (isset($_POST['update_story_accepted']))
{

    
    $SESSION['update_story_accepted']=$_POST['update_story_accepted'];

    //  var_dump(isset($SESSION['update_story_accepted']));
}

include 'connection.php';



if (isset($SESSION['update_story_accepted'])) 
{ 
   
        $story_id = mysqli_real_escape_string($db, $_POST['accepted_story_id']);

        $story_name = mysqli_real_escape_string($db, $_POST['accepted_title']);
        $story_description = mysqli_real_escape_string($db, $_POST['accepted_description']);
        $story_outcome = mysqli_real_escape_string($db, $_POST['story_outcome']);
        $priority = mysqli_real_escape_string($db, $_POST['priority']);
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $estimated_hours = mysqli_real_escape_string($db, $_POST['estimated_hours']);
        $start_date = mysqli_real_escape_string($db, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($db, $_POST['end_date']);

        $update_story_query= "update user_story set
        story_name='$story_name',story_description='$story_description',story_outcome='$story_outcome',
        story_priority='$priority',story_category='$category',story_status='$status',
        estimated_hr='$estimated_hours',start_date='$start_date',end_date='$end_date', actual_end_date='NULL' where story_id='$story_id' ";
        $update_story= mysqli_query($db, $update_story_query);
       
        }