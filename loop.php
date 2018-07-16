<?php
include_once('baza.php');

function distance($page,$howmany,$amountofpages)
{
    $howmany1=$howmany;
    $howmany2=$howmany;
    while(($page-$howmany1) <1 || ($page+$howmany2) >$amountofpages)
    {
        if(($page-$howmany1) <1)
        {
            $howmany1--;
        }
        if(($page+$howmany2) >$amountofpages)
        {
            $howmany2--;
        }

    }
    $page_start=$page-$howmany1;
    $page_end=$page+$howmany2;
    if($page_start>1)
    {
        echo '<a href="loop.php?page=1"><< pierwsza strona</a>';
    }
    for($page_start;$page_start<=$page_end;$page_start++)
    {
        echo '<a href="loop.php?page='.$page_start.'">'.$page_start.'|</a>';
    }

    if($page_end<$amountofpages)
    {
        echo '<a href="loop.php?page='.$amountofpages.'">ostatnia strona >></a>';
    }

}

/*
$zm=$pdo->query( 'SELECT r.*,c.nazwa FROM regal r LEFT JOIN category c ON c.id=r.cat_id ORDER BY r.id ASC' )
        ->fetchAll();
*/


$books_number=($pdo->query('SELECT COUNT(r.id) as "count" FROM regal r')
                    ->fetch()['count']);
//echo $books_number;

echo '<br></br><a href="add.php">Dodaj książkę</a><br></br>';

$page= isSet($_GET['page'])? intval($_GET['page']):1 ;
$starter=($page-1)*5;
$page_number=ceil($books_number/5);
$zm3=$pdo->query( 'SELECT r.*,c.nazwa FROM regal r LEFT JOIN category c ON c.id=r.cat_id ORDER BY r.id ASC LIMIT '.$starter.', 5' )
    ->fetchAll();

//echo '<table style="border:solid 1px black;">';
echo '<table border="1">';
echo '<tr >';
echo '<th>Tytul</th>';
echo '<th>Autor</th>';
echo '<th>Okładka</th>';
echo '<th>Recenzja</th>';
echo '<th>Kategoria</th>';
echo '<th>ID</th>';
echo '<th>Delete</th>';
echo '<th>Edit</th>';
echo '</tr>';

/*
for($i=0;$i<3;$i++)
{
    $zm3[]=$zm[$starter+$i];

}
*/

foreach($zm3 as $key=>$value)
{
	echo '<tr>';
	echo '<td>'.$value['tytul'].'</td>';
	echo '<td>'.$value['autor'].'</td>';
    echo '<td>';
	if($value['cover'])
    {
        echo '<a target="_blank" href="img/'.str_replace('cover_','org_',$value['cover']).'"><img src="img/'.$value['cover'].'"/></a>';
    }
    else
    {
        echo " - ";
    }
    echo '</td>';

	echo '<td>'.$value['recenzja'].'</td>';
/*	Poczatkujacy programista ;)

	$cat_name=$pdo->prepare('SELECT nazwa FROM category WHERE id=:id');
	$cat_name->bindParam(':id',$value['cat_id']);
	$cat_name->execute();
	$name_cat=$cat_name->fetch();
	echo '<td>'.$name_cat['nazwa'].'</td>';
*/
	echo '<td>'.$value['nazwa'].'</td>';
	echo '<td>'.$value['id'].'</td>';
	echo '<td><a href="delete.php?id='.$value['id'].'">Usun</a></td>';
	echo '<td><a href="add.php?id='.$value['id'].'">Edytuj</a></td>';
	echo '</tr>';
	// echo $key.'<pre></br>';
	// print_r($value);
}

echo '</table><br></br>';

distance($page,3,$page_number);


?>