<?php
class Users extends PDO
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
	public function login_record($user, $password){
		$sql = "SELECT id, online FROM users WHERE name='$user' and password='$password'"; 
		$result = self::$dbh->query($sql);	
      $row = $result->fetch();
      if($row['id'] > 0) {
      	if($row['online']== 0 )	{
				$sql = "UPDATE users SET online=1 WHERE name = '$user'";
				$result = self::$dbh->query($sql);
				if($result){$answer = "Вход в систему выполнен";}
			}
			elseif($row['online']== 1 ) {
				$answer = "Вход в систему был выполнен ранее";
			}
		}
		else {
			$answer = "Пользователь не зарегистрирован";
		}	
		return $answer;
	}
		
	public function logout_record($user){
		$sql = "SELECT id, online,name FROM users WHERE name='$user'"; 
		$result = self::$dbh->query($sql);
		$row = $result->fetch();
   	if($row['id'] > 0) {
   		if($row['online'] == 1) {
				$sql = "UPDATE users SET online=0 WHERE name = '$user'";
				$result = self::$dbh->query($sql);
					if($result){$answer = "Выход из системы выполнен";}
				}
				elseif($row['online'] == 0) {$answer = "Пользователь не входил в систему";}
				
		}
		else {$answer = "Пользователь не зарегистрирован в системе";}
		return $answer;
	}

	public function insert_record($user, $password, $email){
		$sql = "SELECT id FROM users WHERE name='$user' and password='$password'"; 
		$result = self::$dbh->query($sql);
     	$row = $result->fetch();
     	if(!$row['id']) 	{
			$sql = "INSERT INTO users (name, password, email, online) values ('$user', '$password', '$email', 0)";
			$result = self::$dbh->query($sql);	
			if($result){$answer = "Пользователь зарегистрирован";}
		}
		else {$answer = "Такой пользователь в системе уже есть";}
		return $answer;
	}
}
?>