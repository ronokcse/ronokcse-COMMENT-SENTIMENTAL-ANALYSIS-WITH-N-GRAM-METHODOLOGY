
<?php 

	if(isset($_POST['add_user']))
	{
	    $user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['user_role'];
		$username = $_POST['username'];

		// $post_image = $_FILES['image']['name'];
		// $post_image_temp =$_FILES['image']['tmp_name'];

		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];
		$query ="SELECT randSalt from users";
        // $select_randsalt_query= mysqli_query($connection,$query);
        // if(!$select_randsalt_query)
        // {
        //     die("Query failed".mysqli_error($connection));
        // }
        // $row =mysqli_fetch_assoc($select_randsalt_query);
        // $salt =$row['randSalt'];
        // $user_password = crypt($user_password,$salt);
         $user_password = password_hash($user_password, PASSWORD_BCRYPT,array('cost'=>10));
		//$post_date = date('d-m-y');
		//$post_comment_count =4;
		// move_uploaded_file($post_image_temp, "../images/$post_image");


		$query = "INSERT INTO `users`(`user_firstname`, `user_lastname`, `user_role`, `username`, `user_email`, `user_password`) VALUES ('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','$user_password')";
		
		$create_user_query = mysqli_query($connection,$query);
		conform_query($create_user_query) ;
		echo "User Created :"." "."<a href='users.php'>View Users</a>";
	}
     
    

 ?>



<form action="" method="post" enctype="multipart/form-data">

	
	<div class="form-group">
		<label for="title">Firstname</label>
		<input type="text" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_status">Lastname</label>
		<input type="text" name="user_lastname" class="form-control">
	</div>





	<div class="form-group">
		<select name="user_role" id="">
			<option value="subscriber">Select Options</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>

	
	<!-- <div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image" >
	</div>
 -->

	<div class="form-group">
		<label for="post_tags">Username</label>
		<input type="text" name="username" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_content">Email</label>
		<input type="email" name="user_email" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Password</label>
		<input type="password" name="user_password" class="form-control">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="add_user" value="Add User">
	</div>


</form>