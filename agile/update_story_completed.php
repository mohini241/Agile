<?php
date_default_timezone_set("Asia/Kolkata");
if (isset($_POST['update_story_completed']))
{

    
    $SESSION['update_story_completed']=$_POST['update_story_completed'];

    //  var_dump(isset($SESSION['update_story_completed']));
}

include 'connection.php';



if (isset($SESSION['update_story_completed'])) 
{ 
   
        $story_id = mysqli_real_escape_string($db, $_POST['completed_story_id']);
        $project_id = mysqli_real_escape_string($db, $_POST['project_id']);
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $story_name = mysqli_real_escape_string($db, $_POST['completed_title']);
        $story_description = mysqli_real_escape_string($db, $_POST['completed_description']);
        $story_outcome = mysqli_real_escape_string($db, $_POST['story_outcome']);
        $priority = mysqli_real_escape_string($db, $_POST['priority']);
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $estimated_hours = mysqli_real_escape_string($db, $_POST['estimated_hours']);
        $start_date = mysqli_real_escape_string($db, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($db, $_POST['end_date']);
        $actual_end_date=date("Y-m-d H:i:s");
        $actual_end_date_2 = new DateTime($actual_end_date);
        $start_date_2 = new DateTime($start_date);
        if($status=='Accepted')
        {

            $update_story_query= "update user_story set
            story_name='$story_name',story_description='$story_description',story_outcome='$story_outcome',
            story_priority='$priority',story_category='$category',story_status='$status',
            estimated_hr='$estimated_hours',start_date='$start_date',end_date='$end_date',actual_end_date='$actual_end_date' where story_id='$story_id'";
            $update_story= mysqli_query($db, $update_story_query);

            $interval  = $actual_end_date_2->diff($start_date_2);

$hours = $interval->h;
$hours = $hours + ($interval->days*24);

// echo $hours;
$update_actual_hr_query= "update user_story set
actual_hr='$hours' where story_id='$story_id'";
$update_actual_hr= mysqli_query($db, $update_actual_hr_query);
    
            $check_leader= "SELECT IF( EXISTS(
                SELECT *
                FROM leaderboard
                WHERE `Project_id` =  '$project_id' AND username = '".$username."'),1,0)";
            $check_leader_array= mysqli_query($db, $check_leader);
            $check_leader_array_result=  mysqli_fetch_array($check_leader_array);
        
            if($check_leader_array_result[0]==0)
            {
            $diff_name = "SELECT member_name from project_members where project_id='$project_id'";
            $diff_result = mysqli_query($db, $diff_name);
            while($diff_array = mysqli_fetch_assoc($diff_result))
            {
                 $list_of_diff[]=$diff_array['member_name'];
    
            }
            $member_count=count($list_of_diff);
    
            for ($x = 0; $x < $member_count; $x++)
            {
                $save_leader = "INSERT INTO `leaderboard`(`Project_id`, `username`, `score`) VALUES ('$project_id', '$list_of_diff[$x]',10)";
                mysqli_query($db, $save_leader);
            }
            }
            else
            {
                $save_leader = "Update `leaderboard` set score=score+10 where `Project_id` =  '$project_id' ";
                mysqli_query($db, $save_leader);
            }
            
           
            }
    
    
    else{

        $update_story_query= "update user_story set
        story_name='$story_name',story_description='$story_description',story_outcome='$story_outcome',
        story_priority='$priority',story_category='$category',story_status='$status',
        estimated_hr='$estimated_hours',start_date='$start_date',end_date='$end_date',actual_end_date='NULL' where story_id='$story_id'";
        $update_story= mysqli_query($db, $update_story_query);

        }

}
?>