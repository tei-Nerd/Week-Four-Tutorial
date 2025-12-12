<form method="post">
    Enter Email: <input type="text" name="email">
    <button>Check</button>
</form>

<?php
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (strpos($email, "@") === false || 
        strpos($email, ".") === false || 
        strpos($email, "@") == 0) {

        echo "Email format incorrect (basic check).";
    } else {
        echo "Email format looks okay.";
    }
}
?>
