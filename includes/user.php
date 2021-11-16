<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class User extends DatabaseObject
{

	protected static $table_name = "users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'email');

	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $email;

	public function full_name()
	{
		if (isset($this->first_name) && isset($this->last_name)) {
			return $this->first_name . " " . $this->last_name;
		} else {
			return "";
		}
	}

	public static function add_user($first_name = "", $last_name = "", $username = "", $password = "", $email)
	{
		global $database;
		$sql  = "INSERT INTO " . self::$table_name . " (username, PASSWORD, first_name, last_name, email) ";
		$sql .= "VALUE ('$username', '$password', '$first_name', '$last_name', '$email') ";
		$result_array = $database->query($sql);
		return $result_array;
	}
	public static function authenticate($username = "", $password = "")
	{
		global $database;
		// $username = $database->$username;
		// $password = $database->$password;

		$sql  = "SELECT * FROM users ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_all()
	{
		return self::find_by_sql("SELECT * FROM " . self::$table_name);
	}

	public static function find_by_id($id = 0)
	{
		$result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function find_by_sql($sql = "")
	{
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ". self::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

	private static function instantiate($record)
	{
		$object = new self;
		foreach ($record as $attribute => $value) {
			if ($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	private function has_attribute($attribute)
	{
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
	}

	public function update()
	{
		global $database;
		$sql = "UPDATE users SET ";
		$sql .= "username='". $this->username ."', ";
		$sql .= "password='". $this->password ."', ";
		$sql .= "first_name='". $this->first_name ."', ";
		$sql .= "last_name='". $this->last_name ."' ";
		$sql .= "email='". $this->email ."' ";
		$sql .= "WHERE id=". $this->id;
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public static function delete($id)
	{
		global $database;
		$sql = "DELETE FROM " . self::$table_name;
		$sql .= " WHERE id=" . $id;
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
}
