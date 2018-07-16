<?php

session_start();

include_once('baza2.php');
$url="{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
$url=pathinfo($url);
$add=$url['basename'];
//echo $add;
//$id =  isSet($_GET['id']) ? intval($_GET['id']) : 0;



if(!isSet($_SESSION['logged']) || $_SESSION['logged']<>true)
{
	if(isset($_SESSION['falsedata']) && $_SESSION['falsedata']==true)
	{
		echo 'Nieprawidłowy login lub hasło.</br>';
	}
if(isSet($_POST['login']) && isSet($_POST['pass']))
{

	$login=$_POST['login'];
	$password=md5($_POST['pass']);

	$result=0;
	

	if($_POST['logowanie']=="rej")
	{
	$enquery=$pdo->prepare('INSERT INTO uzytkownicy(login,pass) VALUES(:login,:pass)');


	}
	else
	{
	$enquery=$pdo->prepare('SELECT * FROM uzytkownicy WHERE login=:login AND pass=:pass');
	}

	$enquery->bindParam(':login',$login);
	$enquery->bindParam(':pass',$password);
	$enquery->execute();

	if($_POST['logowanie']=="rej")
	{
		echo '</br>Wprowadzono użytkownika '.$login.' do bazy danych.</br>';

	}
	else
	{
		$result=$enquery->fetch();
		if($result['login']==$login && $result['pass']==$password)
		{
			$_SESSION['logged']=true;
			$_SESSION['falsedata']=false;
			header("location: loop.php");


			
			
		}
		else
		{
			$_SESSION['falsedata']=true;
				
				header("location: $add");
			
			
		}
	}

}

else
{
	?>


<form action="session2.php" method="POST">
	<input type="text" name="login" placeholder="login" /></br>
	<input type="password" name="pass" placeholder="password" /></br>
	<select name="logowanie">
		<option value="rej">Rejestracja</option>
		<option value="log">Logowanie</option>
	</select></br>
	<input type="submit" value="Zaloguj" />
</form>
<?php
//kończy dzilanie skryptu wiec zostaje wyswietlony tylko formularz powyzej
die();
}
}

?>


