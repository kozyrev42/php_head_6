<meta charset="utf-8">
<?php 		
// скрипт для санкционирования рейтинга
require_once('appvars.php');
require_once('connectvars.php');

// назначение переменным поступившими данными
// если в сценарий приходит GET запрос, извлекаем из него данные
if (isset($_GET['id']) && 
    isset($_GET['date']) && 
    isset($_GET['name']) &&
	isset($_GET['score']) && 
    isset($_GET['images']))   
	{
	// извлечение данных рейтинга из суперглобального массива $_GET
	$id = $_GET['id'];
	$date = $_GET['date'];
	$name = $_GET['name'];
	$score = $_GET['score'];
	$screenshot = $_GET['images'];
    echo '<p > GET ПОЛУЧЕН </p>';
}
else if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score'])) {
	// ИНАЧЕ извлечение данных из массива $_POST
	$id = $_POST['id'];
	$name = $_POST['name'];
	$score = $_POST['score'];
    $screenshot = $_POST['screenshot'];
    echo '<p > POST ПОЛУЧЕН </p>';
}
else {
	echo '<p class="error"> Ошибка </p>';
}


// если данные пришли по средствам $_POST из формы в этом же скрипте, в результате события 'submit'
if (isset($_POST['submit'])) {
	if ($_POST['confirm']=='yes') {			// если чекбокс активирован, выполнется блок
		
		$dbc = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);

		// замена значения ячейки на "1" исли id записи совпадает с прилетевшим id в результате запроса
		$query = "UPDATE score_list SET `approved`=1 WHERE id = $id";
		mysqli_query($dbc, $query);
		mysqli_close($dbc);

		echo '<p> запись успешно санкционированна! </p>';
	}
	else {
		echo '<p> Не санкционированно, где есть ошибка </p>';
	}
} 
// если данные $_POST в результате события 'submit' не пришли > тогда форму на подтверждение удаления
else if (isset($id) && isset($name) && isset($date)
		&& isset($score) && isset($screenshot))  
		{
	echo '<p> Вы уверены, что хотите санкционировать этот рейтинг?</p>';
	echo '<p> Имя:' . $name . '<br/> Дата:' . $date .
		  '<br/> Рейтинг:' . $score .
          '<br/> изображение:' . $screenshot .
          '</p>';
	echo '<form method="post" action="sanc.php">';
	echo '<input type="radio" name="confirm" value="yes"/> Да ';
	echo '<input type="radio" name="confirm" value="no" checked="checked" /> Нет <br/> ';
	echo '<input type="submit" value="Санкционировать" name="submit" />';
	echo '<input type="hidden" name="id" value="'. $id .'"/>';
    echo '<input type="hidden" name="name" value="'. $name .'"/>';
	echo '<input type="hidden" name="score" value="'. $score .'"/>';
    echo '<input type="hidden" name="screenshot" value="'. $screenshot .'"/>';
	echo '</form>';	
} 
	echo '<p> <a href="admin.php"> &lt; Назад к списку рейтингов </a> </p>';


echo '<p> <a href="admin.php"> назад к странице Админ </a> </p>';
?>