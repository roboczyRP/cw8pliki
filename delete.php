<?php


include_once('session2.php');


$id=isSet($_GET['id'])? intval($_GET['id']) :0;

if($id>0)
{

    $del=$pdo->prepare('SELECT cover FROM regal WHERE id=:id');
    $del->bindParam(':id',$id);
    $del->execute();
    $delete_file=$del->fetch()['cover'];

    if($delete_file)
    {
        unlink(__DIR__.'/img/'.$delete_file);
        unlink(__DIR__.'/img/'.str_replace('cover_','org_',$delete_file));
    }

	$zm = $pdo->prepare('DELETE FROM regal WHERE id= :id');
	$zm->bindParam(':id',$id);
	$zm->execute();



	header('location: loop.php');
}
else
{
	header('location: loop.php');
}


?>