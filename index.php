<?php
$dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
$query = 'SELECT region_id, title_ru FROM _regions where country_id = 2 ORDER BY 2'; 
$query=$dbh->prepare($query);
$query->execute();
$rows=$query->fetchAll(PDO::FETCH_ASSOC);

?>
<table border="1">
	<tr>
		<td>id</td>
		<td>region</td>
	</tr>
<?php 
foreach ($rows as $key => $row) {
	?>
	<tr>
        <td><?php echo  $row['region_id']?> </td>
        <td><a href="/region.php?id=<?php echo $row['region_id']?>"><?php echo  $row['title_ru'];?></a></td>
	</tr>
<?php } ?>
</table>