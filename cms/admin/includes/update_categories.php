   <form action="" method="post">
    <div class="form-group">
      <label for="cat_title">Update Category</label>
      <?php 

            // update data 

       $the_cat_id = $_GET['edit'];
       $query="SELECT * FROM categories WHERE cat_id={$the_cat_id}";
       $select_categories=mysqli_query($connection,$query);
       while($row=mysqli_fetch_assoc($select_categories))
       {
        $cat_id= $row['cat_id'];
        $cat_title=$row['cat_title'];
        ?>

        <input value="<?php if(isset($cat_title))echo $cat_title;?>" class="form-control" type="text" name="update_cat_title">
        <?php  
      }


       // update button work
    ?>

  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update" value="update categories">
  </div>
 
  <?php 
     
     if(isset($_POST['update']))
      { 

     
        $cat_title =$_POST['update_cat_title'];
        $query = "UPDATE  categories  SET cat_title = '{$cat_title}' WHERE cat_id = {$the_cat_id}";
        $update = mysqli_query($connection,$query);
        header("Location: categories.php");
      }
     

   ?>

</form>
