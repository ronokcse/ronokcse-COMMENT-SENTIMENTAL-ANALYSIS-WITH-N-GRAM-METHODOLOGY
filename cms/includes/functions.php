<?php 

function view_all_comment_in_page( $post_id)
{
	global $connection;
	$query="SELECT * FROM comment WHERE comment_post_id={$post_id} AND comment_status='Approved' ORDER BY comment_id DESC ";
	$select_comment_query=mysqli_query($connection,$query);

	if(!$select_comment_query)
	{
		die('Query failed'.mysqli_error($connection));
	}
	$negative_very=0;
	$negative_very_very=0;
	$positive_very=0;
	$positive_very_very=0;
	$positive;
	$negative;
	$positive=0;
	$negative=0;
	while($row = mysqli_fetch_assoc($select_comment_query))
	{

		$comment_author=$row['comment_author'];
		$comment_date=$row['comment_date'];
		$comment_content=$row['comment_content'];
		$comment_id=$row['comment_id'];

		$query="SELECT * FROM comment_check WHERE comment_id={$comment_id}";
		$run=mysqli_query($connection,$query);
		if(mysqli_num_rows($run)==0)
		{

		// insert comment details in comments check table

			$query="INSERT into comment_check(comment_id) VALUES('$comment_id')";
			$run=mysqli_query($connection,$query);
		//store word in database
 	        stored_value_in_database($comment_content,$comment_id,$post_id); // store word in database
 	}
		?>


		<div class="media">
			<a class="pull-left" href="#">
				<img class="media-object" src="http://placehold.it/64x64" alt="">
			</a>
			<div class="media-body">
				<h4 class="media-heading"><?php echo $comment_author ?>
				<small><?php echo $comment_date ?></small>
			</h4>
			<?php echo $comment_content ?>
		</div>
	</div>
	<br>


<?php }

  //for positive feed_back
   //select table_name1.word from table_name1,good where table_name1.word LIKE CONCAT('%',good.word,'%');

   $query="SELECT COUNT(table_name1.word) as good_word from table_name1,good where table_name1.word LIKE CONCAT('%',good.word,'%') AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
    $positive=$result['good_word']; 
      

    //for very_good postive feedback
     $query="SELECT COUNT(table_name2.word) as very_good_word from table_name2,very_good where table_name2.word LIKE CONCAT('%',very_good.word,'%') AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
    $positive_very=$result['very_good_word']; 
           

    //for VERY_very_good postive feedback
     $query="SELECT COUNT(table_name3.word) as good_word from table_name3,very_very_good where table_name3.word LIKE CONCAT('%',very_very_good.word,'%')  AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
    $positive_very_very=$result['good_word'];

      
      //positive count
     $positive_check_minus=($positive-$positive_very-$positive_very_very);
     if($positive_check_minus<0)
     {
     	$positive_check_minus=0;
     }
       $positive=($positive_check_minus+($positive_very-$positive_very_very)*1.25+($positive_very_very*1.5));



    //for negative feed_back

     $query="SELECT COUNT(table_name1.word) as bad_word from table_name1,bad where table_name1.word LIKE CONCAT('%',bad.word,'%')  AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
    $negative=$result['bad_word'];
      

    //for very_bad negative feedback
     $query="SELECT COUNT(table_name2.word) as bad_word from table_name2,very_bad where table_name2.word LIKE CONCAT('%',very_bad.word,'%')  AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
     $negative_very=$result['bad_word'];   
    
      //for very_very_bad negative feedback
     $query="SELECT COUNT(table_name3.word) as bad_word from table_name3,very_very_bad where table_name3.word LIKE CONCAT('%',very_very_bad.word,'%')  AND post_id={$post_id} ";
    $run=mysqli_query($connection,$query);
    $result=mysqli_fetch_array($run);
    $negative_very_very=$result['bad_word']; 

    // Negative calculation
    echo "<br>";
    $negative_check_minus=($negative-$negative_very-$negative_very_very);
    if($negative_check_minus <0)
    {
    	$negative_check_minus=0;
    }
     $negative=  ($negative_check_minus+($negative_very-$negative_very_very)*1.25+($negative_very_very*1.5));



    //percentage count
    echo "<br>";
    if(($positive+$negative)!=0)
    {
    	$positive_percentage= round((100*$positive)/($positive+$negative));
    	$negative_percentage=100-$positive_percentage;
    	$positive_session="positive_percentage".$post_id;
    	$negative_session="negative_percentage".$post_id;
    	$_SESSION[$positive_session] = $positive_percentage;
    	$_SESSION[$negative_session] = $negative_percentage;
    	//echo "$positive_percentage %<br>";
    	// echo "$negative_percentage %<br>";
    }
    else
    {
    	$positive_percentage= 0;
    	$negative_percentage=0;
    	$_SESSION["positive_percentage"] = $positive_percentage;
    	$_SESSION["negative_percentage"] = $negative_percentage;
    	// echo "$positive_percentage %<br>";
    	// echo "$negative_percentage %<br>";
    }
   

    
   // empty_table();

}



function getNgrams($variable, $n) {
	global $conn;
	$array=explode(' ', $variable);
	$ngrams = array();
	$len = count($array);
	for($i = 0; $i < $len; $i++) {
		if($i > ($n - 2))
		{
			$ng = '';
			for($j = $n-1; $j >= 0; $j--) {
				$ng = $ng.$array[$i-$j]." ";
			}

			$ngrams[] = $ng;
		}
	}
	return $ngrams;
}

function stored_value_in_database($variable,$comment_id,$post_id)
{
	global $connection;
	for($i=1;$i<=3;$i++)
	{
		$table="table_name".$i;
		$array=getNgrams($variable,$i);
		foreach ($array as $value) {
			$query="INSERT INTO $table(word,comment_id,post_id) values('$value','$comment_id','$post_id')";
			$run=mysqli_query($connection,$query);
		}
		echo mysqli_error($connection);
	}
}

function empty_table()
{
	global $connection;
	for($i=1;$i<=3;$i++)
	{
		$table="table_name".$i;
		$query="TRUNCATE $table";
		$run=mysqli_query($connection,$query);
		echo mysqli_error($connection);
	}
	$query="TRUNCATE comment_check";
	$run=mysqli_query($connection,$query);
}
 


 ?>