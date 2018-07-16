<?php


//include_once('session2.php');
/include_once('session2.php');


$id=isSet($_GET['id'])? intval($_GET['id']) :0;

if($id>0)
{
	$zm = $pdo->prepare('DELETE FROM category WHERE id= :id');
	$zm->bindParam(':id',$id);
	$zm->execute();

	header('location: category.php');
}
else
{
	header('location: category.php');
}


?>