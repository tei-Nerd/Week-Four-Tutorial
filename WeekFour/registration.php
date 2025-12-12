<form method="post">
    Name: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="pass"><br>
    Confirm Password: <input type="password" name="cpass"><br>
    <button>Submit</button>
</form>

<?php
if (!empty($_POST)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $p = $_POST['pass'];
    $cp = $_POST['cpass'];

    if ($name=="" || $email=="" || $p=="" || $cp=="") {
        echo "<p style='color:red;'>All fields required!</p>";
    } elseif ($p != $cp) {
        echo "<p style='color:red;'>Passwords do not match!</p>";
    } else {
        $strength = strlen($p) >= 8 ? "Strong" : "Weak";

        echo "<h3>Registration Preview:</h3>";
        echo "Name: $name<br>";
        echo "Email: $email<br>";
        echo "Password Strength: $strength";
    }
}
?>
