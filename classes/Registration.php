<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();" 
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        if (empty($_POST['username'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['password_new']) || empty($_POST['password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['password_new'] !== $_POST['password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['username']) > 64 || strlen($_POST['username']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['username'])
            && strlen($_POST['username']) <= 64
            && strlen($_POST['username']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['username'])
            && !empty($_POST['email'])
            && strlen($_POST['email']) <= 64
            && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['password_new'])
            && !empty($_POST['password_repeat'])
            && ($_POST['password_new'] === $_POST['password_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
         
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $username = $this->db_connection->real_escape_string(strip_tags($_POST['username'], ENT_QUOTES));
                $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));

                //store user input of password
                $password = $_POST['password_new'];

                // encrypt the user's password with PHP 5.5's password_hash() function
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM user WHERE username = '" . $username . "' OR email = '" . $email . "';";
                $query_check_username = $this->db_connection->query($sql);

                if ($query_check_username->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO user (username, password_hash, email)
                            VALUES('" . $username . "', '" . $password_hash . "', '" . $email . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}