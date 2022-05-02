<?php
include 'connection.php';
// echo $_GET['status'];
// echo $_GET['title'];
if ($_GET['status'] == 'active')
{
    $query3 = "UPDATE project set status='inactive' where title='".$_GET['title']."'"; 
    $result3 = mysqli_query($db, $query3);
}
if ($_GET['status'] == 'inactive')
{
    $query3 = "UPDATE project set status='active' where title='".$_GET['title']."'"; 
    $result3 = mysqli_query($db, $query3);
}

header('Location:index.php');
?>