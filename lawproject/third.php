<?php

set_time_limit(0);

session_start();
clearstatcache();



echo '<link rel="stylesheet" href="css/style.css">';

function isInArr($arg, $arr) {
	for ($i = 0; $i < count($arr); $i++) {
		if ($arg == $arr[$i][0]) {
			return true;
		}
	}
	return false;
}

function isInArrOfPost($arg, $arr) {
	for ($i = 0; $i < count($arr); $i++) {
		if ($arg == $arr[$i]) {
			return true;
		}
	}
	return false;
}

function url_slug($str, $options = array()) {
	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
	
	$defaults = array(
		'delimiter' => '-',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => false,
	);
	
	// Merge options
	$options = array_merge($defaults, $options);
	
	$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
		'ß' => 'ss', 
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
		'ÿ' => 'y',

		// Latin symbols
		'©' => '(c)',

		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 

		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya', 'ў' => 'u',

		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
		'Ž' => 'Z', 
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z', 

		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
		'Ż' => 'Z', 
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',

		// Latvian
		'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
		'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
		'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
		'š' => 's', 'ū' => 'u', 'ž' => 'z'
	);
	
	// Make custom replacements
	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
	
	// Transliterate characters to ASCII
	if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
	}
	
	// Replace non-alphanumeric characters with our delimiter
	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	
	// Remove duplicate delimiters
	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
	
	// Truncate slug to max. characters
	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
	
	// Remove delimiter from ends
	$str = trim($str, $options['delimiter']);
	
	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}

try {
	$servername = 'localhost';
	$dbname = ''; // removed by confidentiality
	$username = ''; // removed by confidentiality
	$password = ''; // removed by confidentiality

	$serverForCopying = 'lawinstitute.bsu.by';
	$dbForCopying = ''; // removed by confidentiality
	$prefixOfDbForCopying = ''; // removed by confidentiality
	$usernameSecond = ''; // removed by confidentiality
	$passwordSecond = ''; // removed by confidentiality

	$nameOfTable = 'tree';
	$nameOfTableSecond = 'content';

	$conn = new PDO("mysql:host=$servername; dbname=$dbname; charset=UTF8", $username, $password);
	$connSecond = new PDO("mysql:host=$serverForCopying; dbname=$dbForCopying; charset=UTF8", $usernameSecond, $passwordSecond);

	echo 'Выбранный сервер: ' . $serverForCopying . '<br>';
	echo 'Выбранная (обновленная) база данных: ' . $dbForCopying . '<br>';
	echo 'Префикс выбранной (обновленной) базы данных: ' . $prefixOfDbForCopying . '<br><br>';

	$showall = $conn->query('SHOW TABLES FROM ' . $dbname);
	$showallSecond = $connSecond->query('SHOW TABLES FROM ' . $dbForCopying);

	$isEmptySetOfTables = true;

	echo 'Скопированные записи:<br><br>';

	// $isEmptyRequest = true;

	$sqlGetTableHeads = 'SHOW COLUMNS FROM ' . $nameOfTable;
	$sqlGetTableHeads2 = 'SHOW COLUMNS FROM ' . $prefixOfDbForCopying . $nameOfTableSecond;

	// $sqlGetTableRecords = 'SELECT ';

	$currentTableIdentifiers = $_POST['checkRowOf' . $nameOfTable];

	// var_dump($currentTableIdentifiers);

	$printTable = '';

	echo '<details><summary>' . $prefixOfDbForCopying . $nameOfTableSecond . '</summary>';

	$printTable .= '<br><br><table class="phptable" title="' . $prefixOfDbForCopying . $nameOfTableSecond . '">';

	$printTable .= '<thead><tr>';

	$tableHeads2 = $connSecond->query($sqlGetTableHeads2);

	while ($column = $tableHeads2->fetch()) {
		$printTable .= '<td>' . $column[0] . '</td>';
	}

	$printTable .= '</tr></thead>';

	$printTable .= '<tbody>';

	
	for ($i = 0; $i < count($currentTableIdentifiers); $i++) {
		
		$sqlInsert1 = 'INSERT INTO ' . $prefixOfDbForCopying . $nameOfTableSecond . ' (';
		$sqlInsert2 = 'VALUES (';

		$assetsRequest = 'INSERT INTO `kqmj2_assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (';

		$workflowRequest = 'INSERT INTO `kqmj2_workflow_associations` (`item_id`, `stage_id`, `extension`) VALUES (';
		
		// ------------- ENG ---------------

		$sqlInsert1Eng = 'INSERT INTO ' . $prefixOfDbForCopying . $nameOfTableSecond . ' (';
		$sqlInsert2Eng = 'VALUES (';

		$assetsRequestEng = 'INSERT INTO `kqmj2_assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (';

		$workflowRequestEng = 'INSERT INTO `kqmj2_workflow_associations` (`item_id`, `stage_id`, `extension`) VALUES (';

		// ------------- BEL ---------------

		$sqlInsert1Bel = 'INSERT INTO ' . $prefixOfDbForCopying . $nameOfTableSecond . ' (';
		$sqlInsert2Bel = 'VALUES (';

		$assetsRequestBel = 'INSERT INTO `kqmj2_assets` (`parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES (';

		$workflowRequestBel = 'INSERT INTO `kqmj2_workflow_associations` (`item_id`, `stage_id`, `extension`) VALUES (';

		// ------------- NEXT ----------------

		$isFirst = true;

		$tableHeads2 = $connSecond->query($sqlGetTableHeads2);
		$tableRecord = $conn->query($sqlGetTableRecord);
		$printTable .= '<tr>';

		while ($row = $tableHeads2->fetch()) {
			$printTable .= '<td>';
			if ($row['Field'] == 'state') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('1');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('1');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('1');

				$printTable .= '1';
			} elseif ($row['Field'] == 'catid') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('64');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('65');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('66');

				$printTable .= '9';
			} elseif ($row['Field'] == 'created_by') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('636');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('636');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('636');
				
				$printTable .= '636';
			} elseif ($row['Field'] == 'images') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}');

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}');

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}');

				$printTable .= '{"image_intro":"","image_intro_alt":"","float_intro":"","image_intro_caption":"","image_fulltext":"","image_fulltext_alt":"","float_fulltext":"","image_fulltext_caption":""}';
			} elseif ($row['Field'] == 'urls') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}');
				
				$printTable .= '{"urla":"","urlatext":"","targeta":"","urlb":"","urlbtext":"","targetb":"","urlc":"","urlctext":"","targetc":""}';
			} elseif ($row['Field'] == 'attribs') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","flags":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","helix_ultimate_image":"","helix_ultimate_image_alt_txt":"","helix_ultimate_article_format":"standard","helix_ultimate_audio":"","helix_ultimate_gallery":"","helix_ultimate_video":""}');

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","flags":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","helix_ultimate_image":"","helix_ultimate_image_alt_txt":"","helix_ultimate_article_format":"standard","helix_ultimate_audio":"","helix_ultimate_gallery":"","helix_ultimate_video":""}');

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","flags":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","helix_ultimate_image":"","helix_ultimate_image_alt_txt":"","helix_ultimate_article_format":"standard","helix_ultimate_audio":"","helix_ultimate_gallery":"","helix_ultimate_video":""}');

				$printTable .= '{"article_layout":"","show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_associations":"","flags":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_page_title":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","helix_ultimate_image":"","helix_ultimate_image_alt_txt":"","helix_ultimate_article_format":"standard","helix_ultimate_audio":"","helix_ultimate_gallery":"","helix_ultimate_video":""}';
			} elseif ($row['Field'] == 'access') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('1');

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('1');

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('1');

				$printTable .= '1';
			} elseif ($row['Field'] == 'metadata') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('{"robots":"","author":"","rights":""}');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('{"robots":"","author":"","rights":""}');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('{"robots":"","author":"","rights":""}');

				$printTable .= '{"robots":"","author":"","rights":""}';
			} elseif ($row['Field'] == 'featured') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('0');

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('0');

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('0');
				
				$printTable .= '0';
			} elseif ($row['Field'] == 'language') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('ru-RU');

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('en-GB');

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('*');
				
				$printTable .= 'ru-RU';
			} elseif ($row['Field'] == 'title') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `title` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2 .= $conn->quote($res->fetch()[0]);
				
				$sqlGetTableRecord = 'SELECT `title` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$printTable .= $res->fetch()[0];

				// ---------- ENG -------------
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `name_eng` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Eng .= $conn->quote($res->fetch()[0]);

				// ---------- BEL -------------
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `name_blr` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Bel .= $conn->quote($res->fetch()[0]);
			} elseif ($row['Field'] == 'introtext') {
				// if ($isFirst) {
				// 	$isFirst = false;
				// } else {
				// 	$sqlInsert1 .= ', ';
				// 	$sqlInsert2 .= ', ';
					
				// 	$sqlInsert1Eng .= ', ';
				// 	$sqlInsert2Eng .= ', ';
				// }
				// $sqlInsert1 .= '`' . $row['Field'] . '`';
				
				// $sqlGetTableRecord = 'SELECT `content` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				// $res = $conn->query($sqlGetTableRecord);
				
				// $sqlInsert2 .= $conn->quote($res->fetch()[0]);
								
				// $sqlGetTableRecord = 'SELECT `content` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				// $res = $conn->query($sqlGetTableRecord);
				
				// $printTable .= $res->fetch()[0];


				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';

				// $sqlGetTableRecord = 'SELECT `content` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				// $res = $conn->query($sqlGetTableRecord)->fetch()[0];

				// $res=strip_tags($res);

				// echo '<br>' . $res . '<br>';

				$sqlInsert2 .= $conn->quote('');

				// ----------- ENG ------------

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';

				$sqlInsert2Eng .= $conn->quote('');

				// ----------- BEL ------------

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';

				$sqlInsert2Bel .= $conn->quote('');

			} elseif ($row['Field'] == 'fulltext') {
				// if ($isFirst) {
				// 	$isFirst = false;
				// } else {
				// 	$sqlInsert1 .= ', ';
				// 	$sqlInsert2 .= ', ';
					
				// 	$sqlInsert1Eng .= ', ';
				// 	$sqlInsert2Eng .= ', ';
				// }
				// $sqlInsert1 .= '`' . $row['Field'] . '`';
				// $sqlInsert2 .= $conn->quote('<br>');


				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `content` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2 .= $conn->quote($res->fetch()[0]);
				
				$sqlGetTableRecord = 'SELECT `content` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$printTable .= $res->fetch()[0];

				// ---------- ENG ------------

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `content_eng` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Eng .= $conn->quote($res->fetch()[0]);

				// ---------- BEL ------------

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `content_blr` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Bel .= $conn->quote($res->fetch()[0]);
			} elseif ($row['Field'] == 'created' || $row['Field'] == 'modified' || $row['Field'] == 'publish_up') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `datetime` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2 .= $conn->quote($res->fetch()[0]);
								
				$sqlGetTableRecord = 'SELECT `datetime` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$printTable .= $res->fetch()[0];

				// ----------- ENG ------------

				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `datetime` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Eng .= $conn->quote($res->fetch()[0]);

				// ----------- BEL ------------

				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				
				$sqlGetTableRecord = 'SELECT `datetime` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				
				$sqlInsert2Bel .= $conn->quote($res->fetch()[0]);
			} elseif ($row['Field'] == 'metadesc') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('');
			} elseif ($row['Field'] == 'asset_id') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				// $sqlInsert2 .= $conn->quote('385');
				$num = $connSecond->query('SELECT `id` FROM `kqmj2_assets` ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 1;
				$sqlInsert2 .= $conn->quote($num);
				// $sqlInsert2 .= $conn->quote('');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				// $sqlInsert2 .= $conn->quote('385');
				$num = $connSecond->query('SELECT `id` FROM `kqmj2_assets` ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
				$sqlInsert2Eng .= $conn->quote($num);
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				// $sqlInsert2 .= $conn->quote('385');
				$num = $connSecond->query('SELECT `id` FROM `kqmj2_assets` ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 3;
				$sqlInsert2Bel .= $conn->quote($num);
			} elseif ($row['Field'] == 'alias') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';

				$sqlGetTableRecord = 'SELECT `title` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				$string = $res->fetch()[0];
				// echo $string . '<br>';
				// echo url_slug($string, array('transliterate' => true));
				$str2 = url_slug($string, array('transliterate' => true));
				// echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
				// echo $str2;
				$sqlInsert2 .= $conn->quote($str2);

				// ---------- ENG --------------
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';

				$sqlGetTableRecord = 'SELECT `name_eng` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				$string = $res->fetch()[0];
				// echo $string . '<br>';
				// echo url_slug($string, array('transliterate' => true));
				$str2 = url_slug($string, array('transliterate' => true));
				// echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
				// echo $str2;
				$sqlInsert2Eng .= $conn->quote($str2);

				// ---------- BEL --------------
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';

				$sqlGetTableRecord = 'SELECT `name_blr` FROM ' . $nameOfTable . ' WHERE id=' . $currentTableIdentifiers[$i];
				$res = $conn->query($sqlGetTableRecord);
				$string = $res->fetch()[0];
				// echo $string . '<br>';
				// echo url_slug($string, array('transliterate' => true));
				$str2 = url_slug($string, array('transliterate' => true));
				// echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
				// echo $str2;
				$sqlInsert2Bel .= $conn->quote($str2);
			} elseif ($row['Field'] == 'metakey') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('');
			} elseif ($row['Field'] == 'modified_by') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('636');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('636');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('636');
			} elseif ($row['Field'] == 'ordering') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('0');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('0');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('0');
			} elseif ($row['Field'] == 'hits') {
				if ($isFirst) {
					$isFirst = false;
				} else {
					$sqlInsert1 .= ', ';
					$sqlInsert2 .= ', ';
					
					$sqlInsert1Eng .= ', ';
					$sqlInsert2Eng .= ', ';
					
					$sqlInsert1Bel .= ', ';
					$sqlInsert2Bel .= ', ';
				}
				$sqlInsert1 .= '`' . $row['Field'] . '`';
				$sqlInsert2 .= $conn->quote('0');
				
				$sqlInsert1Eng .= '`' . $row['Field'] . '`';
				$sqlInsert2Eng .= $conn->quote('0');
				
				$sqlInsert1Bel .= '`' . $row['Field'] . '`';
				$sqlInsert2Bel .= $conn->quote('0');
			}
			$printTable .= '</td>';
		}
		$printTable .= '</tr>';

		$sqlInsert1 .= ') ';
		$sqlInsert2 .= ')';

		$finalRequest = $sqlInsert1 . $sqlInsert2;

		$finalRequest = mb_convert_encoding($finalRequest, 'UTF-8');

		echo '<xmp>' . $finalRequest . '</xmp>';

		$connSecond->query($finalRequest);
		
		$assetsRequest .= $connSecond->quote('532');
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->query('SELECT `lft` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 532 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->query('SELECT `rgt` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 532 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		// $assetsRequest .= $connSecond->query('657');
		// $assetsRequest .= ', ';
		// $assetsRequest .= $connSecond->query('658');
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->quote('3');
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->quote('com_content.article.' . $connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->quote(mb_strimwidth($connSecond->query('SELECT `title` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0], 0, 99, "..."));
		$assetsRequest .= ', ';
		$assetsRequest .= $connSecond->quote('{}');
		$assetsRequest .= ')';
		
		echo $assetsRequest . '<br><br>';
		
		$connSecond->query($assetsRequest);

		$workflowRequest .= $connSecond->quote($connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$workflowRequest .= ', ';
		$workflowRequest .= $connSecond->quote(1);
		$workflowRequest .= ', ';
		$workflowRequest .= $connSecond->quote('com_content.article');
		$workflowRequest .= ')';

		echo $workflowRequest;

		$connSecond->query($workflowRequest);
		
		// ------------- ENG ----------------

		$sqlInsert1Eng .= ') ';
		$sqlInsert2Eng .= ')';

		$finalRequestEng = $sqlInsert1Eng . $sqlInsert2Eng;

		$finalRequestEng = mb_convert_encoding($finalRequestEng, 'UTF-8');

		echo '<xmp>' . $finalRequestEng . '</xmp>';

		$connSecond->query($finalRequestEng);

		$assetsRequestEng .= $connSecond->quote('533');
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->query('SELECT `lft` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 533 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->query('SELECT `rgt` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 533 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		// 661 662
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->quote('3');
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->quote('com_content.article.' . $connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->quote(mb_strimwidth($connSecond->query('SELECT `title` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0], 0, 99, "..."));
		$assetsRequestEng .= ', ';
		$assetsRequestEng .= $connSecond->quote('{}');
		$assetsRequestEng .= ')';
		
		echo $assetsRequestEng . '<br><br>';
		
		$connSecond->query($assetsRequestEng);

		$workflowRequestEng .= $connSecond->quote($connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$workflowRequestEng .= ', ';
		$workflowRequestEng .= $connSecond->quote(1);
		$workflowRequestEng .= ', ';
		$workflowRequestEng .= $connSecond->quote('com_content.article');
		$workflowRequestEng .= ')';

		echo $workflowRequestEng;

		$connSecond->query($workflowRequestEng);
		
		// ------------- BEL ----------------

		$sqlInsert1Bel .= ') ';
		$sqlInsert2Bel .= ')';

		$finalRequestBel = $sqlInsert1Bel . $sqlInsert2Bel;

		$finalRequestBel = mb_convert_encoding($finalRequestBel, 'UTF-8');

		echo '<xmp>' . $finalRequestBel . '</xmp>';

		$connSecond->query($finalRequestBel);

		$assetsRequestBel .= $connSecond->quote('534');
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->query('SELECT `lft` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 534 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->query('SELECT `rgt` FROM `kqmj2_assets` WHERE `level` = 3 AND `parent_id` = 534 ORDER BY `id` DESC LIMIT 1')->fetch()[0] + 2;
		// 665 666
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->quote('3');
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->quote('com_content.article.' . $connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->quote(mb_strimwidth($connSecond->query('SELECT `title` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0], 0, 99, "..."));
		$assetsRequestBel .= ', ';
		$assetsRequestBel .= $connSecond->quote('{}');
		$assetsRequestBel .= ')';
		
		echo $assetsRequestBel . '<br><br>';
		
		$connSecond->query($assetsRequestBel);

		$workflowRequestBel .= $connSecond->quote($connSecond->query('SELECT `id` FROM `kqmj2_content` ORDER BY `id` DESC LIMIT 1')->fetch()[0]);
		$workflowRequestBel .= ', ';
		$workflowRequestBel .= $connSecond->quote(1);
		$workflowRequestBel .= ', ';
		$workflowRequestBel .= $connSecond->quote('com_content.article');
		$workflowRequestBel .= ')';

		echo $workflowRequestBel;

		$connSecond->query($workflowRequestBel);
	}

	$printTable .= '</tbody>';
	
	$printTable .= '</table>';

	echo $printTable;

	
	echo '</details><br>';
	
	echo '<br>';

	echo '<form method="post" action="second.php"><input type="submit" name="backToTables" value="К таблицам"></form>';
	echo '<br><a href="http://lawproject/"><input type="button" value="Выход"></a>';
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
		echo '<br><a href="http://lawproject/">back</a>';
	}	
}

?>