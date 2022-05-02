<?php
if (isset($_POST['create_pro'])) {
    echo $_POST['create_pro'];
    
$SESSION['create_pro']=$_POST['create_pro'];}
include 'connection.php';
// var_dump(isset($SESSION['create_pro']));
if (isset($SESSION['create_pro'])) {
   
  
        $project_title = mysqli_real_escape_string($db, $_POST['project_title']);
        $project_description = mysqli_real_escape_string($db, $_POST['project_description']);
        $start_date = mysqli_real_escape_string($db, $_POST['start_date']);
        $end_date  = mysqli_real_escape_string($db, $_POST['end_date']);
        $status = mysqli_real_escape_string($db, $_POST['status']);
//  echo $project_title;
        $query6 = "INSERT INTO project (title, `description`, `start date`, `end date`, `status`) 
        VALUES('$project_title', '$project_description', '$start_date', '$end_date','$status')";
        mysqli_query($db, $query6);
        $query8 = "SELECT id from project where title=?";
        if($stmt8 = mysqli_prepare($db, $query8)){
            mysqli_stmt_bind_param($stmt8, "s", $project_title);
                if(mysqli_stmt_execute($stmt8)){
                    $result8 = mysqli_stmt_get_result($stmt8);
                        $rowemp8 = mysqli_fetch_array($result8);
        
                     
                    //    echo $rowemp8[0];
                }
            }

                // echo "abcd";



        if(isset($_POST['members']))
        {
            // Retrieving each selected option
            foreach ($_POST['members'] as $members){


                
                $query9= "SELECT IF( EXISTS(
                    SELECT *
                    FROM project_members
                    WHERE `project_id` =  '$rowemp8[0]' AND member_name = '".$members."'),1,0)";
                $results9 = mysqli_query($db, $query9);
              $array9=  mysqli_fetch_array($results9);
            //   echo $array9[0];

 if($array9[0]==0){
            $query7 = "INSERT INTO project_members (project_id, member_name) 
            VALUES('$rowemp8[0]', '$members')";
            mysqli_query($db, $query7);}
            }
        }
    else
        echo "Select an option first !!";
}
          
?>    