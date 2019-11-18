<?php 
$idCity = $_GET['idCity'];
echo $id;
$dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
  $query = sprintf('SELECT title_ru FROM _cities where city_id = (%s)',$idCity); 
	$query=$dbh->prepare($query);
	$query->execute(); 
	$rows=$query->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
	<tr>
		<td>City</td>
	</tr>
<?php
foreach ($rows as $key => $row) {
	?>
	<tr>
        <td><?php echo $row['title_ru']?></td>
	</tr>
<?php } ?>
</table>