<?php
include_once('baza.php');

if( isSet($_POST['autor']) && isSet($_POST['tytul']) && isSet($_POST['recenzja'])  && isSet($_POST['cat_id']))
{
    $filename=0;
    if(isSet($_FILES['cover']) && $_FILES['cover']['error']==0)
    {
        require ("vendor/autoload.php");

        $uid=uniqid();
        $ext=pathinfo($_FILES['cover']['name'],PATHINFO_EXTENSION);

        $filename = 'cover_'.$uid.'.'.$ext;

        $orgfilename = 'org_'.$uid.'.'.$ext;

        $imagine = new \Imagine\Gd\Imagine();
        $size = new \Imagine\Image\Box(200, 200);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        //$mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;

        $imagine->open($_FILES['cover']['tmp_name'])
            ->thumbnail($size,$mode)
            ->save(__DIR__.'/img/'.$filename);

        move_uploaded_file($_FILES['cover']['tmp_name'],__DIR__.'/img/'.$orgfilename);
    }

	if(!isSet($_POST['edit']))
	{
		$insert=$pdo->prepare('INSERT INTO regal (autor,tytul,recenzja,cat_id,cover) VALUES (:autor, :tytul, :recenzja,:cat_id,:cover)');

	}
	else
	{
        $id_edit=intval($_POST['edit']);

	    $cc=$pdo->prepare('SELECT cover FROM regal WHERE id=:id');
	    $cc->bindParam(':id',$id_edit);
	    $cc->execute();
	    $cover=$cc->fetch()['cover'];
	    if($filename && $filename<>$cover && $cover)
        {
            unlink(__DIR__.'/img/'.$cover);
            unlink(__DIR__.'/img/'.str_replace('cover_','org_',$cover));

        }



		$insert=$pdo->prepare('UPDATE regal SET autor=:autor,tytul=:tytul,recenzja=:recenzja,cat_id=:cat_id, cover=:cover WHERE id=:id ');
		$insert->bindParam(':id',$id_edit);




	}

    $insert->bindParam(':cover',$filename);
	$insert->bindParam(':autor', $_POST['autor']);
	$insert->bindParam(':cat_id', $_POST['cat_id']);
	$insert->bindParam(':tytul', $_POST['tytul']);
	$insert->bindParam(':recenzja', $_POST['recenzja']);
	$insert->execute();

	header('location: loop.php');
	

}
	


if(isSet($_GET['id']))
{
	$id=intval($_GET['id']);
	$edit=$pdo->prepare('SELECT * FROM regal WHERE id=:id');
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


<form action="add.php" method="POST" enctype="multipart/form-data">
	

	<input type="text" name="autor" placeholder="Podaj autora"
	<?php if($edit_result<>0) {echo 'value="'.$edit_result['autor'].'"';}?>
	/>
	
	<br></br>
	<input type="text" name="tytul" placeholder="Podaj tytul"
	<?php if($edit_result<>0) {echo 'value="'.$edit_result['tytul'].'"';}?>
	/>
	

	<br></br>
	<textarea name="recenzja" placeholder="Podaj recenzje">
	<?php if($edit_result<>0) {echo $edit_result['recenzja'];}?>
	</textarea>
	<br></br>
	<select name="cat_id">
		<?php

		$cat_data=$pdo->prepare('SELECT * FROM category');
		$cat_data->execute();
		$cat_data_result=$cat_data->fetchAll();

		foreach($cat_data_result as $value)
		{
			if($edit_result<>0 && $value['id']==$edit_result['cat_id'])
			{
			echo '<option selected="selected" value="'.$value['id'].'">'.$value['nazwa'].'</option>';
			}
			else
			{
				echo '<option value="'.$value['id'].'">'.$value['nazwa'].'</option>';
			}
		}
			

		?>
	</select>

    </br></br><input type="file" name="cover"/>

	<?php if($edit_result<>0) {echo '<input type="hidden" name="edit" value='.$id.'/>';}?>
	<br></br>

    <?php
        if($edit_result['cover'])
        {
            echo '<img src="img/'.$edit_result['cover'].'"/>';
        }

    ?>
    <br></br>
	<input type="submit" value="OK"/>


</form>