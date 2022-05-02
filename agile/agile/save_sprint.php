<?php
if (isset($_POST['create_sprint']))
{

    
    $SESSION['create_sprint']=$_POST['create_sprint'];

    // var_dump(isset($SESSION['create_sprint']));
}

include 'connection.php';



if (isset($SESSION['create_sprint'])) 
{ 
   
        $sprint_project_id=mysqli_real_escape_string($db, $_POST['sprint_project_id']);
        $sprint_name = mysqli_real_escape_string($db, $_POST['sprint_name']);
        $sprint_start_date = mysqli_real_escape_string($db, $_POST['sprint_start_date']);
        $sprint_end_date = mysqli_real_escape_string($db, $_POST['sprint_end_date']);
        
        

        $check_sprint= "SELECT IF( EXISTS(
            SELECT *
            FROM sprint
            WHERE `sprint_name` =  '$sprint_name' AND project_id = '".$sprint_project_id."'),1,0)";
        $check_sprint_array= mysqli_query($db, $check_sprint);
        $check_sprint_array_result=  mysqli_fetch_array($check_sprint_array);
        //   echo $array9[0];
        
        if($check_sprint_array_result[0]==0)
        {
        $save_sprint = "INSERT INTO `sprint`(`sprint_name`, `project_id`, `start_date`, `end_date`)
        VALUES ('$sprint_name', '$sprint_project_id', '$sprint_start_date', '$sprint_end_date')";
        mysqli_query($db, $save_sprint);
        }
        else{
          echo '<div class="alert alert-danger" role="alert">
          Sprint already exists!! Please use a different Sprint name!
        </div>';
        }
}