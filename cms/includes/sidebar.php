<?php //session_start(); ?>
<div class="col-md-4">
 

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post">
                    <div class="input-group">
                        <input  name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                </form>  
                    <!-- /.input-group -->
                </div>
              
                <div class="well">
                    
               
                 <?php if(isset($_SESSION['user_role'])): ?>

                    <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
                    <a href="includes/logout.php" class="btn btn-primary">Logout</a>

                </div>


                 <?php else : ?>
                    <div class="well">
                    <h4>Login</h4>
                    <form action="includes/login.php" method="post">
                    <div class="form-group">
                        <input  name="username" type="text" class="form-control" placeholder="Enter Username">
                    </div>
                    <div class="input-group">
                        <input  name="password" type="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">Submit
                                
                            </button>
                        </span>
                    </div>
                </form>  
                    <!-- /.input-group -->
                </div>


                 <?php endif; ?>


                 <!-- Login form -->
                



                <!-- Blog Categories Well -->
                <?php 
                    $query = "SELECT * FROM categories";
                    $select_all_categories_query= mysqli_query($connection,$query);
                 ?>



                <div class="well">
                    <h3>Blog Categories</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled ">
                                <?php 

                                while($row = mysqli_fetch_assoc($select_all_categories_query))
                                {
                                $cat_title = $row['cat_title'];
                                $cat_id=$row['cat_id'];
                                echo "<font size='+1'><li><a href='category.php?category=$cat_id'>{$cat_title}</a></li></font>";
                                }

                                 ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php include "widget.php"; ?>

            </div>