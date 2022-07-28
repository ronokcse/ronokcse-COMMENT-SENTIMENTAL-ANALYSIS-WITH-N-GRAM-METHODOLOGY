<?php session_start();
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

                $per_page=3;
                if(isset($_GET['page']))
                {
                    $page=$_GET['page'];

                }

                else
                {
                    $page="";

                }

                if($page == "" || $page ==1)
                {
                    $page_1=0;
                }
                else
                {
                    $page_1=($page* $per_page)- $per_page;
                }


                 if(isset($_SESSION['user_role']) &&$_SESSION['user_role']='admin' )
                {
                   $_SESSION['user_role'];
                   $select_query="SELECT * FROM posts ";
                }
               else
               {
                   $select_query="SELECT * FROM posts  WHERE post_status='published' ";
               }

               
                $find_count= mysqli_query($connection,$select_query);
                $count = mysqli_num_rows($find_count);
                
                if($count<1)
                {
                    echo "<h1 class='text-center'>No Post Available</h1>";
                }
                else
                {

                $count=ceil($count/3);



                 $query="SELECT * from posts  ORDER BY post_id DESC LIMIT {$page_1} , $per_page ";
                 $select_all_post= mysqli_query($connection,$query);
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
                    by <a href="author_post.php?author=<?php echo ucwords($post_author); ?>&p_id=<?php echo $post_id; ?>"><?php echo ucwords($post_author); ?></a>
                </p> 
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id;?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                 <p><font size="+2"><?php echo $post_content; ?></font></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



                    
                 <?php   }}?>



                

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <ul class="pager">
            <?php 
            for($i=1;$i<=$count;$i++)
            {

                if($i == $page)
                {
                     echo "<li> <a class='active_link' href='index.php?page={$i}'>$i</a></li>";
                }
                else
                {
                     echo "<li> <a href='index.php?page={$i}'>$i</a></li>";
                }
               
            }

             ?>
            
            

        </ul>
        <?php include "includes/footer.php"; ?>

       
