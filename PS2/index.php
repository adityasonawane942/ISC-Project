<?php

$conn = mysqli_connect('localhost','username','password','database_name');

if(!$conn) {
echo 'Connection error: ' . mysqli_connect_error();
}

$sql = 'SELECT name, roll FROM table_name';
$result = mysqli_query($conn, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

$name = $roll = '';
	$errors = array('name' => '', 'roll' => '');
	if(isset($_POST['submit'])){

		if(empty($_POST['name'])){
			$errors['name'] = 'A name is required';
		} else{
			$name = $_POST['name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
				$errors['name'] = 'Name must be letters and spaces only';
			}
		}

		if(empty($_POST['roll'])){
			$errors['roll'] = 'A roll number is required';
		} else{
			$roll = $_POST['roll'];
			if(!preg_match('/^[-+]?\d*$/', $roll)){
				$errors['roll'] = 'Roll must be an integer only';
			}
		}

		if(array_filter($errors)){
			echo 'errors in form';
		} else {
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$roll = mysqli_real_escape_string($conn, $_POST['roll']);
			$sqlp = "INSERT INTO table_name(roll,name) VALUES('$roll','$name')";
			if(mysqli_query($conn, $sqlp)){
				$sqlr = 'SELECT name, roll FROM table_name';
				$result = mysqli_query($conn, $sqlr);
				$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
				mysqli_free_result($result);
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
		}
	}
?>

<!DOCTYPE html>
<html>

<style>
	table,th,td {border: black 1px solid; border-collapse: collapse; text-align: center;}
	th,td {padding: 10px;}
</style>

<form action="index.php" method="POST">

	<label>Name</label>
	<input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>">
	<div><?php echo $errors['name']; ?></div>
	<br>

	<label>Roll Number</label>
	<input type="text" name="roll" value="<?php echo htmlspecialchars($roll) ?>">
	<div><?php echo $errors['roll']; ?></div>
	<br>

	<div><input type="submit" name="submit" value="Submit"></div>
</form>
<br>
<table>
	<tr>
		<th>Name</th>
		<th>Roll No.</th>
	</tr>
		<?php foreach($items as $item){ ?>
		<tr>
			<td><?php echo htmlspecialchars($item['name']); ?></td>
			<td><?php echo htmlspecialchars($item['roll']); ?></td>
		</tr>
		<?php } ?>
</table>
</html>