<meta charset="utf-8">
<?php 		
// скрипт для 
require_once('appvars.php');
require_once('connectvars.php');

// если данные пришли по средствам $_POST из формы в этом же скрипте, в результате события 'submit'
if (isset($_POST['submit'])) {
	if ($_POST['confirm']=='yes') 	// если чекбокс активирован, выполнется блок
		{
        
		$dbc = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);

		// удаление рейтинга из БД
		$query = "UPDATE score_list SET `approved`=1 WHERE id = $id";
		mysqli_query($dbc, $query);
		mysqli_close($dbc);

		echo '<p> запись успешно санкционированна! </p>';
	}
	else {
		echo '<p> Не санкционированно, где есть ошибка </p>';
	}
}
echo '<p> <a href="admin"> назад к странице Админ </a> </p>';
?>