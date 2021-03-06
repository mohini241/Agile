<?php 
  session_start(); 
  include 'connection.php';
 
  include 'update_story_todo.php';
  include 'update_story_inprogress.php';
  include 'update_story_completed.php';
  include 'update_story_accepted.php';
 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
  $username=$_SESSION['username'];
 
  $query1 = "SELECT * from users where username= ?";
  if($stmt1 = mysqli_prepare($db, $query1)){
    mysqli_stmt_bind_param($stmt1, "s", $username);
        if(mysqli_stmt_execute($stmt1)){
            $result1 = mysqli_stmt_get_result($stmt1);
                $rowemp = mysqli_fetch_array($result1);

             
               $_SESSION['usertype']=$rowemp[4];
        }
}
?>
<!DOCTYPE html>
<html>

<head>

    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="template.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Slabo+27px&display=swap" rel="stylesheet">

    
   
</head>
<body>
  

    <div class="header">
        
    </div>
    <!--- navbar --->
    <?php
    include 'navbar.php';
    include 'task_insert.php';
    include 'save_story.php';
    include 'save_sprint.php';
    ?>

    
<div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <h3>
                <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
            </h3>
        </div>
        <?php endif ?>

        <!-- logged in user information -->
        <?php  if (isset($_SESSION['username'])) : ?>
        
        
        <?php endif ?>
    </div>
    <?php



if ($_SESSION['usertype']=='scrummaster' || $_SESSION['usertype']=='teammember' ) {
$id=$_GET['id'];

$_SESSION['id']=$id;

$project_info = mysqli_query($db, "SELECT * FROM project, project_members where project.id=project_members.project_id and project_members.member_name='$username' and project.id='$id' ");

    while ($project_info_array = mysqli_fetch_array($project_info)) 
    {
        $project_title   = $project_info_array ['title'];
        $project_description =$project_info_array ['description'];
        $project_start_date =$project_info_array ['start date'];
        $project_end_date =$project_info_array ['end date'];

    }

    echo'
    <h1 style="color:white; text-align:center; text-transform: uppercase; "> <strong>Scrum Board:- '.$project_title.' </strong></h1>';
	echo'<div class="container"> 
  <h2 style="color:white; display:inline;">Backlog</h2><span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span> 
  <span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><h2  style="color:white; display:inline;">Sprint</h2>
    <!-- Trigger the modal with a button -->
    <br>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myBacklog">Create Story</button>
    
    <!-- Modal -->
    <div class="modal fade" id="myBacklog" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="position:absolute; float:left;">Create User Story</h4>
  
          </div>

          
  
          <div class="modal-body">
          <div class="mb-3">
          <form method="post" action="scrumboard.php?id='.$id.'">
          <label for="project_title" class="form-label">Project ID</label>
          <input type="text" class="form-control" name="project_id" value="'.$id.'" readonly>
          <label for="story_name" class="form-label">Story Name</label>
          <input type="text" class="form-control" name="story_name" placeholder="Enter User Story Title">
        </div>
        <div class="mb-3">
  
          <label for="story_description" class="form-label">Story Description</label>
          <input type="text" class="form-control" name="story_description" placeholder="Enter Story Description">
        </div>
        <div class="mb-3">
  
        <label for="story_outcome" class="form-label">Story Outcome</label>
        <input type="text" class="form-control" name="story_outcome" placeholder="Enter Story Outcome">
      </div>
      
          <div class="mb-3">
          <label for="priority" class="form-label">Select Priority</label><br>
          <select class="form-control" name="priority">
          <option value="">-- Select Priority -- </option>
          <option value="Critical">Critical</option>
          <option value="High">High</option>
          <option value="Medium">Medium</option>
          <option value="Low">Low</option>
          </select>
          </div>
      
          <div class="mb-3">
          <label for="category" class="form-label">Story Category</label><br>
          <select class="form-control" name="category">
          <option value="">-- Story Category -- </option>
          <option value="Technical">Technical</option>
          <option value="Non-Technical">Non-Technical</option>
          <option value="Testing">Testing</option>
          <option value="Design">Design</option>
          </select>
          </div>

          <div class="mb-3">
          <label for="status" class="form-label">Story Status</label><br>
          <select class="form-control" name="status">
          <option value="Backlog">Backlog</option>
          <option value="ToDo">ToDo</option>
          <option value="InProgress">InProgress</option>
          <option value="Completed">Completed</option>
          <option value="Accepted">Accepted</option>
          </select>
          </div>


          </div>
        <button type="submit" class="btn btn-info btn-lg" name="create_story">Save Story</button>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
    </form>
    <span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
    ';
    $list_of_sprints=array();

$sprint_name = "SELECT sprint_name from sprint where project_id='$id'";
  $sprint_result = mysqli_query($db, $sprint_name);
  while($sprint_array = mysqli_fetch_assoc($sprint_result)){
    $list_of_sprints[]=$sprint_array['sprint_name'];

  }

  // print_r($list_of_sprints);
   $sprint_count=count($list_of_sprints);
  //  echo $sprint_count;



    echo'
    <select class="change_sprint" style="
      display: inline;
      height: 34px;
      padding: 6px 12px;
      font-size: 14px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;"
      name="sprint_select" id="sprint_select">
        <option disabled selected>--Select Sprint--</option>';
        for ($x = 0; $x < $sprint_count; $x++) {
          echo' <option value='.$list_of_sprints[$x].'>'.$list_of_sprints[$x].'</option>';
          }
          echo'
    </select>
    <button style="width:155px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mySprint">Create Sprint</button>
    <a href="linear_regression.php" target="_blank" id="predict">Predict User Story Acceptance Time for this Project</a>
    <style>
    #predict:link, #predict:visited {
      background-color:#14a8fe;
      color:  #fff;
      border: 2px solid #182037;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      border-radius: 6px;
      font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
      font-size: 14px;
      font-weight: 400;
    }
    
    #predict:hover, #predict:active {
      background-color: #182037;
      color:  #fff;
      border-radius: 6px;
      font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
      font-size: 14px;
      font-weight: 400;
    }
    </style>
                
                    <!-- Modal -->
                    <div class="modal fade" id="mySprint" role="dialog">
                        <div class="modal-dialog">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="position:absolute; float:left;">Create Sprint</h4>
                                 </div>
    
                                <div class="modal-body">   
                                <div class="mb-3">
                                <form method="post" action="scrumboard.php?id='.$id.'">
                      
                                <input type="hidden" name="sprint_project_id" value="'.$id.'">
                                
                                <label for="sprint_name" class="form-label">Sprint Name</label>
                                <input type="text" class="form-control" name="sprint_name" placeholder="Enter Sprint Name">
                              </div>
                              <div class="mb-3">
                        
                                <label for="sprint_start_date" class="form-label">Sprint Start Date</label>
                                <input type="date" class="form-control" name="sprint_start_date" placeholder="Enter Sprint Start Date">
                              </div>
                              <div class="mb-3">
                        
                              <label for="sprint_end_date" class="form-label">Sprint End Date</label>
                              <input type="date" class="form-control" name="sprint_end_date" placeholder="Enter Sprint End Date">
                            </div>
                            
    
                                </div>
                                <button type="submit" class="btn btn-info btn-lg" name="create_sprint">Save Sprint</button>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                
    
                        </div>
                    </form>
                    
                   </div>
                   
                  
    <h2 style="color:white;">User Stories ';
    $list_of_story=array();
    $list_of_story_id=array();

    $story_name = "SELECT story_name,story_id from user_story where story_status='Backlog' and project_id='$id' ";
      $story_result = mysqli_query($db, $story_name);
      while($story_array = mysqli_fetch_assoc($story_result)){
        $list_of_story[]=$story_array['story_name'];
        $list_of_story_id[]=$story_array['story_id'];
    
      }
    
       // print_r($list_of_story_id);
       $story_count=count($list_of_story);
      //  echo $story_count;
//////////////////////////todo///////////////////////
$list_of_todo=array();
$list_of_todo_priority=array();
$list_of_todo_category=array();
$list_of_todo_id=array();
$list_of_todo_description=array();
$list_of_todo_outcome=array();
$list_of_todo_start_date=array();
$list_of_todo_end_date=array();
$list_of_todo_estimated_hrs=array();

$todo_name = "SELECT story_id,story_name,story_description,story_priority,story_category,story_outcome,start_date,end_date,estimated_hr from user_story where story_status='ToDo' and project_id='$id' ";
  $todo_result = mysqli_query($db, $todo_name);
  while($todo_array = mysqli_fetch_assoc($todo_result)){
    $list_of_todo_id[]=$todo_array['story_id'];
    $list_of_todo[]=$todo_array['story_name'];
    $list_of_todo_description[]=$todo_array['story_description'];
    $list_of_todo_priority[]=$todo_array['story_priority'];
    $list_of_todo_category[]=$todo_array['story_category'];
    $list_of_todo_outcome[]=$todo_array['story_outcome'];
    $list_of_todo_start_date[]=$todo_array['start_date'];
    $list_of_todo_end_date[]=$todo_array['end_date'];
    $list_of_todo_estimated_hrs[]=$todo_array['estimated_hr'];
  }

  $list_of_todo_count=count($list_of_todo);
  //////////////////////////in-progress///////////////////////
  $list_of_inprogress_id=array();
  $list_of_inprogress_description=array();
$list_of_inprogress=array();
$list_of_inprogress_priority=array();
$list_of_inprogress_category=array();
$list_of_inprogress_outcome=array();
$list_of_inprogress_start_date=array();
$list_of_inprogress_end_date=array();
$list_of_inprogress_estimated_hrs=array();
$inprogress_name = "SELECT story_id,story_name,story_description,story_priority,story_category,story_outcome,start_date,end_date,estimated_hr from user_story where story_status='InProgress' and project_id='$id' ";
  $inprogress_result = mysqli_query($db, $inprogress_name);
  while($inprogress_array = mysqli_fetch_assoc($inprogress_result)){
    $list_of_inprogress_id[]=$inprogress_array['story_id'];
    $list_of_inprogress[]=$inprogress_array['story_name'];
    $list_of_inprogress_description[]=$inprogress_array['story_description'];
    $list_of_inprogress_priority[]=$inprogress_array['story_priority'];
    $list_of_inprogress_category[]=$inprogress_array['story_category'];
    $list_of_inprogress_outcome[]=$inprogress_array['story_outcome'];
    $list_of_inprogress_start_date[]=$inprogress_array['start_date'];
    $list_of_inprogress_end_date[]=$inprogress_array['end_date'];
    $list_of_inprogress_estimated_hrs[]=$inprogress_array['estimated_hr'];

  }
  $list_of_inprogress_count=count($list_of_inprogress);
 //////////////////////////completed///////////////////////
 $list_of_completed_id=array();
 $list_of_completed_description=array();
$list_of_completed=array();
$list_of_completed_priority=array();
$list_of_completed_category=array();
$list_of_completed_outcome=array();
$list_of_completed_start_date=array();
$list_of_completed_end_date=array();
$list_of_completed_estimated_hrs=array();
$completed_name = "SELECT story_id,story_name,story_description,story_priority,story_category,story_outcome,start_date,end_date,estimated_hr from user_story where story_status='Completed' and project_id='$id' ";
  $completed_result = mysqli_query($db, $completed_name);
  while($completed_array = mysqli_fetch_assoc($completed_result)){
    $list_of_completed_id[]=$completed_array['story_id'];
    $list_of_completed[]=$completed_array['story_name'];
    $list_of_completed_description[]=$completed_array['story_description'];
    $list_of_completed_priority[]=$completed_array['story_priority'];
    $list_of_completed_category[]=$completed_array['story_category'];
    $list_of_completed_outcome[]=$completed_array['story_outcome'];
    $list_of_completed_start_date[]=$completed_array['start_date'];
    $list_of_completed_end_date[]=$completed_array['end_date'];
    $list_of_completed_estimated_hrs[]=$completed_array['estimated_hr'];
  }
  $list_of_completed_count=count($list_of_completed);
  //////////////////////////accepted///////////////////////
  $list_of_accepted_id=array();
  $list_of_accepted_description=array();
$list_of_accepted=array();
$list_of_accepted_priority=array();
$list_of_accepted_category=array();
$list_of_accepted_outcome=array();
$list_of_accepted_start_date=array();
$list_of_accepted_end_date=array();
$list_of_accepted_estimated_hrs=array();
$accepted_name = "SELECT story_id,story_name,story_description,story_priority,story_category,story_outcome,start_date,end_date,estimated_hr from user_story where story_status='Accepted' and project_id='$id' ";
  $accepted_result = mysqli_query($db, $accepted_name);
  while($accepted_array = mysqli_fetch_assoc($accepted_result)){
    $list_of_accepted_id[]=$accepted_array['story_id'];
    $list_of_accepted[]=$accepted_array['story_name'];
    $list_of_accepted_description[]=$accepted_array['story_description'];
    $list_of_accepted_priority[]=$accepted_array['story_priority'];
    $list_of_accepted_category[]=$accepted_array['story_category'];
    $list_of_accepted_outcome[]=$accepted_array['story_outcome'];
    $list_of_accepted_start_date[]=$accepted_array['start_date'];
    $list_of_accepted_end_date[]=$accepted_array['end_date'];
    $list_of_accepted_estimated_hrs[]=$accepted_array['estimated_hr'];

  }
  $list_of_accepted_count=count($list_of_accepted);
  //////////////////////////////////////////////////////////////////////////////
    echo'
    <select class="select_story" style="
    transform: translateX(86%);
      display: inline;
      height: 34px;
      padding: 6px 12px;
      font-size: 14px;
      line-height: 1.42857143;
      color: #555;
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;"
      name="select_story" id="select_story">
        <option disabled selected>--Select Story--</option>';
        for ($x = 0; $x < $story_count; $x++) {
          echo' <option value='.$list_of_story_id[$x].'>'.$list_of_story[$x].'</option>';
          }
          echo'
    </select>
    <p style="float:right; transform: translateX(-833%); text-transform:capitalize; " id="sprint_display"> </p>
    </h2>
    <p id="story_display"> </p>
    
    <div class="column" style="display: inline-block; width:300px; height:500px; overflow:auto; overflow-x:hidden;">';
   


    $story_info = mysqli_query($db, "SELECT * FROM user_story where project_id='$id' and story_status='Backlog'");

    while ($story_info_array = mysqli_fetch_array($story_info)) 
    {  
        $story_name = $story_info_array['story_name'];
        $priority =$story_info_array['story_priority'];
        $category =$story_info_array['story_category'];
       
    
echo'

<div class="row">
            <div  style="width: 300px; border-right-style: solid; border-color:white;">
                <div class="demo-content">
                
                
    <div class="card">
    <div class="card-header" style="background-color:#343a40;">
    <h3 class="card-title" style="color:white; text-transform: uppercase;" >'.$story_name.'</h3>
    </div>
    <div class="card-body">
      
      <p class="card-text">'.$priority.'</p>
      <p class="card-text">'.$category.'</p>
    </div>
    </div>
    <br>
                </div>
            </div>
            
        </div>

   
';

    }

    echo ' </div> </br><div class="column" style="display:block; 
    ">
   


    <div class="table-wrap" style="overflow: hidden; width: 1000px;">
    <table class="table">
    <thead class="thead-primary">
    <tr>

    <th>TO-DO</th>
    <th>In Progress</th>
    <th>Completed</th>
    <th>Accepted</th>
    </thead>
    </tr>
    
    
    <tbody>
    <td>';
    for ($x = 0; $x < $list_of_todo_count; $x++) {

      
      echo'<div class="card" style="width: 18rem; border:none;">
      <img style="background-color:#f4f6fc;"src="todo.png" class="card-img-top" data-toggle="modal" data-target="#'.$list_of_todo_id[$x].'">
      <div class="card-body" style="padding:0rem !important;">
      <p class="card-text centered">';echo '<strong>';echo $list_of_todo[$x];echo '</strong>';echo'</br>';echo $list_of_todo_priority[$x];echo'</br>'.$list_of_todo_category[$x];echo'</p>
      <div class="modal fade" id="'.$list_of_todo_id[$x].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
      
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content" style="height:1175px; width:600px;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="position:absolute; float:left;">Sprint:
            <p style="float:right; text-transform:capitalize; " class="sprint_display_title"> </p>
            </h4>
            <br>
  
          </div>
          <div class="modal-body">
          <div class="mb-3">
          <form method="post" action="scrumboard.php?id='.$id.'">
          <input type="hidden" name="todo_story_id" value="'.$list_of_todo_id[$x].'">
          <input type="hidden" name="project_id" value="'.$id.'">

         <input type="hidden" name="username" value="'.$username.'">
          <div class="mb-3">
          <label for="todo_title" class="form-label"  style="display:absolute; float:left; ">Name:</label>
          <input type="text" class="form-control" name="todo_title" value="'.$list_of_todo[$x].'">
          </div>
          
          <div class="mb-3">

    <label for="exampleFormControlTextarea1" class="form-label"  style="display:absolute; float:left; ">Description</label>
    <textarea id="exampleFormControlTextarea1" class="form-control" name="todo_description"  rows="3">'.$list_of_todo_description[$x].'</textarea>
  </div>
  <div class="mb-3">

  <label for="story_outcome" class="form-label" style="display:absolute; float:left; ">Story Outcome</label>
  <input type="text" class="form-control" name="story_outcome" value="'.$list_of_todo_outcome[$x].'">
  </div>

    <div class="mb-3">
    <label for="priority" class="form-label"  style="display:absolute; float:left; ">Select Priority</label><br>
    <select class="form-control" name="priority">
    <option  value="'.$list_of_todo_priority[$x].'">'.$list_of_todo_priority[$x].' </option>
    <option value="Critical">Critical</option>
    <option value="High">High</option>
    <option value="Medium">Medium</option>
    <option value="Low">Low</option>
    </select>
    </div>

    <div class="mb-3">
    <label for="category" class="form-label"  style="display:absolute; float:left; ">Story Category</label><br>
    <select class="form-control" name="category">
    <option value="'.$list_of_todo_category[$x].'">'.$list_of_todo_category[$x].'</option>
    <option value="Technical">Technical</option>
    <option value="Non-Technical">Non-Technical</option>
    <option value="Testing">Testing</option>
    <option value="Design">Design</option>
    </select>
    </div>

    <div class="mb-3">

    <label for="estimated_hours" class="form-label"  style="display:absolute; float:left; ">Estimated Hours</label>
    <input type="text" class="form-control" name="estimated_hours" placeholder="Enter estimated hours" value="'.$list_of_todo_estimated_hrs[$x].'">
    </div>

    <div class="mb-3">';
    $value_todo_start_date=date("Y-m-d\TH:i:s", strtotime($list_of_todo_start_date[$x]));
    echo'
    <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
     
    <input type="datetime-local" class="form-control" name="start_date" value="'.$value_todo_start_date.'">
    </div>

    <div class="mb-3">';
    $value_todo_end_date=date("Y-m-d\TH:i:s", strtotime($list_of_todo_end_date[$x]));
    echo'

    <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
    
    <input type="datetime-local" class="form-control" name="end_date" value="'.$value_todo_end_date.'" >
    </div>  

    <div class="mb-3">
    <label for="status" class="form-label"  style="display:absolute; float:left; ">Status</label><br>
    <select class="form-control" name="status">
    <option value="ToDo">ToDo</option>
    <option value="InProgress">InProgress</option>
    <option value="Completed">Completed</option>
    <option value="Accepted">Accepted</option>
    </select>
    </div>

          </div>
          <button type="submit" class="btn btn-info btn-lg" name="update_story_todo">Update</button>
          <button type="button" class="btn btn-info btn-lg" name="add_task" data-toggle="modal" data-target="#task">Add task</button>
          <div class="table-wrap" style="overflow: scroll; height: 313px;">
          <table class="table table-bordered">
    <thead style="background-color:black !important;">
    <tr>
    <th style="color:black;">Sr.No</th>              
    <th style="color:black;">Task name</th>
    <th style="color:black;">Description</th>
    <th style="color:black;">Start Date</th>
    <th style="color:black;">End Date</th>
    </tr>';
     $task_info = mysqli_query($db, "SELECT * FROM task where story_id='".$list_of_todo_id[$x]."'");
    echo ' 
    </thead>
    <tbody>
    ';      
    $c = 1;
   while ($task = mysqli_fetch_array($task_info)) 
   
 {   
       $name=$task['task_name'];
       $description =$task['task_description'];
       $start_date =$task['start_date'];
       $end_date =$task['end_date'];

       echo '<tr>

     <th scope="row" class="scope" >' . $c++ . '</th>
     <td>' . $name .'</td>
     <td>' . $description. '</td>
     <td>' .$start_date . '</td>
     <td>' . $end_date. '</td>
     ';}
     echo'
    </tbody>
  </table>
        
</div>





          <div class="modal fade task" id="task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">

          <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="position:absolute; float:left;">Add Task:
              
              </h4>
              <br>
      
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <form method="post" action="scrumboard.php?id='.$id.'">
            
            <label for="task_name" class="form-label"  style="display:absolute; float:left; "> Task Name</label>
            <input type="text" class="form-control" name="task_name" placeholder="Enter Task name ">
          </div>
          <div class="mb-3">
          <input type="hidden" name="story_id" value="'.$list_of_todo_id[$x].'">
            <label for="task_description" class="form-label"  style="display:absolute; float:left; ">Description</label>
            <input type="text" class="form-control" name="task_description" placeholder="Enter Task Description">
          </div>
        
        
            <div class="mb-3">
        
            <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
            <input type="date" class="form-control" name="task_start_date" placeholder="">
            </div>
        
            <div class="mb-3">
        
            <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
            <input type="date" class="form-control" name="task_end_date" placeholder="">
            </div>
           
            
      
      
      
      
            </div>
            <button type="submit" class="btn btn-info btn-lg" name="task_completed">Add Task</button>

        
      
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
        </form>
      
      
        </div>
         </div>
       









          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
      </form>


      </div>
       </div>
      </div>
    </div> ';
      }
      echo'


</td>

<td>';
for ($x = 0; $x < $list_of_inprogress_count; $x++) {
   echo' <div class="card" style="width: 18rem;  border:none;">
  <img style="background-color: #ffffff;" src="in-progress.png" class="card-img-top" data-toggle="modal" data-target="#'.$list_of_inprogress_id[$x].'">
  <div class="card-body" style="padding:0rem !important;">
  <p class="card-text centered">';echo '<strong>';echo $list_of_inprogress[$x];echo '</strong>';echo'</br>';echo $list_of_inprogress_priority[$x];echo'</br>'.$list_of_inprogress_category[$x];echo'</p>
  <div class="modal fade" id="'.$list_of_inprogress_id[$x].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog">
      
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" style="position:absolute; float:left;">Sprint:
      <p style="float:right; text-transform:capitalize; " class="sprint_display_title"> </p>
      </h4>
      <br>

    </div>
    <div class="modal-body">
    <div class="mb-3">
    <form method="post" action="scrumboard.php?id='.$id.'">
    <input type="hidden" name="inprogress_story_id" value="'.$list_of_inprogress_id[$x].'">
    <input type="hidden" name="project_id" value="'.$id.'">

    <input type="hidden" name="username" value="'.$username.'">
   
    <div class="mb-3">
    <label for="inprogress_title" class="form-label"  style="display:absolute; float:left; ">Name:</label>
    <input type="text" class="form-control" name="inprogress_title" value="'.$list_of_inprogress[$x].'">
    </div>
    
    <div class="mb-3">

<label for="exampleFormControlTextarea2" class="form-label"  style="display:absolute; float:left; ">Description</label>
<textarea id="exampleFormControlTextarea2" class="form-control" name="inprogress_description"  rows="3">'.$list_of_inprogress_description[$x].'</textarea>
</div>
<div class="mb-3">

<label for="inprogress_outcome" class="form-label" style="display:absolute; float:left; ">Story Outcome</label>
<input type="text" class="form-control" name="story_outcome" value="'.$list_of_inprogress_outcome[$x].'">
</div>

<div class="mb-3">
<label for="priority" class="form-label"  style="display:absolute; float:left; ">Select Priority</label><br>
<select class="form-control" name="priority">
<option  value="'.$list_of_inprogress_priority[$x].'">'.$list_of_inprogress_priority[$x].' </option>
<option value="Critical">Critical</option>
<option value="High">High</option>
<option value="Medium">Medium</option>
<option value="Low">Low</option>
</select>
</div>

<div class="mb-3">
<label for="category" class="form-label"  style="display:absolute; float:left; ">Story Category</label><br>
<select class="form-control" name="category">
<option value="'.$list_of_inprogress_category[$x].'">'.$list_of_inprogress_category[$x].'</option>
<option value="Technical">Technical</option>
<option value="Non-Technical">Non-Technical</option>
<option value="Testing">Testing</option>
<option value="Design">Design</option>
</select>
</div>

<div class="mb-3">';
$value_inprogress_start_date=date("Y-m-d\TH:i:s", strtotime($list_of_inprogress_start_date[$x]));
echo'

<label for="estimated_hours" class="form-label"  style="display:absolute; float:left; ">Estimated Hours</label>
<input type="text" class="form-control" name="estimated_hours" placeholder="Enter estimated hours" value="'.$list_of_inprogress_estimated_hrs[$x].'">
</div>

<div class="mb-3">

<label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
<input type="datetime-local" class="form-control" name="start_date" value="'.$value_inprogress_start_date.'" >
</div>

<div class="mb-3">';
$value_inprogress_end_date=date("Y-m-d\TH:i:s", strtotime($list_of_inprogress_end_date[$x]));
echo'

<label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
<input type="datetime-local" class="form-control" name="end_date" value="'.$value_inprogress_end_date.'" >
</div>  

<div class="mb-3">
<label for="status" class="form-label"  style="display:absolute; float:left; ">Status</label><br>
<select class="form-control" name="status">
<option value="InProgress">InProgress</option>
<option value="ToDo">ToDo</option>
<option value="Completed">Completed</option>
<option value="Accepted">Accepted</option>
</select>
</div>

    </div>
    <button type="submit" class="btn btn-info btn-lg" name="update_story_inprogress">Update</button>
   

    <button type="button" class="btn btn-info btn-lg" name="add_task" data-toggle="modal" data-target="#task_inprogress">Add task</button>

    <div class="table-wrap" style="overflow: scroll; height: 313px;">
    <table class="table table-bordered">
<thead style="background-color:black !important;">
<tr>
<th style="color:black;">Sr.No</th>              
<th style="color:black;">Task name</th>
<th style="color:black;">Description</th>
<th style="color:black;">Start Date</th>
<th style="color:black;">End Date</th>
</tr>';
$task_info = mysqli_query($db, "SELECT * FROM task where story_id='".$list_of_inprogress_id[$x]."'");
echo ' 
</thead>
<tbody>
';      
$c = 1;
while ($task = mysqli_fetch_array($task_info)) 

{   
 $name=$task['task_name'];
 $description =$task['task_description'];
 $start_date =$task['start_date'];
 $end_date =$task['end_date'];

 echo '<tr>

<th scope="row" class="scope" >' . $c++ . '</th>
<td>' . $name .'</td>
<td>' . $description. '</td>
<td>' .$start_date . '</td>
<td>' . $end_date. '</td>
';}
echo'
</tbody>
</table>
  
</div>



















    <div class="modal fade task" id="task_inprogress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">

    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="position:absolute; float:left;">Add Task:
        
        </h4>
        <br>

      </div>
      <div class="modal-body">
      <div class="mb-3">
      <form method="post" action="scrumboard.php?id='.$id.'">
      <input type="hidden" name="story_id" value="'.$list_of_inprogress_id[$x].'">
      
      <label for="task_name" class="form-label"  style="display:absolute; float:left; "> Task Name</label>
      <input type="text" class="form-control" name="task_name" placeholder="Enter Task name ">
    </div>
    <div class="mb-3">
  
      <label for="task_description" class="form-label"  style="display:absolute; float:left; ">Description</label>
      <input type="text" class="form-control" name="task_description" placeholder="Enter Task Description">
    </div>
  
  
      <div class="mb-3">
  
      <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
      <input type="date" class="form-control" name="task_start_date" placeholder="">
      </div>
  
      <div class="mb-3">
  
      <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
      <input type="date" class="form-control" name="task_end_date" placeholder="">
      </div>
     
      




      </div>
      <button type="submit" class="btn btn-info btn-lg" name="task_completed">Add Task</button>



      

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
  </form>


  </div>
   </div>





    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
  
</div>
</form>


</div>
 </div>

  </div>
</div>';
}
echo'
</td>

<td>';
for ($x = 0; $x < $list_of_completed_count; $x++) {
  echo'
<div class="card" style="width: 18rem;  border:none;">
<img style="background-color:#f4f6fc;" src="completed.png" class="card-img-top" class="card-img-top" data-toggle="modal" data-target="#'.$list_of_completed_id[$x].'">
<div class="card-body" style="padding:0rem !important;">
<p class="card-text centered">';echo '<strong>';echo $list_of_completed[$x];echo '</strong>';echo'</br>';echo $list_of_completed_priority[$x];echo'</br>'.$list_of_completed_category[$x];echo'</p>
<div class="modal fade" id="'.$list_of_completed_id[$x].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">

<div class="modal-dialog">
      
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" style="position:absolute; float:left;">Sprint:
      <p style="float:right; text-transform:capitalize; " class="sprint_display_title"> </p>
      </h4>
      <br>

    </div>
    <div class="modal-body">
    <div class="mb-3">
    <form method="post" action="scrumboard.php?id='.$id.'">
    <input type="hidden" name="completed_story_id" value="'.$list_of_completed_id[$x].'">
    <input type="hidden" name="project_id" value="'.$id.'">

         <input type="hidden" name="username" value="'.$username.'">
    <div class="mb-3">
    <label for="completed_title" class="form-label"  style="display:absolute; float:left; ">Name:</label>
    <input type="text" class="form-control" name="completed_title" value="'.$list_of_completed[$x].'">
    </div>
    
    <div class="mb-3">

<label for="exampleFormControlTextarea3" class="form-label"  style="display:absolute; float:left; ">Description</label>
<textarea id="exampleFormControlTextarea3" class="form-control" name="completed_description"  rows="3">'.$list_of_completed_description[$x].'</textarea>
</div>
<div class="mb-3">

<label for="completed_outcome" class="form-label" style="display:absolute; float:left; ">Story Outcome</label>
<input type="text" class="form-control" name="story_outcome" value="'.$list_of_completed_outcome[$x].'">
</div>

<div class="mb-3">
<label for="priority" class="form-label"  style="display:absolute; float:left; ">Select Priority</label><br>
<select class="form-control" name="priority">
<option  value="'.$list_of_completed_priority[$x].'">'.$list_of_completed_priority[$x].' </option>
<option value="Critical">Critical</option>
<option value="High">High</option>
<option value="Medium">Medium</option>
<option value="Low">Low</option>
</select>
</div>

<div class="mb-3">
<label for="category" class="form-label"  style="display:absolute; float:left; ">Story Category</label><br>
<select class="form-control" name="category">
<option value="'.$list_of_completed_category[$x].'">'.$list_of_completed_category[$x].'</option>
<option value="Technical">Technical</option>
<option value="Non-Technical">Non-Technical</option>
<option value="Testing">Testing</option>
<option value="Design">Design</option>
</select>
</div>

<div class="mb-3">

<label for="estimated_hours" class="form-label"  style="display:absolute; float:left; ">Estimated Hours</label>
<input type="text" class="form-control" name="estimated_hours" placeholder="Enter estimated hours" value="'.$list_of_completed_estimated_hrs[$x].'">
</div>

<div class="mb-3">';
$value_completed_start_date=date("Y-m-d\TH:i:s", strtotime($list_of_completed_start_date[$x]));
echo'

<label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
<input type="datetime-local" class="form-control" name="start_date" value="'.$value_completed_start_date.'" >
</div>

<div class="mb-3">';
$value_completed_end_date=date("Y-m-d\TH:i:s", strtotime($list_of_completed_end_date[$x]));
echo'

<label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
<input type="datetime-local" class="form-control" name="end_date" value="'.$value_completed_end_date.'" >
</div>  

<div class="mb-3">
<label for="status" class="form-label"  style="display:absolute; float:left; ">Status</label><br>
<select class="form-control" name="status">
<option value="Completed">Completed</option>
<option value="ToDo">ToDo</option>
<option value="InProgress">InProgress</option>
<option value="Accepted">Accepted</option>
</select>
</div>

    </div>
    <button type="submit" class="btn btn-info btn-lg" name="update_story_completed">Update</button>
    

    <button type="button" class="btn btn-info btn-lg" name="add_task" data-toggle="modal" data-target="#task_completed">Add task</button>


    <div class="table-wrap" style="overflow: scroll; height: 313px;">
    <table class="table table-bordered">
<thead style="background-color:black !important;">
<tr>
<th style="color:black;">Sr.No</th>              
<th style="color:black;">Task name</th>
<th style="color:black;">Description</th>
<th style="color:black;">Start Date</th>
<th style="color:black;">End Date</th>
</tr>';
$task_info = mysqli_query($db, "SELECT * FROM task where story_id='".$list_of_completed_id[$x]."'");
echo ' 
</thead>
<tbody>
';      
$c = 1;
while ($task = mysqli_fetch_array($task_info)) 

{   
 $name=$task['task_name'];
 $description =$task['task_description'];
 $start_date =$task['start_date'];
 $end_date =$task['end_date'];

 echo '<tr>

<th scope="row" class="scope" >' . $c++ . '</th>
<td>' . $name .'</td>
<td>' . $description. '</td>
<td>' .$start_date . '</td>
<td>' . $end_date. '</td>
';}
echo'
</tbody>
</table>
  
</div>







    <div class="modal fade task" id="task_completed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">

    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="position:absolute; float:left;">Add Task:
        
        </h4>
        <br>

      </div>
      <div class="modal-body">
      <div class="mb-3">
      <form method="post" action="scrumboard.php?id='.$id.'">
      <input type="hidden" name="story_id" value="'.$list_of_completed_id[$x].'">
      <label for="task_name" class="form-label"  style="display:absolute; float:left; "> Task Name</label>
      <input type="text" class="form-control" name="task_name" placeholder="Enter Task name ">
    </div>
    <div class="mb-3">
  
      <label for="task_description" class="form-label"  style="display:absolute; float:left; ">Description</label>
      <input type="text" class="form-control" name="task_description" placeholder="Enter Task Description">
    </div>
  
  
      <div class="mb-3">
  
      <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
      <input type="date" class="form-control" name="task_start_date" placeholder="">
      </div>
  
      <div class="mb-3">
  
      <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
      <input type="date" class="form-control" name="task_end_date" placeholder="">
      </div>
     
      




      </div>
      <button type="submit" class="btn btn-info btn-lg" name="task_completed">Add Task</button>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
  </form>


  </div>
   </div>











    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
  
</div>
</form>


</div>
 </div>

</div>
</div>';
}
echo'
</td>

<td>';
for ($x = 0; $x < $list_of_accepted_count; $x++) {
  echo'
<div class="card" style="width: 18rem;  border:none;">
<img style="background-color:#ffffff;" src="accepted.png" class="card-img-top" data-toggle="modal" data-target="#'.$list_of_accepted_id[$x].'">
<div class="card-body" style="padding:0rem !important;">
<p class="card-text centered">';echo '<strong>';echo $list_of_accepted[$x];echo '</strong>';echo'</br>';echo $list_of_accepted_priority[$x];echo'</br>'.$list_of_accepted_category[$x];echo'</p>
<div class="modal fade" id="'.$list_of_accepted_id[$x].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">

<div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="position:absolute; float:left;">Sprint:
            <p style="float:right; text-transform:capitalize; " class="sprint_display_title"> </p>
            </h4>
            <br>
  
          </div>
          <div class="modal-body">
          <div class="mb-3">
          <form method="post" action="scrumboard.php?id='.$id.'">
          <input type="hidden" name="accepted_story_id" value="'.$list_of_accepted_id[$x].'">
         
          <div class="mb-3">
          <label for="accepted_title" class="form-label"  style="display:absolute; float:left; ">Name:</label>
          <input type="text" class="form-control" name="accepted_title" value="'.$list_of_accepted[$x].'">
          </div>
          
          <div class="mb-3">

    <label for="exampleFormControlTextarea4" class="form-label"  style="display:absolute; float:left; ">Description</label>
    <textarea id="exampleFormControlTextarea4" class="form-control" name="accepted_description"  rows="3">'.$list_of_accepted_description[$x].'</textarea>
  </div>
  <div class="mb-3">

  <label for="story_outcome" class="form-label" style="display:absolute; float:left; ">Story Outcome</label>
  <input type="text" class="form-control" name="story_outcome" value="'.$list_of_accepted_outcome[$x].'">
  </div>

    <div class="mb-3">
    <label for="priority" class="form-label"  style="display:absolute; float:left; ">Select Priority</label><br>
    <select class="form-control" name="priority">
    <option  value="'.$list_of_accepted_priority[$x].'">'.$list_of_accepted_priority[$x].' </option>
    <option value="Critical">Critical</option>
    <option value="High">High</option>
    <option value="Medium">Medium</option>
    <option value="Low">Low</option>
    </select>
    </div>

    <div class="mb-3">
    <label for="category" class="form-label"  style="display:absolute; float:left; ">Story Category</label><br>
    <select class="form-control" name="category">
    <option value="'.$list_of_accepted_category[$x].'">'.$list_of_accepted_category[$x].'</option>
    <option value="Technical">Technical</option>
    <option value="Non-Technical">Non-Technical</option>
    <option value="Testing">Testing</option>
    <option value="Design">Design</option>
    </select>
    </div>

    <div class="mb-3">

    <label for="estimated_hours" class="form-label"  style="display:absolute; float:left; ">Estimated Hours</label>
    <input type="text" class="form-control" name="estimated_hours" placeholder="Enter estimated hours" value="'.$list_of_accepted_estimated_hrs[$x].'">
    </div>

    <div class="mb-3">';
    $value_accepted_start_date=date("Y-m-d\TH:i:s", strtotime($list_of_accepted_start_date[$x]));
    echo'

    <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
    <input type="datetime-local" class="form-control" name="start_date" value="'.$value_accepted_start_date.'" >
    </div>

    <div class="mb-3">';
    $value_accepted_end_date=date("Y-m-d\TH:i:s", strtotime($list_of_accepted_end_date[$x]));
    echo'

    <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
    <input type="datetime-local" class="form-control" name="end_date" value="'.$value_accepted_end_date.'" >
    </div>  

    <div class="mb-3">
    <label for="status" class="form-label"  style="display:absolute; float:left; ">Status</label><br>
    <select class="form-control" name="status">
    <option value="Accepted">Accepted</option>
    <option value="ToDo">ToDo</option>
    <option value="InProgress">InProgress</option>
    <option value="Completed">Completed</option>
    
    </select>
    </div>

          </div>
          <button type="submit" class="btn btn-info btn-lg" name="update_story_accepted">Update</button>
          

          <button type="button" class="btn btn-info btn-lg" name="add_task" data-toggle="modal" data-target="#task_accepted">Add task</button>

          <div class="table-wrap" style="overflow: scroll; height: 313px;">
          <table class="table table-bordered">
    <thead style="background-color:black !important;">
    <tr>
    <th style="color:black;">Sr.No</th>              
    <th style="color:black;">Task name</th>
    <th style="color:black;">Description</th>
    <th style="color:black;">Start Date</th>
    <th style="color:black;">End Date</th>
    </tr>';
     $task_info = mysqli_query($db, "SELECT * FROM task where story_id='".$list_of_accepted_id[$x]."'");
    echo ' 
    </thead>
    <tbody>
    ';      
    $c = 1;
   while ($task = mysqli_fetch_array($task_info)) 
   
 {   
       $name=$task['task_name'];
       $description =$task['task_description'];
       $start_date =$task['start_date'];
       $end_date =$task['end_date'];

       echo '<tr>

     <th scope="row" class="scope" >' . $c++ . '</th>
     <td>' . $name .'</td>
     <td>' . $description. '</td>
     <td>' .$start_date . '</td>
     <td>' . $end_date. '</td>
     ';}
     echo'
    </tbody>
  </table>
        
</div>











          <div class="modal fade task" id="task_accepted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
      
          <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="position:absolute; float:left;">Add Task:
              
              </h4>
              <br>
      
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <form method="post" action="scrumboard.php?id='.$id.'">
            <input type="hidden" name="story_id" value="'.$list_of_accepted_id[$x].'">
            <label for="task_name" class="form-label"  style="display:absolute; float:left; "> Task Name</label>
            <input type="text" class="form-control" name="task_name" placeholder="Enter Task name ">
          </div>
          <div class="mb-3">
        
            <label for="task_description" class="form-label"  style="display:absolute; float:left; ">Description</label>
            <input type="text" class="form-control" name="task_description" placeholder="Enter Task Description">
          </div>
        
        
            <div class="mb-3">
        
            <label for="start_date" class="form-label"  style="display:absolute; float:left; ">Start Date</label>
            <input type="date" class="form-control" name="task_start_date" placeholder="">
            </div>
        
            <div class="mb-3">
        
            <label for="end_date" class="form-label"  style="display:absolute; float:left; ">End Date</label>
            <input type="date" class="form-control" name="task_end_date" placeholder="">
            </div>
           
            
      
      
      
      
            </div>
            <button type="submit" class="btn btn-info btn-lg" name="task_completed">Add Task</button>
      
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
        </form>
      
      
        </div>
         </div>
      




          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
      </form>


      </div>
       </div>
      



</div>
</div>';
}
echo'
</td>
</td>
    
    </div>
</div>';
   
}

 ?>
 </body>
 
 <script>
   $(document).ready(function(){
    $('#sprint_select').change(function(){
      var sprint = $(this).val();
      
      $.ajax({
       url:'fetch_sprint.php',
        type:'POST',
       data:{value:sprint},
        dataType:'JSON',
        success:function(data) {
            
            $("#sprint_display").html(data);
            $(".sprint_display_title").html(data);
            
        }
        
   
});

});


$('#select_story').change(function(){
      var story = $(this).val();
      
      $.ajax({
       url:'fetch_story.php',
        type:'POST',
       data:{value:story},
        dataType:'JSON',
        success:function(data) {
           
            $("#story_display").html(data);
            location.reload();
            alert(data);
            
        }
        
   
});

});
   });

 
    </script>
 <style>
  .navbar-text {
    float: right; }

    #navbarText{
      font-size: 20px;

    }
    body{
        background-image: url('https://nmrql.com/wp-content/uploads/2017/11/shutterstock_695385187-scaled.jpg');
background-color: #d7edef;
background-size: cover;
background-repeat: repeat;
      /* background-image: url('https://thumbs.dreamstime.com/b/agile-concept-blurred-city-lights-agile-concept-blurred-city-abstract-lights-background-157530337.jpg'); */
      /* repeat:no-repeat fixed center; background-color: #000000; background-size: cover;
      background-color: rgba(255, 255, 255, -2.514);
  background-blend-mode: overlay; */
  /* background-color: #d7edef; */
    }
    .table thead.thead-primary {
    background: #343a40;
}

.heading-section{
  font-family: 'Slabo 27px', serif;
  font-size: 52px;
}
.navbar-nav{
  
  transform: translateX(90%);
  transform: translateY(32%);
}
.navbar-dark .navbar-text {
    color: rgb(20 168 254);
}
.btn-info {
   
    background-color: #14a8fe;
}


.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}
.dropbtn {
  background-color: #14a8fe;
  color: white;
  padding: 8px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  text-align: center;
}

.dropdown {
  position: relative;
  display: inline-block;
}


.demo-content{
       
        font-size: 18px;
        margin-bottom: 15px;
    }
    .demo-content.bg-alt{
        /* background: #abb1b8; */
    }
 .container{
  display: inline-block;
  width: 1400px;
  max-width:2000px;
  margin-right:10px;
  margin-left:10px;
  
 }
 .column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

.centered{
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
}
.modal.fade.task.in{
  padding-left: 0px !important;
  
}
  </style>
 </html>