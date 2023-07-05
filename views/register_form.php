<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- register form -->
<br><br>
<h2>Create your Calquiz account</h2>
<form method="post" action="register.php" name="registerform">
    <br><br>
    <!-- the user name input field uses a HTML5 pattern check -->
    <label>Username (only letters and numbers, 2 to 64 characters)</label> <br>
    <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="username" required />
    <br><br>

    <!-- the email input field uses a HTML5 email type check -->
    <label>Email</label> <br>
    <input type="email" name="email" required />
    <br><br>

    <label>Password (min. 6 characters)</label> <br>
    <input type="password" name="password_new" pattern=".{6,}" required autocomplete="off" />
    <br><br>

    <label>Repeat password</label> <br>
    <input type="password" name="password_repeat" pattern=".{6,}" required autocomplete="off" />
    <br><br>
    
    <input type="submit"  name="register" value="Register" />
    <br>

</form>

<!-- backlink -->
<br>
<a href="index.php">Back to Login Page</a>

