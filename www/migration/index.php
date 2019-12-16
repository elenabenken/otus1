<?php

// Объявляем нужные константы
define('DB_TABLE_VERSIONS', 'versions');
define('DB_NAME', 'shop');


// Подключаемся к базе данных
function connectDB() {
     if (!$settings = parse_ini_file('my_setting.ini', TRUE)) throw new exception('Unable to open ' . $file . '.');
       
        $dsn = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') ;
      //  .         ';dbname=' . $settings['database']['schema'];
               
		try {
    		$dbh = new PDO($dsn, $settings['database']['username'], $settings['database']['password']); 
    		$sql = "CREATE DATABASE IF NOT EXISTS`shop` ";
    		$dbh->query($sql);
    		$sql = "USE`shop` ";
    		$dbh->query($sql);
    		
		} catch (PDOException $e) {

			echo 'Подключение не удалось: ' . $e->getMessage();
			
		}
		return $dbh;
}


// Получаем список файлов для миграций
function getMigrationFiles($conn) {
    // Находим папку с миграциями
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');

    // Получаем список всех sql-файлов
    $allFiles = glob($sqlFolder . '*.sql');

    // Проверяем, есть ли таблица versions 
    // Так как versions создается первой, то это равносильно тому, что база не пустая
    $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $data = $conn->query($query);
    $firstMigration = $data->fetch();
   
    // Первая миграция, возвращаем все файлы из папки sql
    if (!$firstMigration) {
	    return $allFiles;
    }

    // Ищем уже существующие миграции
    $versionsFiles = array();
    // Выбираем из таблицы versions все названия файлов
    $query = sprintf('select `name` from `%s`', DB_TABLE_VERSIONS);
    //$data = $conn->query($query);
    
    // Загоняем названия в массив $versionsFiles
    // Не забываем добавлять полный путь к файлу
    foreach ($conn->query($query) as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    // Возвращаем файлы, которых еще нет в таблице versions
    return array_diff($allFiles, $versionsFiles);
}


// Накатываем миграцию файла
function migrate($conn, $file) {
    // Формируем команду выполнения mysql-запроса из внешнего файла
	 $query = file_get_contents($file);
	 $conn->query($query);
    // Вытаскиваем имя файла, отбросив путь
    $baseName = basename($file);
    echo $basename . "<br />";
    // Формируем запрос для добавления миграции в таблицу versions
    $query = sprintf('insert into `%s` (`name`) values ("%s")', DB_TABLE_VERSIONS, $baseName);
    echo $query. "<br />";
    // Выполняем запрос
    $res = $conn->query($query);

}


// Стартуем

// Подключаемся к базе
$conn = connectDB();

// Получаем список файлов для миграций за исключением тех, которые уже есть в таблице versions
$files = getMigrationFiles($conn);

// Проверяем, есть ли новые миграции
if (empty($files)) {
    echo 'Ваша база данных в актуальном состоянии';
} else {
    echo 'Начинаем миграцию<br /><br />';

    // Накатываем миграцию для каждого файла
    foreach ($files as $file) {
        migrate($conn, $file);
        // Выводим название выполненного файла
        echo basename($file) . '<br />';
    }

    echo '<br />Миграция завершена';    
}
