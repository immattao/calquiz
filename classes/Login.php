<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    //The database connection
    private $db_connection = null;

    //Collection of error messages
    public $errors = array();

    //Collection of success / neutral messages
    public $messages = array();

    //the function "__construct()" automatically starts whenever an object of this class (Login) is created
    public function __construct()
    {
        // create/read session
        session_start();

        // check the possible login actions:
        // 1) log out (if user clicked logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // 2) login (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->doLogin();
        }
    }

    /**
     * log in with post data
     */
    private function doLogin()
    {
        // check login form contents
        if (empty($_POST['username'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // check if working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $username = $this->db_connection->real_escape_string($_POST['username']);

                // database query, getting all the info of the selected user (allows login via email address in the username field)
                $sql = "SELECT userID, username, email, password_hash
                        FROM user
                        WHERE username = '" . $username . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['password'], $result_row->password_hash)) {

                        // write user data into PHP SESSION (a file on the server)
                        $_SESSION['userID'] = $result_row->userID;
                        $_SESSION['username'] = $result_row->username;
                        $_SESSION['email'] = $result_row->email;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = $this->db_connection->connect_errno."Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        
        // return a little feedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
?>