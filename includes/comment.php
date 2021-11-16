<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once('database.php');

class Comment extends DatabaseObject
{

    protected static $table_name = "comments";
    protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');

    public $id;
    public $photograph_id;
    public $created;
    public $author;
    public $body;
    public $email;

    public static function make($photo_id, $author = "Anonymous", $body = "")
    {
        if (!empty($photo_id) && !empty($author) && !empty($body)) {
            $comment = new Comment();
            $photos = Photograph::find_by_id($_GET['id']);
            $comment->photograph_id = (int)$photo_id;
            $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
            $comment->author = $author;
            $comment->body = $body;
            $comment->email = $photos->email;
            return $comment;
        } else {
            return false;
        }
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public static function find_commesnt_on($photo_id = 0)
    {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE photograph_id=" . $photo_id;
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
    }

    public function find_email() {
        $user = User::find_by_id($_SESSION['user_id']);
        $result_array = self::find_by_sql("SELECT * FROM users WHERE email='". User::$email ."'");
        return $result_array;
    }

    public function try_to_send_notification()
    {
        $mail = new PHPMailer(true);
        $photos = Photograph::find_by_id($_GET['id']);

        $photo_path = "../public/images/$photos->file_name";
        $mail->isSMTP();
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "ashishpanchal6574@gmail.com";
        $mail->Password = "jxhyusyyznwxvaqr";

        $to = $this->email;
        $mail->FromName = "Photo Gallery";
        $mail->From = "ashishpanchal6574@gmail.com";
        $mail->addAddress($to, "Photo Gallery Admin");
        $mail->isHTML(true);
        $mail->Subject = "New Photo Gallery Comment";
        $mail->addEmbeddedImage($photo_path, $photos->file_name, $photos->file_name);
        $mail->Body = <<<EMAILBODY

        <div style="text-align:center;">
            <h1>A new comment has been received...</h1>
		    <img src="cid:$photos->file_name" width="300" height=200" style="border-radius: 10px;"/>
            <h3>Photo's Owner :- $photos->photo_author</h3>
            <h3>Photo Name :- $photos->file_name</h3>
            <h3>Author :- $this->author</h3>
            <h3>Created :- $this->created</h3>
            <h3>Comment :- $this->body</h3>
        </div>
EMAILBODY;

        $result = $mail->send();
        return $result;
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

    public static function count_all()
    {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . self::$table_name;
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

    public function create()
    {
        global $database;
        $sql  = "INSERT INTO " . self::$table_name . " (photograph_id, created, author, body) ";
        $sql .= "VALUE ('$this->photograph_id', '$this->created', '$this->author', '$this->body') ";
        $result_array = $database->query($sql);
        return $result_array;
    }

    public function update()
    {
        global $database;
        $sql = "UPDATE users SET ";
        $sql .= "photograph_id='" . $this->photograph_id . "', ";
        $sql .= "created='" . $this->created . "', ";
        $sql .= "author='" . $this->author . "', ";
        $sql .= "body='" . $this->body . "' ";
        $sql .= "WHERE id=" . $this->id;
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
