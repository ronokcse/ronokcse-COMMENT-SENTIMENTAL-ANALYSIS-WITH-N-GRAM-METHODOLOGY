
<?php 

	if(isset($_POST['create_post']))
	{
		$post_title = $_POST['title'];
		$post_author = $_POST['author'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp =$_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		$post_date = date('d-m-y');
		//$post_comment_count =4;
		move_uploaded_file($post_image_temp, "../images/$post_image");


		$query = "INSERT INTO `posts`(`post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','$post_status')";
		
		$create_post_query = mysqli_query($connection,$query);
		conform_query($create_post_query) ;

		$post_id= mysqli_insert_id($connection);
		 echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$post_id}'>View post</a> Or <a href='posts.php'>Edit more post</a></p>";
	}
     
    

 ?>



<form action="" method="post" enctype="multipart/form-data">

	
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" name="title" class="form-control">
	</div>

	<div class="form-group"><b>Category:</b>
		<select name="post_category" id="post_category">
			
			<?php 


			$query="SELECT * FROM categories";
			$select_categories=mysqli_query($connection,$query);

			conform_query($select_categories);

			while($row=mysqli_fetch_assoc($select_categories))
			{
				$cat_id= $row['cat_id'];
				$cat_title=$row['cat_title'];
				echo "<option value='{$cat_id}'>{$cat_title}</option>";
			}

			 ?>



		</select>
	</div>


	<div class="form-group"><b>Users:</b>
		<select name="author" id="">
			
			<?php 


			$query="SELECT * FROM users";
			$select_users=mysqli_query($connection,$query);

			conform_query($select_users);

			while($row=mysqli_fetch_assoc($select_users))
			{
				$user_id= $row['user_id'];
				$username=$row['username'];
				echo "<option value='{$username}'>{$username}</option>";
			}

			 ?>



		</select>
	</div>

	<div class="form-group"><b>Post Status:</b>
		<select  name="post_status" id="">
			<option value="draft">Post Status</option>
			<option value="draft">Draft</option>
			<option value="published">Publish</option>
		</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image" >
	</div>


	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" name="post_tags" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="body" cols="30" rows="10" ></textarea>
		<script>
        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_post" value="Published Post">
	</div>


</form>