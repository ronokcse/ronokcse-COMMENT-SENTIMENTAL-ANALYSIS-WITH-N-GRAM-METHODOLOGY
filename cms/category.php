<?php 
session_start();
 include "includes/db.php";
 include "includes/header.php";
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

                if(isset($_GET['category']))
                {
                    $post_category_id=$_GET['category'];

                    if(isset($_SESSION['user_role']) &&$_SESSION['user_role']='admin' )
                    {
                    $query="SELECT * from posts Where post_category_id= $post_category_id ";
                    }
                 else
                 {
                  $query="SELECT * from posts Where post_category_id= $post_category_id AND post_status='published'";
                  }
               

                // $query="SELECT * from posts Where post_category_id= $post_category_id AND post_status='published'";
                  
                 $select_all_post= mysqli_query($connection,$query);
                 if(mysqli_num_rows($select_all_post)<1)
                 {
                      echo "<h1 class='text-center'>No Post Available</h1>";
                 }

                 else
                 {


                 while($row = mysqli_fetch_assoc($select_all_post))
                 {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0,100) ;
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
                 <p><font size="+2"><?php echo $post_content; ?></font></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



                    
                 <?php  } }}

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

       
