<?php
//include_once('baza.php');
include_once('session2.php');

if( isSet($_POST['nazwa']))
{
	if(!isSet($_POST['edit']))
	{
		$insert=$pdo->prepare('INSERT INTO category (nazwa) VALUES (:nazwa)');
	}
	else
	{
		$id_edit=intval($_POST['edit']);
		$insert=$pdo->prepare('UPDATE category SET nazwa=:nazwa WHERE id=:id ');
		$insert->bindParam(':id',$id_edit);
	}

	$insert->bindParam(':nazwa', $_POST['nazwa']);
	$insert->execute();

	header('location: category.php');
	

}
	


if(isSet($_GET['id']))
{
	$id=intval($_GET['id']);
	$edit=$pdo->prepare('SELECT * FROM category WHERE id=:id');
	$edit->bindParam(':id',$id);
	$edit->execute();
	$edit_result=$edit->fetch();
}
else
{
	$id=0;
	$edit_result=0;
}

?>


<form action="add_cat.php" method="POST">

	<input type="text" name="nazwa" <?php if($edit_result<>0) {echo ' value="'.$edit_result['nazwa'].'"';}?>/></br>

	<?php 
		if($edit_result<>0)
	 	{
	 		echo '<input type="hidden" name="edit" value='.$id.'/>';
	 	}



	 ?>
	<br></br>
	<input type="submit" value="OK"/>


</form>