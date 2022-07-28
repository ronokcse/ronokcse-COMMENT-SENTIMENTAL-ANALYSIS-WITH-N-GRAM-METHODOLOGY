
<?php 
include("delete_modal.php");
if(isset($_POST['checkBoxArray']))
{
    foreach ($_POST['checkBoxArray'] as $post_id_check) 
    {

       $bulk_options=$_POST['bulk_options'];

       switch ($bulk_options) {
         case 'published':
         $query="UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$post_id_check}";
         $update_to_published_status=mysqli_query($connection,$query);
         conform_query($update_to_published_status);
         break;

         case 'draft':
         $query="UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$post_id_check}";
         $update_to_draft_status=mysqli_query($connection,$query);
         conform_query($update_to_draft_status);
         break;

         case 'delete':
         $query="DELETE FROM posts  WHERE post_id={$post_id_check}";
         $update_to_delete_status=mysqli_query($connection,$query);
         conform_query($update_to_delete_status);
         break;


         case 'clone':
         $query="SELECT * FROM posts  WHERE post_id={$post_id_check}";
         $select_post=mysqli_query($connection,$query);
         while($row = mysqli_fetch_assoc($select_post))
         {
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

        $query = "INSERT INTO `posts`(`post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','$post_status')";
        
        $create_post_query = mysqli_query($connection,$query);
        conform_query($create_post_query) ;

        break;

    }

}
}

 ?>
<form action=""  method="post">

   <table class="table table-bordered table-hover">

    <div id="bulkOptionContainer" class="col-xs-4" style="padding: 0px;">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>

        </select>
        
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply"><a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        
    </div>

    <thead>
        <tr>
            <th><input id="selectAllBoxes"  type="checkbox"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Image</th>
            <th>Status</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Post Date</th> 
            <th>Views</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            
        </tr>
    </thead>
    <tbody>


        <?php 

        $query="SELECT * FROM posts  ORDER BY post_id DESC";
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
            $post_view_number=$row['post_views_count'];

            echo "<tr>";
            ?>
            <td><input class="checkBoxes"  type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id ?>"></td>
            <?php
            echo" <td>$post_id</td>";
            echo" <td>$post_author</td>";
            echo" <td>$post_title</td>";

            $query="SELECT * FROM categories WHERE cat_id={$post_category_id}";
            $select_categories=mysqli_query($connection,$query);
            while($row=mysqli_fetch_assoc($select_categories))
            {
                $cat_id= $row['cat_id'];
                $cat_title=$row['cat_title'];

            }
            echo" <td>$cat_title</td>";


            echo" <td><img width=80 src='../images/$post_image'></td>";
            echo" <td>$post_status</td>";
            echo" <td>$post_tags</td>";

            $query="SELECT * FROM comment WHERE comment_post_id = $post_id";
            $send_query=mysqli_query($connection,$query);
            $comment_count = mysqli_num_rows($send_query);

            echo" <td><a href='post_comment.php?id=$post_id'>$comment_count</a></td>";


            echo" <td>$post_date</td>";
            echo" <td  align='center'><a href='posts.php?reset={$post_id}' >$post_view_number</a></td>";
            echo" <td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>"; 
            echo" <td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";

            ?>
              <form method="post">

                  <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
                  <td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>
              </form>


            <?php 

            // echo" <td><a href='javascript:void(0)' rel='$post_id' class='delete_link'>Delete</a></td>";
            // echo" <td><a onClick=\"javascript: return confirm('Are you sure you want to Delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "</tr>";

        }
        ?>

    </tbody >

</table>
</form>

                        <?php 
                        if(isset($_POST['delete']))
                        {
                            $the_id=$_POST['post_id'];
                            $query= "DELETE FROM posts WHERE post_id = {$the_id}";
                            $delete_query = mysqli_query($connection,$query);
                            header("Location:posts.php");
                        }



                         if(isset($_GET['reset']))
                        {
                            $the_id=mysqli_real_escape_string($connection,$_GET['reset']);
                            $query="UPDATE posts SET post_views_count = 0 WHERE post_id={$the_id}";
                            $delete_query = mysqli_query($connection,$query);
                            header("Location:posts.php");
                        }




                         ?>


        <script>
            $(document).ready(function(){

                $(".delete_link").on('click',function(){

                     var id = $(this).attr("rel");
                     var delete_url ="posts.php?delete="+ id +" ";

                   $(".modal_delete_link").attr("href",delete_url);
                   $("#myModal").modal('show');
                });
            });



        </script>