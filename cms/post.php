<?php 
//session_start();
include "includes/db.php";
include "includes/header.php";
include "includes/functions.php";
?>
<!-- Navigation -->
<?php 
include "includes/navigation.php";
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php 

            if(isset($_GET['p_id']))
            {
                $post_id = $_GET['p_id'];

                $view_query="UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id={$post_id}";
                $send_query=mysqli_query($connection,$view_query);

                if(!$send_query)
                {
                    die('Query failed'.mysqli_error($connection));
                }

                if(isset($_SESSION['user_role']) && $_SESSION['user_role']='admin' )
                {
                   $query="SELECT * from posts WHERE post_id = {$post_id}";
                }
                else
                {
                  $query="SELECT * from posts WHERE post_id = {$post_id} AND post_status='published'";
                }

               $select_all_post= mysqli_query($connection,$query);

              if(mysqli_num_rows($select_all_post)<1)
              {
              echo "<h1 class='text-center'>No Post Available</h1>";
              }

              else
              {

               while($row = mysqli_fetch_assoc($select_all_post))
               {
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                ?>

                <!-- First Blog Post -->
                <h2>
                   <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo strtoupper($post_title);?></a> 
               </h2>
               <p class="lead">
                by <a href="index.php"><?php echo ucwords($post_author); ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
            <hr>
            <p><?php echo $post_content; ?></p>
            <hr>

        <?php  }



        ?>


        <!-- Blog Comments -->

        <?php 

        if(isset($_POST['create_comment']))
        {
            $post_id = $_GET['p_id'];
            $comment_author=$_POST['comment_author'];
            $comment_content=$_POST['comment_content'];
            $comment_email=$_POST['comment_email'];

            if(!empty($comment_author) && !empty($comment_content) && !empty($comment_email))
            {
                $query="INSERT INTO comment (comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) Values ($post_id,'{$comment_author}','{$comment_email}','{$comment_content}','Approved',now()) ";


                $comment_query = mysqli_query($connection,$query);

                if(!$comment_query)
                {
                    die('Query Failed '.mysqli_error($connection));
                }

                        // $query= "UPDATE posts SET post_comment_count =post_comment_count+1 WHERE post_id={$post_id} ";
                        // $update_comment_count=mysqli_query($connection,$query);
            }

            else
            {
                echo "<script>alert('field does not found')</script>";
            }

        }


    ?>


    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form action="" method="post" role="form">

         <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="comment_author" class="form-control" name="comment_author">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="comment_email" class="form-control" name="comment_email">
        </div>

        <div class="form-group">
            <label for="comment">Your Comment</label>
            <textarea class="form-control" name="comment_content" rows="3"></textarea>
        </div>
        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
    </form>
</div>

<hr>

<!-- Posted Comments -->

<!-- Comment -->


<?php 

    view_all_comment_in_page( $post_id); // viw all comment in page from the  includes/function.php


 }
}
   
    else
    {
        header("Location:index.php");
    }

?>



</div>

<!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"; ?>

</div>
<!-- /.row -->

<hr>
<?php include "includes/footer.php"; ?>


