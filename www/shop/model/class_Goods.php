<?php

class Goods extends PDO
{
	public static $dbh;
	public function __construct() {
        if (!$settings = parse_ini_file('my_setting.ini', TRUE)) throw new exception('Unable to open ' . $file . '.');
       
        $dsn = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
                
		try {
    		self::$dbh = new PDO($dsn, $settings['database']['username'], $settings['database']['password']); 
		} catch (PDOException $e) {
    		echo 'Подключение не удалось: ' . $e->getMessage();
		}
	}
	
	function insert_good ($good_name, $good_price, $good_category){
		$sql = "SELECT id FROM goods WHERE name='$good_name'"; 
		$result = self::$dbh->query($sql);	
   	$row = $result->fetch();
   	if(!$row['id'] ) {
			$sql = "INSERT INTO goods (name, price, category) VALUES ('$good_name', '$good_price', '$good_category')";
			$result = self::$dbh->query($sql);
			if($result){$answer = "Товар добавлен";}
		}
		elseif($row['id'] > 0) {$answer = "такой товар уже указан в магазине";}	
		return $answer;
	}

	function delete_good ($good_name){
		$sql = "SELECT id FROM goods WHERE name='$good_name'"; 
		
		$result = self::$dbh->query($sql);	
   	$row = $result->fetch();
   	if($row['id'] > 0) {
			$sql = "DELETE FROM goods WHERE name='$good_name'";
			$result = self::$dbh->query($sql);
			if($result){$answer = "Товар удален";}
		}
		else {$answer = "Товар, который вы хотите удалить, в системе не найден";}
		return $answer;
	}

	function update_good ($good_name, $good_price, $good_category){
		$sql = "SELECT id FROM goods WHERE name='$good_name'"; 
		$result = self::$dbh->query($sql);	
   	$row = $result->fetch();
   	$id = $row['id'];
   	if($row['id'] > 0) {
			$sql = "UPDATE goods SET name='$good_name', price='$good_price', category='$good_category' WHERE id='$id'";
			$result = self::$dbh->query($sql);
			echo $sql;
			if($result) {$answer = "Данные товара изменены";}
		}
		else {$answer = "Товар, данные которого вы хотите изменить, в системе не найден";}
		return $answer;
	}	

	function list_goods(){
		$sql = 'SELECT id, name, price, category FROM goods';
		$result = self::$dbh->query($sql);
		$row = $result->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}
}
?>