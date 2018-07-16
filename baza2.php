<?php
try{

$pdo=new PDO('mysql:host=localhost;dbname=ksiazki;encoding=utf8','root','Kawiarenki');
//umozliwia wyrzucanie bledow jezeli wystapi blad w zapytaniu do bazy
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//wyniki zapytania zawęzone do przedstawianie w tabeli asocjacyjnej
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

}
catch(PDOException $e)
{
	echo 'ERROR: '.$e->getMessage();
}
?>