<?php 
$id = $_GET['id'];
session_start();
if($_GET['id'] != ''){
	$_SESSION['id'] = $_GET['id'];
}
if($_GET['page'] != ''){
	$page = $_GET['page'];
} else {
	$page = 1;
}
$dbh = "pgsql:host=localhost;port=5432;dbname=countries;user=postgres;password=";
try {
    $dbh = new PDO($dbh);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$items_per_page = 100;
$region_id = $_GET['id'];
$offset = ($page - 1) * $items_per_page;

$query=$dbh->prepare('SELECT city_id, title_ru FROM _cities where region_id =? ORDER BY title_ru LIMIT 100  OFFSET ? ');
$query->bindParam(1, $region_id,PDO::PARAM_INT);
$query->bindParam(2, $offset,PDO::PARAM_INT);
$query->execute();
$rows=$query->fetchAll(PDO::FETCH_ASSOC);

$stmt=$dbh->prepare("SELECT count(*) FROM _cities WHERE region_id=?");
    $stmt->bindParam(1, $region_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchALL();


$count_per_page = 20;
$next_offset = $page * $count_per_page;
$dbh=null;
$query=null;

$countOfNotes = 75;
printCities($rows,$countOfNotes,$page,$data);

function printCities($rows,$countOfNotes,$page,$data){
	$countCity = count($rows);#к-во городов
	$countOfNotes = 75;
	for($i = 1; $i <= round($data[0]['count']/$countOfNotes, 0); $i++){ ?>
		<a href="region.php?page=<?php echo $i?>"><?php echo $i . " " ?> </a>
	<?php
	} 
	$index = 0; # индекс текущего элемента массива
	$from = ($page - 1) * $countOfNotes; #с какого города по счёту выводить города
	$countCity = 1;	#нумерация городов
	?>
	
	<table border="1">
			<tr>
				<td>Count</td>
				<td>City</td>
			</tr>
	<?php foreach ($rows as $key => $row) {?>
			<tr>
				<td><?php echo $countCity ?></td>
    		    <td><a href="/city.php? idCity=<?php echo $row['city_id']?>"><?php echo $row['title_ru']?></a> </td>
			</tr>
	<?php }
		
		$countCity++;
		$index++;
	}

?>
</table>
