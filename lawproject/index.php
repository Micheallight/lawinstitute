<?php

session_start();
clearstatcache();

echo '<link rel="stylesheet" href="css/style.css">';

if(isset($_POST['enter'])) {    
	$servername = $_POST['servername'];
	$dbname = $_POST['dbname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
}

$servername = 'localhost';
$dbname = 'lawinst6';
$username = 'root';
$password = '';

$serverForCopying = 'lawinstitute.bsu.by';
$dbForCopying = ''; // removed by confidentiality
$prefixOfDbForCopying = ''; // removed by confidentiality
$usernameSecond = ''; // removed by confidentiality
$passwordSecond = ''; // removed by confidentiality

try {
	echo '<form method="post" action="second.php">
		<table class="phptable">
			<tr>
				<td><span>Сервер: </span></td>
				<td><input type="text" name="servername" value="' . $servername . '" ></td>
			</tr>
			<tr>
				<td><span>База данных: </span></td>
				<td><input type="text" name="dbname" value="' . $dbname . '" ></td>
			</tr>
			<tr>
				<td><span>Логин: </span></td>
				<td><input type="text" name="username" value="' . $username . '" ></td>
			</tr>
			<tr>
				<td><span>Пароль: </span></td>
				<td><input type="password" name="password" value="' . $password . '"></td>
			</tr>
		</table>
		<br>
		<table class="phptable">
			<tr>
				<td><span>Сервер для копирования: </span></td>
				<td><input type="text" name="serverForCopying" value="' . $serverForCopying . '" ></td>
			</tr>
			<tr>
				<td><span>База данных: </span></td>
				<td><input type="text" name="dbForCopying" value="' . $dbForCopying . '" ></td>
			</tr>
			<tr>
				<td><span>Префикс базы данных: </span></td>
				<td><input type="text" name="prefixOfDbForCopying" placeholder="pre_" value="' . $prefixOfDbForCopying . '" ></td>
			</tr>
			<tr>
				<td><span>Логин: </span></td>
				<td><input type="text" name="usernameSecond" value="' . $usernameSecond . '" ></td>
			</tr>
			<tr>
				<td><span>Пароль: </span></td>
				<td><input type="password" name="passwordSecond" value="' . $passwordSecond . '"></td>
			</tr>
		</table>
		<br>
		<input type="submit" name="logInToSystem" value="Войти" />
	</form>';
} catch (PDOException $e) {
	echo 'Ошибка!<br>Код ошибки: ';
	echo $except->getCode();
	echo '<br>' . $except->getMessage() . '<br>';
}

?>