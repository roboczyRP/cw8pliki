<?php
//include_once('baza.php');
include_once('session2.php');

$zm=$pdo->query( 'SELECT * FROM category' );
echo '<br></br><a href="add_cat.php">Dodaj kategorie</a><br></br>';

echo '<table style="border:solid 1px black;">';
echo '<tr>';
echo '<th>Nazwa</th>';
echo '<th>Funkcje</th>';
echo '</tr>';


foreach($zm as $key=>$value)
{
	echo '<tr>';
	echo '<td>'.$value['nazwa'].'</td>';
	//echo '<td>'.$value['id'].'</td>';
	echo '<td><a href="delete_cat.php?id='.$value['id'].'">Usun</a></td>';
	echo '<td><a href="add_cat.php?id='.$value['id'].'">Edytuj</a></td>';
	echo '</tr>';
	// echo $key.'<pre></br>';
	// print_r($value);
}
echo '</table>';

?>