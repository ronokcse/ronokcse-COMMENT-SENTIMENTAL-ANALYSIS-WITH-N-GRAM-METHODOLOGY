<?php 
session_start();
include "db.php";
include "../admin/functions.php";
if(isset($_POST['login']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
   $username =mysqli_real_escape_string($connection,$username);
   $password =mysqli_real_escape_string($connection,$password);

	$query = "SELECT * FROM users WHERE username='{$username}'";
	$select_query = mysqli_query($connection,$query);
    $total_number =mysqli_num_rows($select_query);

	if($total_number>0)
	{
		while($row = mysqli_fetch_array($select_query))
		{
			$db_id =$row['user_id'];
			$db_username =$row['username'];
			$db_password =$row['user_password'];
			$db_lastname =$row['user_lastname'];
			$db_firstname =$row['user_firstname'];
			$db_role =$row['user_role'];
		}
		 //$password = crypt($password,$db_password);

	 if(password_verify($password, $db_password))
		{

			$_SESSION['username']=$db_username;
			$_SESSION['firstname']=$db_firstname;
			$_SESSION['lastname']=$db_lastname;
			$_SESSION['user_role']=$db_role;
			header('Location: ../admin');

		}
	else
	{
		header('Location: ../index.php');
	}

}

}

?>