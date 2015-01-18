<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Straus Cup Standings </h1>

<table class="table table-bordered standings">
	<thead>
		<tr> 
			<th> Rank </th>
			<th> House </th>
			<th> Points </th>
		</tr>
	</thead>
	
<?php foreach ($rankings as $row): ?>
	<?php if ($row["House"] == $_SESSION["house"]): ?>
	    <tr class="bold_row">
	<?php else: ?>
		<tr>
	<?php endif ?>
	        <td class= "col-md-1 std"><?= $row["Rank"] ?></td>
	        <td class= "col-md-2 std"><?= $row["House"] ?></td>		
		<td class= "col-md-1 std"><?= $row["TOTAL"] ?></td>
	    </tr>

<?php endforeach ?>

</table>
	






