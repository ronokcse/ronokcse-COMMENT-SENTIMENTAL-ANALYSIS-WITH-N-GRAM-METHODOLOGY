<?php 

if(isset($_GET['p_id']))
{

	$the_post_id=$_GET['p_id'];
}


$query="SELECT * FROM posts WHERE post_id={$the_post_id}";
$select_post=mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($select_post))
{
	$post_id=$row['post_id'];
	$post_category_id=$row['post_category_id'];
	$post_title=$row['post_title'];
	$post_author=$row['post_author'];
	$post_date=$row['post_date'];
	$post_image=$row['post_image'];
	$post_content=$row['post_content'];
	$post_tags=$row['post_tags'];
	$post_comment_count=$row['post_comment_count'];
	$post_status=$row['post_status'];

}


 ?>

 <?php 

  	if(isset($_POST['update_post']))
  	{

  		$post_title = $_POST['title'];
		$post_author = $_POST['author'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp =$_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		move_uploaded_file($post_image_temp, "../images/$post_image");

		   $query="UPDATE `posts` SET `post_category_id`='{$post_category_id }',`post_title`='{$post_title}',`post_author`='{$post_author}',`post_date`=now(),`post_image`='{$post_image}',`post_content`='{$post_content}',`post_tags`='{$post_tags}',`post_status`='{$post_status}' WHERE post_id ={$the_post_id} ";

		   $update_post=mysqli_query($connection,$query);
		   conform_query($update_post);
		  echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$post_id}'>View post</a> Or <a href='posts.php'>Edit more post</a></p>";


  	}


  ?>



<form action="" method="post" enctype="multipart/form-data">

	
	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php echo $post_title;  ?>"  type="text" name="title" class="form-control">
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

				if($cat_id == $post_category_id)
				{
					echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
				}
				else
				{
					echo "<option value='{$cat_id}'>{$cat_title}</option>";
				}
				
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

	<div class="form-group">

		<select name="post_status" id="">
			<option value="<?php echo $post_status; ?>" ><?php echo $post_status; ?></option>
			<?php 
			if($post_status == 'published')
			{
				echo "<option value='draft'>Draft</option>";
			}
			else
			{
				echo "<option value='published'>Published</option>";
			}

			 ?>
			
		</select>
	</div>

	<div class="form-group">
		<img width="100" src="../images/<?php echo $post_image ;?>">
		<label for="post_image"></label>
		<input type="file" name="image" >
	</div>


	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags;  ?>" type="text" name="post_tags" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_content">Post Content</label>
		  <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
		<textarea  class="form-control" name="post_content" id="body" cols="30" rows="10" ><?php echo $post_content; ?>
		</textarea>
		<script>
        ClassicEditor
            .create( document.querySelector( '#body' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
	</div>

	<div class="form-group">
		<input  class="btn btn-primary" type="submit" name="update_post" value="Update Post">
	</div>


</form>