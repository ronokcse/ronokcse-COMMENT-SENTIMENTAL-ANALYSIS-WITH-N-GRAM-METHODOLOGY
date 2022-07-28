<?php 
session_start();
function redirect($location)
{
	return header("Location:" . $location );
	exit;
}
 

function escape($string)
{
	global $connection;
	mysqli_real_escape_string($connection,$string);
}



function user_online()
{
	global $connection;
	$conform=0;
	$session =session_id();
	$time_in= time();
	$time_out_in_second= 30;
	$time_out= $time_in -$time_out_in_second;
	$query="SELECT * FROM user_online";
	$send_query=mysqli_query($connection,$query);
	while($row = mysqli_fetch_assoc($send_query))
	{
		$session_conform = $row['session'];
		if($session_conform == $session)
		{
			$conform=1;
		}
	}

	if($conform!=1)
	{
		mysqli_query($connection,"INSERT INTO user_online(session,time_in) VALUES('$session','$time_in')");
	}
	else
	{
		mysqli_query($connection,"UPDATE user_online SET time_in ='$time_in' WHERE session = '$session'");
	}


	$user_online_query=mysqli_query($connection,"SELECT * FROM user_online WHERE time_in > '$time_out'");
	return $user_count = mysqli_num_rows($user_online_query);



}


function conform_query($result)
{

	global $connection;
	if(!$result)
	{
		die('Query Failed' . mysqli_error($connection));
	}
}



function insert_categories()
{
	global $connection;
	if(isset($_POST['submit']))
	{
		$cat_title=$_POST['cat_title'];
		if($cat_title == "" || empty($cat_title))
		{
			echo "It should not be empty ";
		}
		else
		{
			$query="INSERT INTO categories (cat_title) VALUES('{$cat_title}')";
			$add_category=mysqli_query($connection,$query);
			if(!$add_category)
			{
				die('Query Failed' . mysqli_error($connection));
			}

		}
	}

}


function find_all_categories()
{
	global $connection;

	$query="SELECT * FROM categories";
	$select_categories=mysqli_query($connection,$query);
	while($row=mysqli_fetch_assoc($select_categories))
	{
		$cat_id= $row['cat_id'];
		$cat_title=$row['cat_title'];
		echo "<tr>";
		echo "<td>{$cat_id}</td>";
		echo "<td>{$cat_title}</td>";
		echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
		echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
		echo "</tr>";
	}
}



function delete_categories()
{
	global $connection;
	if(isset($_GET['delete']))
	{
		$the_cat_id = $_GET['delete'];
		$query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
		$delete = mysqli_query($connection,$query);
		header("Location: categories.php");
	}

}

function is_admin($username)
{
	global $connection;
	$query="SELECT user_role FROM users WHERE username = '$username'";
	$send_query = mysqli_query($connection,$query);
	conform_query($send_query);

	$row =mysqli_fetch_array($send_query);
	if($row['user_role']=='admin')
	{
		return true;
	}
	else
	{
		return false;
	}

}

function username_exist($username)
{
	global $connection;
	$query="SELECT username FROM users WHERE username = '$username'";
	$send_query = mysqli_query($connection,$query);
	conform_query($send_query);
	if(mysqli_num_rows($send_query)>0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function email_exist($email)
{
	global $connection;
	$query="SELECT user_email FROM users WHERE user_email = '$email'";
	$send_query = mysqli_query($connection,$query);
	conform_query($send_query);
	if(mysqli_num_rows($send_query)>0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

function register_user($username,$user_email,$user_password)
{
  
	global $connection;

		$username =mysqli_real_escape_string($connection,$username);
		$user_email =mysqli_real_escape_string($connection,$user_email);
		$user_password =mysqli_real_escape_string($connection,$user_password);

		$user_password = password_hash($user_password, PASSWORD_BCRYPT,array('cost'=>12));
		$query = "INSERT INTO users (username,user_email,user_password,user_role) VALUES('{$username}','{$user_email}','{$user_password}','subscriber')";

		$create_user_query = mysqli_query($connection,$query);
		if(!$create_user_query)
		{
			die("Query failed".mysqli_error($connection));
		}



}

function login_user($username,$password)
{
	global $connection;
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

			header('Location: ../cms/admin');

		}
	else
	{
		header('Location: ../index.php');
	}

}


}



?>