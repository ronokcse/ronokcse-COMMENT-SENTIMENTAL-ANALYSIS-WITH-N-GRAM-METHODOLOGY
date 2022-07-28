 
 <?php 
  
if(isset($_POST['checkBoxArray']))
{
    foreach ($_POST['checkBoxArray'] as $comment_id_check) 
    {

    echo    $bulk_options=$_POST['bulk_options'];

       switch ($bulk_options) {
         case 'Approved':
         $query= "UPDATE comment SET comment_status='{$bulk_options}' WHERE comment_id = {$comment_id_check}";
         $approve_query = mysqli_query($connection,$query);
         conform_query($approve_query);
         break;

         case 'Unapproved':
         $query= "UPDATE comment SET comment_status='{$bulk_options}' WHERE comment_id = {$comment_id_check}";
         $unapprove_query = mysqli_query($connection,$query);
         conform_query($unapprove_query);
         break;

         case 'delete':
         //delete from comment table
          $query= "DELETE FROM comment WHERE comment_id = {$comment_id_check}";
          $delete_query = mysqli_query($connection,$query);
         conform_query($delete_query);
         //delete from check_comment table
         $query= "DELETE FROM comment_check WHERE comment_id = {$comment_id_check}";
          $delete_query = mysqli_query($connection,$query);
         conform_query($delete_query);
         //delete from table_name1 table
         $query= "DELETE FROM table_name1 WHERE comment_id = {$comment_id_check}";
          $delete_query = mysqli_query($connection,$query);
         conform_query($delete_query);
         //delete from table_name2 table
         $query= "DELETE FROM table_name2 WHERE comment_id = {$comment_id_check}";
          $delete_query = mysqli_query($connection,$query);
         conform_query($delete_query);
         //delete from table_name3 table
         $query= "DELETE FROM table_name3 WHERE comment_id = {$comment_id_check}";
          $delete_query = mysqli_query($connection,$query);
         conform_query($delete_query);
         break;

    }

}
}







  ?>
<form action="" method="post">
   <table class="table table-bordered table-hover">
    <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px;">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Approved">Approve</option>
            <option value="Unapproved">Unapprove</option>
            <option value="delete">Delete</option>

        </select>      
    </div>
     <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        
    </div>

    <thead>
        <tr>
            <th><input id="selectAllBoxes"  type="checkbox"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>Date</th>
            <th>In Response to</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>


        <?php 

        $query="SELECT * FROM comment";
        $select_comment=mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_comment))
        {
            $comment_id=$row['comment_id'];
            $comment_post_id=$row['comment_post_id'];
            $comment_author=$row['comment_author'];
            $comment_email=$row['comment_email'];
            $comment_content=$row['comment_content'];
            $comment_status=$row['comment_status'];
            $comment_date=$row['comment_date'];
            echo "<tr>";
            ?>
             <td><input class="checkBoxes"  type="checkbox" name="checkBoxArray[]" value="<?php  echo $comment_id ?>"></td>
             <?php
            echo" <td>$comment_id</td>";
            echo" <td>$comment_author</td>";
            echo" <td>$comment_content</td>";

                                    // $query="SELECT * FROM categories WHERE cat_id={$post_category_id}";
                                    // $select_categories=mysqli_query($connection,$query);
                                    // while($row=mysqli_fetch_assoc($select_categories))
                                    // {
                                    //     $cat_id= $row['cat_id'];
                                    //     $cat_title=$row['cat_title'];

                                    // }
                                    // echo" <td>$cat_title</td>";

            echo" <td>$comment_email</td>";
            echo" <td>$comment_status</td>";
            echo" <td>$comment_date</td>";


            $query="SELECT * FROM posts WHERE post_id=$comment_post_id";
            $select_post_id_query=mysqli_query($connection,$query);
            $comment_counts = mysqli_num_rows($select_post_id_query);
            if($comment_counts > 0)
            {
               while ($row = mysqli_fetch_assoc($select_post_id_query)) {

                 $post_id = $row['post_id'];
                 $post_title = $row['post_title'];
                 echo" <td><a href='../post.php?p_id=$post_id' >$post_title</a></td>";
             }

         }
         else
         {
            echo" <td>Post has been deleted</td>";
        }







        echo" <td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
        echo" <td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
        echo" <td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
        echo "</tr>";

    }
    ?>

</tbody>

</table>
</form>

                        <?php

                        if(isset($_GET['approve']))
                        {
                           echo  $the_comment_id=$_GET['approve'];
                            $query= "UPDATE comment SET comment_status='Approved' WHERE comment_id = {$the_comment_id}";
                            $approve_query = mysqli_query($connection,$query);
                            header("Location:comments.php");
                        }




                         if(isset($_GET['unapprove']))
                        {
                           echo  $the_comment_id=$_GET['unapprove'];
                            $query= "UPDATE comment SET comment_status='Unapproved' WHERE comment_id = {$the_comment_id}";
                            $unapprove_query = mysqli_query($connection,$query);
                            header("Location:comments.php");
                        }


                        if(isset($_GET['delete']))
                        {
                           echo  $the_comment_id=$_GET['delete'];
                            $query= "DELETE FROM comment WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection,$query);
                            $query= "DELETE FROM comment_check WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection,$query);
                            $query= "DELETE FROM table_name1 WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection,$query);
                            $query= "DELETE FROM table_name2 WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection,$query);
                            $query= "DELETE FROM table_name3 WHERE comment_id = {$the_comment_id}";
                            $delete_query = mysqli_query($connection,$query);
                            header("Location:comments.php");
                        }



                         ?>