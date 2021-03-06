<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Linear Regression</title>
		<!-- Bootstrap -->
			<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="bootstrap/js/jquery-1.11.3.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript"src="js/jquery.flot.min.js"></script>
		<script type="text/javascript"src="js/regression.min.js"></script>
		<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=AM_HTMLorMML-full"></script>
		<style>
			html, body{
				margin: 0;
				padding: 0;
				font-family: "Helvetica", sans-serif;
				text-align: center;

			}
			.container2{
				margin: 0 auto;
				width: auto;
				max-width: 1170px;
			}
			.graph{
				width: auto;
				max-width: 1170px;
				height: 500px;
			}
		</style>
	</head>
<body>
<div class="container">
<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


session_start(); 
include 'connection.php';
$id=$_SESSION['id'];
// echo $id;


$project_hr_query = "select estimated_hr,actual_hr from user_story where project_id='$id'";
$project_hr = mysqli_query($db, $project_hr_query);
while($project_hr_array = mysqli_fetch_assoc($project_hr)){
$array_of_estimated_hr[]=$project_hr_array['estimated_hr'];
$array_of_actual_hr[]=$project_hr_array['actual_hr'];
}
// print_r($array_of_estimated_hr);
// print_r($array_of_actual_hr);
$List_of_estimated_hr = implode(', ', $array_of_estimated_hr);
$List_of_actual_hr=implode(', ', $array_of_actual_hr);
// print_r($List_of_estimated_hr);
// print_r($List_of_actual_hr);

 $x=$array_of_estimated_hr;  // X Variable
 $y=$array_of_actual_hr; // Y Variable
// Check if there are values to Solve
if (!isset($List_of_estimated_hr))
	{
		die("Input Value for X a is required");
	}
	
	if ( strlen( $List_of_estimated_hr ) <= 0 )
	{
	die("Input Value for X b is required");
	}
	
if (!isset($List_of_actual_hr))
	{
		die("Input Value for Y is required");
	}
	
	if ( strlen($List_of_actual_hr ) <= 0 )
	{
	die("Input Value for X c is required");
	}
	
if (!isset($_POST['Regression']))
	{
		die("Select a Plot Method");
	}
// End Check if there are values to Solve

$plot=$_POST['Regression'];


$n=count($x); // Number of elements

if (count($x) != count($y)) //Check that number of elements are exact for X and Y
{
	die("Number of elements in X does not equal number of elements in Y");
}

// Check for numbers only
foreach ($x as $testcase)  // X values
	{
		if (is_numeric($testcase)) 
			{
				// echo "The string $testcase consists of all numbers.\n";
			} 
		else 
			{
				// echo "The string $testcase does not consist of numbers.\n";
				die("Check input of X variable. Enter numeric values only");
			}
	}
	
foreach ($y as $testcase2) // Y values
	{
		if (is_numeric($testcase2)) 
			{
				// echo "The string $testcase consists of all numbers.\n";
			} 
		else 
			{
				// echo "The string $testcase does not consist of numbers.\n";
				die("Check input of Y variable. Enter numeric values only");
			}
	}
// End Check for numbers

//------------------- Linear PLOT ------------------------------------------------------
if (($plot)=="Linear")
{
echo '
<script>

		$(function(){

			// Data
			var data = [
';
for($i=0;$i<$n;$i++)
{
	echo '[' . $x[$i] . ',' . $y[$i] . ']';
		if ($i<$n){echo ',';}
}
echo '];';
echo '
// do the regression (polynomial to the second degree)
			var myRegression = regression(\'linear\', data);

			// Plot the result
			$.plot($(\'.graph\'), [
				{data: myRegression.points, label: \'Linear\'},
				{data: data,lines: { show: false }, points: { show: true }},
				
			]);

			// print the equation out
			$(\'h3\').text(\'`\' + myRegression.string + \'`\');

		});
		</script>
';
echo "
			<div class=\"container2\">
			<h2>Linear Regression</h2>
			<div class=\"graph\"></div>
			<h3></h3>
			</div>
";
}

//------------------- Non Linear PLOT ------------------------------------------------------
if (($plot)=="NonLinear")
{
echo '
<script>

		$(function(){

			// Data
			var data = [
';
for($i=0;$i<$n;$i++)
{
	echo '[' . $x[$i] . ',' . $y[$i] . ']';
		if ($i<$n){echo ',';}
}
echo '];';
echo '
// do the regression (linear)
			var myRegression = regression(\'polynomial\', data, 2);

			// Plot the result
			$.plot($(\'.graph\'), [
				{data: myRegression.points, label: \'Polynomial\'},
				{data: data,  lines: { show: false }, points: { show: true }},
			]);

			// print the equation out
			$(\'h3\').text(\'`\' + myRegression.string + \'`\');

		});
		</script>
';
echo "
<div class=\"container2\">
			<h2>Non Linear Regression</h2>
			<div class=\"graph\"></div>
			<h3></h3>
</div>
";
}
?>
</div>
</body>
</html>