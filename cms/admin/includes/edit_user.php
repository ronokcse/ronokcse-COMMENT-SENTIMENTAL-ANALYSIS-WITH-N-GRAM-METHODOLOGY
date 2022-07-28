
<?php 


	if(isset($_GET['edit_user']))
	{
		$the_user_id=$_GET['edit_user'];

		$query="SELECT * FROM users WHERE user_id =$the_user_id ";
		$select_users=mysqli_query($connection,$query);
		while($row = mysqli_fetch_assoc($select_users))
		{
			$user_id=$row['user_id'];
			$username=$row['username'];
			$user_firstname=$row['user_firstname'];
			$user_lastname=$row['user_lastname'];
			$user_password=$row['user_password'];
			$user_email=$row['user_email'];
			$user_image=$row['user_image'];
			$user_role=$row['user_role'];
		}


	//update users Query
       
	if(isset($_POST['edit_user']))
	{
		$the_user_id=$_GET['edit_user'];
		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['user_role'];
		$username = $_POST['username'];
		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];
        
        $user_password = password_hash($user_password, PASSWORD_BCRYPT,array('cost'=>10));



		$query="UPDATE `users` SET `username`='{$username}',`user_password`='{$user_password}',`user_firstname`='{$user_firstname}',`user_lastname`='{$user_lastname}',`user_email`='{$user_email}',`user_role`='{$user_role}' WHERE  user_id={$the_user_id}";

		$edit_user_query=mysqli_query($connection,$query);
		conform_query($edit_user_query);
		echo "User Updated :"." "."<a href='users.php'>View Users</a>";

	}
}
  else
  {
  	header('Location:index.php');
  }



     
    

 ?>



<form action="" method="post" enctype="multipart/form-data">

	
	<div class="form-group">
		<label for="title">Firstname</label>
		<input type="text" value="<?php echo $user_firstname; ?>" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_status">Lastname</label>
		<input type="text" value="<?php echo $user_lastname; ?>" name="user_lastname" class="form-control">
	</div>





	<div class="form-group">
		<select name="user_role" id="">
			<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

			<?php 
			if($user_role == 'admin')
			{
				echo "<option value='subscriber'>subscriber</option>";
			}
			else
			{
				echo "<option value='admin'>admin</option>";
			}

			 ?>
				
		</select>
	</div>

	
	<!-- <div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image" >
	</div>
 -->

	<div class="form-group">
		<label for="post_tags">Username</label>
		<input type="text" value="<?php echo $username; ?>" name="username" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_content">Email</label>
		<input type="email" value="<?php echo $user_email; ?>" name="user_email" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Password</label>
		<input autocomplete="off" type="password"  name="user_password" class="form-control">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
	</div>


</form>