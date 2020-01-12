<?php

		session_start();

		if(!isset($_SESSION["user_id"]) || !isset($_SESSION["user_password"]))
		{
			echo "<script> window.location.replace('login.php'); </script>";
		}
		else
		{
			

?>


<!DOCTYPE html>
<html>
<head>
	
	<?php require_once "header_libs.html"; ?>

</head>
<body>

	
	<?php require_once "mysqli_connect.php"; ?>
	<?php require_once "top_bar.php"; ?>
	<?php require_once "header.php"; ?>
	

<div style="background: #f5f5f5;">


	<div class="container-fluid py-3">			
			<div class="clearfix">
				<span class="float-left" style="color: #f57224; padding-left: 30px;">
					<h3>My Cart</h3></span>
					<span class="float-right" style="padding: 11px 30px;">				    	
						
					</span>
			</div>		
	</div>



<div class="container-fluid">
	<div class="row" style="padding: 11px 30px; ">
		<div class="col-sm-8" style="background: #ffffff;">






<div >
<div class="container py-3">
	<div class="row py-4" style="background: #2e2e54; color: #ffffff;">
		<div class="col-sm-2">Image</div>
		<div class="col-sm-7">Name</div>
		<div class="col-sm-2">Price</div>
		<div class="col-sm-1"></div>
		<div class="col-sm-1"></div>
	</div><br>
</div>	
</div>
			

<?php

		$user_id = $_SESSION['user_id'];

		$sql = "

		SELECT pro_id FROM cart
		WHERE user_id='$user_id';

		";

		$result = $conn->query($sql);

		$sub_total_price = 0;

		if ($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
			  			
			  		$pro_id = $row["pro_id"];

								$sql2 = "SELECT * FROM product WHERE id=$pro_id;";
								
								$result2 = $conn->query($sql2);								
								if($result2->num_rows>0)
								{
									while($row2 = $result2->fetch_assoc()) {

										$sub_total_price = $sub_total_price + $row2["price"];
?>										
	

<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
				<div class="col-sm-2">
							<img src="<?php echo $row2["image_path"] ?>" style="width: 78px; height: 78px; line-height: 50px;"/>
				</div>					
				<div class="col-sm-7"><?php echo $row2["name"] ?></div>

				<div class="col-sm-2" style="color: #f57224; font-weight: bold;">Rs. <?php echo $row2["price"] ?> /-</div>
				

				<div class="col-sm-1">
				<form method="post"> 
					    <button type="submit" name="remove" value="<?php echo $row2["id"]?>" style="border:none;background: #ffffff;">
					    <i class="fa fa-trash" style="color:#dc3545;"></i>
					    </button>
					</form> 
				</div>
</div>


									 
<?php
									}

								}		

			  	}

			  }

?>



				


<?php

		if($_SERVER["REQUEST_METHOD"]=="POST")
  		{
  			$remove = $_POST["remove"];
  			$user_id = $_SESSION['user_id'];
  			
  			//echo $remove;
  			//echo $user_id;

			$sql = "  DELETE FROM cart
				     WHERE pro_id = $remove AND user_id='$user_id'	;";

			$conn->query($sql );

			echo "<script> window.location.replace('my_cart.php'); </script>";
		}
?>			



		</div>
		<div class="col-sm-4">
			
			<div  style="background: #ffffff; padding: 10px; ">
				<h4>Order Summary</h4><br><br>
				<div style="float: left;">			
					<span style="display: table-cell;
					font-size: 14px;color:#757575;letter-spacing: 0;line-height: 16px;vertical-align: middle;width: 50%;">Subtotal</span>
				</div>
				<div style="float: right;">			<span id="sub_total" style="font-weight: bold; color: #f57224;">Rs. 999999 /-</span>				</div>

				<button id="sign_up_button" ><a href="checkout.php" style="color: #ffffff;">PROCEED TO CHECKOUT</a></button>
			</div>


		</div>
	</div>
</div>


<script type="text/javascript">
	

var sub_total = document.getElementById("sub_total");
sub_total.innerHTML = "<?php echo "Rs. ".$sub_total_price." /-"; ?>";

<?php
$_SESSION["checkout_price"] = $sub_total_price;



?>
					






</script>	


</div>


	<?php require_once "footer.php"; ?>


</body>
</html>



<?php
}
?>