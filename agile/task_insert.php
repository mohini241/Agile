<?php
if (isset($_POST['task_completed']))
{

    
    $SESSION['task_completed']=$_POST['task_completed'];

    //  var_dump(isset($SESSION['task_completed']));
}

include 'connection.php';



if (isset($SESSION['task_completed'])) 
{ 
   
        $story_id = mysqli_real_escape_string($db, $_POST['story_id']);

        $task_name = mysqli_real_escape_string($db, $_POST['task_name']);
        $task_description = mysqli_real_escape_string($db, $_POST['task_description']);
        $task_start_date = mysqli_real_escape_string($db, $_POST['task_start_date']);
        $task_end_date = mysqli_real_escape_string($db, $_POST['task_end_date']);

        

        $check_task= "SELECT IF( EXISTS(
            SELECT *
            FROM task
            WHERE `story_id` =  '$story_id' AND task_name = '$task_name'),1,0)";
        $check_task_array= mysqli_query($db, $check_task);
        $check_task_array_result=  mysqli_fetch_array($check_task_array);
        
        
        if($check_task_array_result[0]==0)
        {
            $insert_task_query= "insert into task(story_id,task_name,task_description,start_date,end_date)
            VALUES('$story_id','$task_name','$task_description','$task_start_date','$task_end_date')";
            $insert_task= mysqli_query($db, $insert_task_query);
        }
        else{
          echo '<div class="alert alert-danger" role="alert">
          Task already exists!! Please use a different Task Name!
        </div>';
        }







       
}

?>