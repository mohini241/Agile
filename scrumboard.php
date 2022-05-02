<?php 
  session_start(); 
  include 'connection.php';
  include 'save_story.php';
  include 'save_sprint.php';
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

$sprint_name = "SELECT sprint_name from sprint";
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

    $story_name = "SELECT story_name,story_id from user_story where story_status='Backlog' ";
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
$todo_name = "SELECT story_name,story_priority,story_category from user_story where story_status='ToDo' ";
  $todo_result = mysqli_query($db, $todo_name);
  while($todo_array = mysqli_fetch_assoc($todo_result)){
    $list_of_todo[]=$todo_array['story_name'];
    $list_of_todo_priority[]=$todo_array['story_priority'];
    $list_of_todo_category[]=$todo_array['story_category'];

  }
  $list_of_todo_count=count($list_of_todo);
  //////////////////////////in-progress///////////////////////
$list_of_inprogress=array();
$list_of_inprogress_priority=array();
$list_of_inprogress_category=array();
$inprogress_name = "SELECT story_name,story_priority,story_category from user_story where story_status='InProgress' ";
  $inprogress_result = mysqli_query($db, $inprogress_name);
  while($inprogress_array = mysqli_fetch_assoc($inprogress_result)){
    $list_of_inprogress[]=$inprogress_array['story_name'];
    $list_of_inprogress_priority[]=$inprogress_array['story_priority'];
    $list_of_inprogress_category[]=$inprogress_array['story_category'];

  }
  $list_of_inprogress_count=count($list_of_inprogress);
 //////////////////////////completed///////////////////////
$list_of_completed=array();
$list_of_completed_priority=array();
$list_of_completed_category=array();
$completed_name = "SELECT story_name,story_priority,story_category from user_story where story_status='Completed' ";
  $completed_result = mysqli_query($db, $completed_name);
  while($completed_array = mysqli_fetch_assoc($completed_result)){
    $list_of_completed[]=$completed_array['story_name'];
    $list_of_completed_priority[]=$completed_array['story_priority'];
    $list_of_completed_category[]=$completed_array['story_category'];

  }
  $list_of_completed_count=count($list_of_completed);
  //////////////////////////accepted///////////////////////
$list_of_accepted=array();
$list_of_accepted_priority=array();
$list_of_accepted_category=array();
$accepted_name = "SELECT story_name,story_priority,story_category from user_story where story_status='Accepted' ";
  $accepted_result = mysqli_query($db, $accepted_name);
  while($accepted_array = mysqli_fetch_assoc($accepted_result)){
    $list_of_accepted[]=$accepted_array['story_name'];
    $list_of_accepted_priority[]=$accepted_array['story_priority'];
    $list_of_accepted_category[]=$accepted_array['story_category'];

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
      <img style="background-color:#f4f6fc;"src="todo.png" class="card-img-top" alt="...">
      <div class="card-body" style="padding:0rem !important;">
              
        <p class="card-text centered"><strong>';echo $list_of_todo[$x];echo'</strong></br>'.$list_of_todo_priority[$x];echo'</br>'.$list_of_todo_category[$x];echo'</p>
      </div>
    </div> ';
      }
      echo'


</td>

<td>';
for ($x = 0; $x < $list_of_inprogress_count; $x++) {
   echo' <div class="card" style="width: 18rem;  border:none;">
  <img style="background-color: #ffffff;" src="inprogress.png" class="card-img-top" alt="...">
  <div class="card-body" style="padding:0rem !important;">
    <p class="card-text centered"><strong>';echo $list_of_inprogress[$x];echo'</strong></br>'.$list_of_inprogress_priority[$x];echo'</br>'.$list_of_inprogress_category[$x];echo'</p>
  </div>
</div>';
}
echo'
</td>

<td>';
for ($x = 0; $x < $list_of_completed_count; $x++) {
  echo'
<div class="card" style="width: 18rem;  border:none;">
<img style="background-color:#f4f6fc;" src="completed.png" class="card-img-top" alt="...">
<div class="card-body" style="padding:0rem !important;">
  <p class="card-text centered"><strong>';echo $list_of_completed[$x];echo'</strong></br>'.$list_of_completed_priority[$x];echo'</br>'.$list_of_completed_category[$x];echo'</p>
</div>
</div>';
}
echo'
</td>

<td>';
for ($x = 0; $x < $list_of_accepted_count; $x++) {
  echo'
<div class="card" style="width: 18rem;  border:none;">
<img style="background-color:#ffffff;" src="accepted.png" class="card-img-top" alt="...">
<div class="card-body" style="padding:0rem !important;">
  <p class="card-text centered"><strong>';echo $list_of_accepted[$x];echo'</strong></br>'.$list_of_accepted_priority[$x];echo'</br>'.$list_of_accepted_category[$x];echo'</p>
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
  </style>
 </html>