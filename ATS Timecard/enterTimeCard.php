<html>
<body>


<h1 align="center"> Student Timecard</h1>
<form>
	<table border="1" align="center">
		<tr>
			<th> Date: </th>
			<th> Time in: </th>
			<th> Time out: </th>
			<th> Comments: </th>
		
		</tr>
	

		<!-- MONDAY -->
		<tr>
			<td>
				<?php echo "Mon, ", date("m-d"); ?>
			</td>
			<td>
				<input type="text" id="hourin" />
			</td>
			<td>
				<input type="text" id="hourout" />
			</td>
			<td>
				<textarea rows="3" cols="25" id="comment" > </textarea>
			</td>
		</tr>
		
		<!-- Tuesday -->
		<tr>
			<td>
				<?php echo "Tue, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>
		
		<!-- Wednesday -->
		<tr>
			<td>
				<?php echo "Wed, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>
		
		<!-- THURSDAY -->
		<tr>
			<td>
				<?php echo "Thu, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>

		<!-- FRIDAY -->
		<tr>
			<td>
				<?php echo "Fri, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>

		<!-- SATURDAY -->
		<tr>
			<td>
				<?php echo "Sat, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>
		
		<!-- SUNDAY -->
		<tr>
			<td>
				<?php echo "Sun, ",date("m-d")?>
			</td>
			<td>
				<input type="text"/>
			</td>
			<td>
				<input type="text" />
			</td>
			<td>
				<textarea rows="3" cols="25"></textarea>
			</td>
		</tr>
		
		<tr>
			<td align="right" colspan="4">
				<input type="submit" value="sumbit" />
			</td>
		</tr>
	
	</table>
	
	
	
</form>

</body>
</html>