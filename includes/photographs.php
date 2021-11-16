<?php
require_once('database.php');

class Photograph extends DatabaseObject
{

    protected static $table_name = "photographs";
    protected static $db_fields = array('file_name', 'file_type', 'size', 'caption', 'photo_author', 'email');
    public $id;
    public $file_name;
    public $file_type;
    public $size;
    public $caption;
    public $photo_author;
    public $email;

    private $temp_path;
    protected $upload_dir = "images";
    public $errors = array();

    protected $upload_errors = array(
        UPLOAD_ERR_OK         => "No errors.",
        UPLOAD_ERR_INI_SIZE   => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL    => "Partial upload.",
        UPLOAD_ERR_NO_FILE    => "No file.",
        UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION  => "File upload stopped by extension."
    );

    public static function make()
    {
        if (!empty($photo_id) && !empty($author) && !empty($body)) {
            $comment = new Comment();
            $user = User::find_by_id($_SESSION['user_id']);
            $comment->photo_author = $user->username;
            $comment->email = $user->email;
            return $comment;
        } else {
            return false;
        }
    }

    public function attach_file($file)
    {
        if (!$file || empty($file) || !is_array($file)) {
            $this->errors[] = "No file was uploaded.";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            $this->temp_path  = $file['tmp_name'];
            $this->file_name   = basename($file['name']);
            $this->file_type       = $file['type'];
            $this->size       = $file['size'];
            return true;
        }
    }

    public function save()
    {
        if (isset($this->id)) {
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return false;
            }
            if (strlen($this->caption) > 20) {
                $this->errors[] = "The caption can only be 20 characters long.";
                return false;
            }

            if (empty($this->file_name) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return false;
            }
            $myfile2 = realpath(dirname(__FILE__) . '/..');
            $target_path = $myfile2 . "\public\\" . $this->upload_dir . "\\" . $this->file_name;

            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->file_name} already exists. Please Change your photo Name...";
                return false;
            }
            if (move_uploaded_file($this->temp_path, $target_path)) {
                if ($this->create()) {
                    unset($this->temp_path);
                    return true;
                }
            } else {
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }
        }
    }

    public function destroy() {
        if($this->delete($this->id)) {
            $myfile2 = realpath(dirname(__FILE__) . '/..');
            $target_path = $myfile2 . "\public\\" . $this->upload_dir . "\\" . $this->file_name;
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }

    public function image_path()
    {
        $path = $this->upload_dir . '\\' . $this->file_name;
        return $path;
    }

    public function size_as_text()
    {
        if ($this->size < 1024) {
            return "{$this->size} bytes";
        } else if ($this->size < 1048576) {
            $size_kb = round($this->size / 1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size / 1048576, 1);
            return "{$size_mb} MB";
        }
    }

    public static function find_all()
    {
        return self::find_by_sql("SELECT * FROM " . self::$table_name);
    }

    public static function find_by_id($id) 
    {
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_only_user() {
        $user = User::find_by_id($_SESSION['user_id']);
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE photo_author='{$user->username}'");
        return $result_array;
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

    protected function attributes()
    {
        $attributes = array();
        foreach (self::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    public function create()
    {
        $user = User::find_by_id($_SESSION['user_id']);
        global $database;
        $sql  = "INSERT INTO " . self::$table_name . " (file_name, file_type, size, caption, photo_author, email) ";
        $sql .= "VALUE ('$this->file_name', '$this->file_type', '$this->size', '$this->caption', '$user->username', '$user->email') ";
        $result_array = $database->query($sql);
        return $result_array;
    }
    
    public function update()
    {
        $user = User::find_by_id($_SESSION['user_id']);
        global $database;
        $sql = "UPDATE users SET ";
        $sql .= "file_name='" . $this->file_name . "', ";
        $sql .= "file_type='" . $this->file_type . "', ";
        $sql .= "size='" . $this->size . "', ";
        $sql .= "caption='" . $this->caption . "' ";
        $sql .= "photo_author='" . $user->username . "' ";
        $sql .= "email='" . $user->email . "' ";
        $sql .= "WHERE id=" . $this->id;
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete($id)
    {
        global $database;
        $sql = "DELETE FROM " . self::$table_name;
        $sql .= " WHERE id=" . $id;
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
}
