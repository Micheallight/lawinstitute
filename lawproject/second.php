<?php

set_time_limit(0);

session_start();
clearstatcache();

echo '<link rel="stylesheet" href="css/style.css">';
echo '<script src="js/checkboxfile.js"></script>';

try {
	// if (isset($_POST['logInToSystem'])) {
	// 	$servername = $_POST['servername'];
	// 	$dbname = $_POST['dbname'];
	// 	$username = $_POST['username'];
	// 	$password = $_POST['password'];

	// 	$serverForCopying = $_POST['serverForCopying'];
	// 	$dbForCopying = $_POST['dbForCopying'];
	// 	$prefixOfDbForCopying = $_POST['prefixOfDbForCopying'];
	// 	$usernameSecond = $_POST['usernameSecond'];
	// 	$passwordSecond = $_POST['passwordSecond'];

	// 	$_SESSION['serverForCopying'] = $_POST['serverForCopying'];
	// 	$_SESSION['dbForCopying'] = $_POST['dbForCopying'];
	// 	$_SESSION['prefixOfDbForCopying'] = $_POST['prefixOfDbForCopying'];
	// 	$_SESSION['usernameSecond'] = $_POST['usernameSecond'];
	// 	$_SESSION['passwordSecond'] = $_POST['passwordSecond'];

	// 	$_SESSION['servername'] = $_POST['servername'];
	// 	$_SESSION['dbname'] = $_POST['dbname'];
	// 	$_SESSION['username'] = $_POST['username'];
	// 	$_SESSION['password'] = $_POST['password'];
	// } else {
	// 	$servername = $_SESSION['servername'];
	// 	$dbname = $_SESSION['dbname'];
	// 	$username = $_SESSION['username'];
	// 	$password = $_SESSION['password'];
		
	// 	$serverForCopying = $_SESSION['serverForCopying'];
	// 	$dbForCopying = $_SESSION['dbForCopying'];
	// 	$prefixOfDbForCopying = $_SESSION['prefixOfDbForCopying'];
	// 	$usernameSecond = $_SESSION['usernameSecond'];
	// 	$passwordSecond = $_SESSION['passwordSecond'];
	// }

	$servername = 'localhost';
	$dbname = ''; // removed by confidentiality
	$username = ''; // removed by confidentiality
	$password = ''; // removed by confidentiality

	$serverForCopying = 'lawinstitute.bsu.by';
	$dbForCopying = ''; // removed by confidentiality
	$prefixOfDbForCopying = ''; // removed by confidentiality
	$usernameSecond = ''; // removed by confidentiality
	$passwordSecond = ''; // removed by confidentiality
	
	var_dump($_SESSION);

	$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
	$connSecond = new PDO("mysql:host=$serverForCopying; dbname=$dbForCopying", $usernameSecond, $passwordSecond);
	
	$showall = $conn->query('SHOW TABLES FROM ' . $dbname);
	$showallSecond = $connSecond->query('SHOW TABLES FROM ' . $dbForCopying);
	
	echo '<form method="post" action="third.php">';

	// echo '<table class="phptable">
	// 	<tr>
	// 		<td><span>Сервер для копирования: </span></td>
	// 		<td><input type="text" name="serverForCopying" value="' . $serverForCopying . '" ></td>
	// 	</tr>
	// 	<tr>
	// 		<td><span>База данных: </span></td>
	// 		<td><input type="text" name="dbForCopying" value="' . $dbForCopying . '" ></td>
	// 	</tr>
	// 	<tr>
	// 		<td><span>Префикс базы данных: </span></td>
	// 		<td><input type="text" name="prefixOfDbForCopying" placeholder="pre_" value="' . $prefixOfDbForCopying . '" ></td>
	// 	</tr>
	// 	<tr>
	// 		<td><span>Логин: </span></td>
	// 		<td><input type="text" name="usernameSecond" value="' . $usernameSecond . '" ></td>
	// 	</tr>
	// 	<tr>
	// 		<td><span>Пароль: </span></td>
	// 		<td><input type="password" name="passwordSecond" value="' . $passwordSecond . '"></td>
	// 	</tr>
	// </table><br>';

	$nameOfTable = 'tree';
	$nameOfTableSecond = 'content';

	
	$sqlGetTableHeads = 'SHOW COLUMNS FROM ' . $nameOfTable;
	$sqlGetTableRecords = 'SELECT * FROM ' . $nameOfTable . ' ORDER BY `datetime`';
	
	$sqlGetTableHeadsSecond = 'SHOW COLUMNS FROM ' . $prefixOfDbForCopying . $nameOfTableSecond;
	$sqlGetTableRecordsSecond = 'SELECT * FROM ' . $prefixOfDbForCopying . $nameOfTableSecond;
	
	// echo 'Название таблицы в новой базе данных (без префикса): <input type="text" name="newTableNameOf' . $nameOfTable[0] . '"><br><br>';

	echo '<br>';

	echo '<table class="phptable" id="' . $nameOfTableSecond . '" title="' . $nameOfTableSecond . '">';
	$resultSecond = $connSecond->query($sqlGetTableHeadsSecond);
	
	// echo $conn->query("SELECT `datetime` FROM " . $nameOfTable[0] . " WHERE `id` = " . $iterator22)->fetch()[0];
	

	echo '<thead><tr>';
	while($row = $resultSecond->fetch()) {
		if ($row['Field'] != 'id' && $row['Field'] != 'asset_id' && $row['Field'] != 'alias' ) {
			echo '<td>' . $row['Field'];
			echo '</td>';
		}
	}
	echo '</tr>';
	echo '</thead><tbody>';

	$resultSecond = $connSecond->query($sqlGetTableHeadsSecond);
	
	while($row = $resultSecond->fetch()) {
		if ($row['Field'] != 'id' && $row['Field'] != 'asset_id' && $row['Field'] != 'alias' ) {
			echo '<td>';
			if ($row['Field'] == 'state') {
				echo '1';
			} elseif ($row['Field'] == 'catid') {
				echo '2';
			} elseif ($row['Field'] == 'created_by') {
				echo '636';
			} elseif ($row['Field'] == 'images') {
				echo '{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}';
			} elseif ($row['Field'] == 'urls') {
				echo '{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}';
			} elseif ($row['Field'] == 'attribs') {
				echo '{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","flags":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","helix_ultimate_image":"","helix_ultimate_article_format":"standard","helix_ultimate_audio":"","helix_ultimate_gallery":"","helix_ultimate_video":""}';
			} elseif ($row['Field'] == 'access') {
				echo '1';
			} elseif ($row['Field'] == 'metadata') {
				echo '{"robots":"","author":"","rights":""}';
			} elseif ($row['Field'] == 'featured') {
				echo '0';
			} elseif ($row['Field'] == 'language') {
				echo 'ru-RU';
			}
			echo '</td>';
		}
	}

	echo '</tbody></table><br>';

	echo '<br>Доступные для выбора записи:<br><br>';

	echo '<details><summary>' . $nameOfTable . '</summary><br>';
	echo '<table class="phptable" id="' . $nameOfTable . '" title="' . $nameOfTable . '">';
	$result = $conn->query($sqlGetTableHeads);
	
	// echo $conn->query("SELECT `datetime` FROM " . $nameOfTable[0] . " WHERE `id` = " . $iterator22)->fetch()[0];
	

	echo '<thead><tr><td rowspan="2" title="Отметить все"><input type="checkbox" onclick="checkAll(this, ' . "'" . $nameOfTable . "'" . ')" /></td>';
	while($row = $result->fetch()) {
		echo '<td>' . $row['Field'];
		if ($row['Field'] != 'id') {
			echo '<br><hr><input type="text" name="newColumnNameIn' . $nameOfTable . 'Of' . $row['Field'] . '" title="Введите название соответствующего столбца в новой таблице" placeholder="' . $row['Field'] . '"';
			if ($row['Field'] == 'title') {
				echo ' value="title"';
			} elseif ($row['Field'] == 'content') {
				echo ' value="fulltext"';
			}
			echo '>';
		}
		echo '</td>';
	}
	echo '</tr>';
	echo '</thead><tbody>';
	$result = $conn->query($sqlGetTableRecords);

	while($row = $result->fetch()) {
		echo '<tr>';
		$iterator22++;
		if (trim($nameOfTable[0]) == 'registry') {
			echo '<td><input type="checkbox" onclick="uncheckAll(' . "'" . $nameOfTable[0] . "'" . ')" name="checkRowOf' . $nameOfTable . '[]" value="' . $row['var_id'] . '" /></td>';
		} else {
			echo '<td><input type="checkbox" onclick="uncheckAll(' . "'" . $nameOfTable[0] . "'" . ')" name="checkRowOf' . $nameOfTable . '[]" value="' . $row['id'] . '" /></td>';
		}
		for ($iterator = 0; $iterator < $result->columnCount(); $iterator++) {
			if ($nameOfTable == 'tree' && $iterator == 0) {
				echo '<td title="' . $conn->quote($conn->query("SELECT `datetime` FROM " . $nameOfTable . " WHERE `id` = " . $row[$iterator])->fetch()[0]) . '">' . $row[$iterator] . '</td>';
			} else {
				echo '<td>' . $row[$iterator] . '</td>';
			}
		}
		echo '</tr>';
	}
	echo '</tbody></table>';
	echo '</details><br>';
	
	// foreach ($showall as $key => $nameOfTable) {
	// 	echo '<details><summary>' . $nameOfTable[0] . '</summary><br>';
		
		
		
	// 	echo '</details>';
	// 	echo '<br>';
	// }
	echo '<input type="submit" name="getRecords" value="Перенести записи"></form>';
	
	echo '<br><br><a href="http://lawproject/"><input type="button" value="Выход"></a>';
} catch (PDOException $except) {
	if ($except->getCode() == 2002) {
		echo 'Неверный адрес сервера';
	} elseif ($except->getCode() == 1045) {
		echo 'Неверные имя пользователя или пароль';
	} elseif ($except->getCode() == 1049) {
		echo 'Неверное имя базы данных';
	} else {
		echo 'Ошибка!<br>Код ошибки: ';
		echo $except->getCode();
		echo '<br>' . $except->getMessage() . '<br>';
	}
	echo '<br><br>';
	
	if (isset($_POST['logInToSystem'])) {
		include_once('index.php');
	} elseif (isset($_POST['getRecords'])) {
		include_once('second.php');
	} else {
		echo '<br><a href="http://lawproject/"><input type="button" value="Выход"></a>';
	}
}

?>