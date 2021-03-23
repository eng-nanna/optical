<?php
include ("../includes/config.php");
?>
<select name="glasses">
                    <option>Show All</option>
                    <?php		   
					   $result = $_POST['selected'];
					   if ($result == "Show All"){
						   $sql="SELECT * FROM glasses";
					   }
					   else{
					   $sql="SELECT * FROM glasses where category_en='$result' || brand_en='$result'";
					   }
					    $res=mysqli_query($db_conn,$sql);
						while($rows=mysqli_fetch_array($res)){
						$glass_en =  $rows['name_en'];
						$glass_ar =  $rows['name_ar'];
						?>
					<option value="<?php echo $glass_en; ?>"><?php echo $glass_en ." - " . $glass_ar; ?></option>
					<?php
						}
						?>
</select>