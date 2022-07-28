
<?php 

if(isset($_GET['p_id']))
{
	$id=$_GET['p_id'];
	$postive_session="positive_percentage".$id;
	$negative_session="negative_percentage".$id;
	?>
	<div class="well" style="background-color:gray;">
		<h4 style="color: white;"><b>Show percentage</b></h4>
		<div>
			<?php if(!isset($_SESSION[$postive_session])){
				 $_SESSION[$postive_session]=0;
			}
			if(!isset($_SESSION[$negative_session])){
				 $_SESSION[$negative_session]=0;
			}
			 ?>
			<h3 style="color: #6D0000;">Positive :  <?php echo  $_SESSION[$postive_session] ?>%</h3>
		</div>
		<div><h3 style="color: #019BF5;">Negative : <?php echo   $_SESSION[$negative_session] ?>%</h3></div>
	</div>
	<?php  
}
else
{
	?>
	<div class="well">
		<h4>Side Widget Well</h4>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.
		</p>
	</div>
	<?php  
}
?>


