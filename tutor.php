<?php
include('config.php');
include('session.php');
$myemail = $_SESSION['login_email'];
$sql = "select * from mydb.tutor where email = '$myemail'";
$result = mysqli_query($db,$sql);
$count = mysqli_num_rows($result);
if($count == 1) {
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$name = $row['name'];
	$tid = $row['TutorID'];
	#$show_email =  $row['email'];
	echo "tid:".$tid."<br>";
	echo "name:".$name."<br>";
	echo "email:".$myemail."<br>";
}else {
    header("location: mydbtutorlogin.php");
}

$sql = "select count(*) from mydb.post where TutorID = '$tid'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
echo "<tr>";
echo "Number of posts:".$row[0]."<br>";
echo "</tr>";


$sql = "select * from mydb.post where TutorID = $tid";
$result = mysqli_query($db,$sql);
echo "<table><tr><td>PID</td><td>Course</td><td>Description</td></tr>";
while ($data = mysqli_fetch_array($result)){
	echo "<tr>";
	echo " <td>".$data['PID']."</td>";
	echo " <td>".$data['Subject']."</td>";
	echo "<td>".$data['Description']." </td>";
	echo "</tr>";
}
echo "</table>";

echo "<form method='POST' action='addpost.php'> <select name='course'>";
$sql = "select * from mydb.course";
$result = mysqli_query($db,$sql);
while ($data = mysqli_fetch_array($result)){
   	$cname = $data['name'];
	echo " <option value='$cname'>".$cname."</option>";
}
echo "</select>
      	<textarea rows='4' cols='50' name='description'>Description2</textarea>
      	<input type = 'submit' value = 'add post'>
      </form>";

echo "<form method='POST' action='editpost.php'> <select name='postid'>";
$sql = "select * from mydb.post where TutorID = $tid";
$result = mysqli_query($db,$sql);
while ($data = mysqli_fetch_array($result)){
   	$cname = $data['PID'];
	echo " <option value='$cname'>".$cname."</option>";
}
echo "</select>
      	<textarea rows='4' cols='50' name='description'>Description</textarea>
      	<input type = 'submit' value = 'edit post'>
      </form>";

echo "<form method='POST' action='deletepost.php'> <select name='postid'>";
$sql = "select * from mydb.post where TutorID = $tid";
$result = mysqli_query($db,$sql);
while ($data = mysqli_fetch_array($result)){
   	$cname = $data['PID'];
	echo " <option value='$cname'>".$cname."</option>";
}
echo "</select>
      	<input type = 'submit' value = 'delete post'>
      </form>";

$sql = "select * from mydb.application where PostID in (select PID from mydb.post where post.TutorID = '$tid')";
$result = mysqli_query($db,$sql);
echo mysqli_error($db);

echo "<table><tr><td>AppID</td><td>PostID</td><td>TuteeID</td><td>message</td></tr>";
while ($data = mysqli_fetch_array($result)){
	echo "<tr>";
	echo " <td>".$data['AppID']."</td>";
	echo "<td>".$data['PostID']." </td>";
	echo " <td>".$data['TuteeID']."</td>";
	echo " <td>".$data['Message']."</td>";
	#echo " <td><form method='post' action = ''><input type='submit' value='accept' name></td>";
	echo "</tr>";
}
echo "</table>";


?>
<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Welcome <?php echo $myemail; ?></h1> 
      <h2><a href = "logout.php">Sign Out</a></h2>
   </body>
   
</html> 