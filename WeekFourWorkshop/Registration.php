<?php
// Define variables to store user input and error messages
$name = $email = $password = $confirm_password = "";
$name_error = $email_error = $password_error = $confirm_password_error = "";
$success_message = $system_error = "";
$is_valid = true;

// 2. Implement form validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Helper function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Sanitize and validate Name
    $name = sanitize_input($_POST["name"]);
    if (empty($name)) {
        $name_error = "Name is required.";
        $is_valid = false;
    }

    // Sanitize and validate Email
    $email = sanitize_input($_POST["email"]);
    if (empty($email)) {
        $email_error = "Email address is required.";
        $is_valid = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format.";
        $is_valid = false;
    }

    // Sanitize and validate Password
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($password)) {
        $password_error = "Password is required.";
        $is_valid = false;
    } else {
        // Password criteria: min 8 characters, at least one special character, one number, one uppercase.
        if (strlen($password) < 8) {
            $password_error .= "Must be at least 8 characters long. ";
            $is_valid = false;
        }
        // Check for at least one number
        if (!preg_match("/\d/", $password)) {
            $password_error .= "Must contain at least one number. ";
            $is_valid = false;
        }
        // Check for at least one uppercase letter
        if (!preg_match("/[A-Z]/", $password)) {
            $password_error .= "Must contain at least one uppercase letter. ";
            $is_valid = false;
        }
        // Check for at least one special character (using common special chars)
        if (!preg_match("/[^a-zA-Z\d]/", $password)) {
            $password_error .= "Must contain at least one special character. ";
            $is_valid = false;
        }
    }

    // Validate Confirm Password
    if (empty($confirm_password)) {
        $confirm_password_error = "Confirm password is required.";
        $is_valid = false;
    } else if ($password !== $confirm_password) {
        $confirm_password_error = "Passwords do not match.";
        $is_valid = false;
    }

    // If validation passes, proceed with registration logic
    if ($is_valid) {
        $json_file = 'users.json';
        
        // 9. Implement error handling (File Read/Write)
        
        // 4. Read the contents of "users.json" and decode it
        $json_data = file_get_contents($json_file);
        if ($json_data === false) {
            $system_error = "Error: Could not read user data file.";
        } else {
            $users = json_decode($json_data, true);
            
            if ($users === null && json_last_error() !== JSON_ERROR_NONE) {
                 $system_error = "Error: Invalid JSON data in user file. Error: " . json_last_error_msg();
            } else {
                // Handle case where file is empty but valid (e.g., empty string)
                if (!is_array($users)) {
                    $users = [];
                }
                
                // Check if email already exists
                $email_exists = false;
                foreach ($users as $user) {
                    if ($user['email'] === $email) {
                        $email_error = "This email address is already registered.";
                        $is_valid = false;
                        $system_error = ""; // Clear system error if a validation error is found
                        break;
                    }
                }

                if ($is_valid) {
                    // 5. Hash the user's password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Store user data in an associative array
                    $new_user = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $hashed_password // Hashed password
                    ];

                    // 6. Add the new user's associative array to the existing array
                    $users[] = $new_user;

                    // 7. Write the updated array back to "users.json"
                    $json_data_new = json_encode($users, JSON_PRETTY_PRINT);
                    if ($json_data_new === false) {
                        $system_error = "Error: Could not encode user data to JSON.";
                    } else {
                        // Use FILE_LOCK to prevent concurrent writes causing corruption
                        if (file_put_contents($json_file, $json_data_new, LOCK_EX) !== false) {
                            // 8. Provide user feedback after successful registration
                            $success_message = "Registration successful! You can now log in.";
                            
                            // Clear form fields on success
                            $name = $email = $password = $confirm_password = "";

                        } else {
                            $system_error = "Error: Could not write to user data file. Check file permissions!";
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        .error { color: #dc3545; font-size: 0.9em; }
        .success { color: #28a745; font-weight: bold; }
        .system-error { color: #ffc107; font-weight: bold; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 8px; border: 1px solid #ccc; box-sizing: border-box;
        }
    </style>
</head>
<body>

    <header>
        <h1>👤 User Registration</h1>
    </header>

    <?php if ($success_message): ?>
        <div class="success">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($system_error): ?>
        <div class="system-error">
            <p>System Error: <?php echo $system_error; ?></p>
        </div>
    <?php endif; ?>

    <hr>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            <span class="error"><?php echo $name_error; ?></span>
        </div>

        <div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <span class="error"><?php echo $email_error; ?></span>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error"><?php echo $password_error; ?></span>
            <small>Criteria: Min 8 chars, 1 uppercase, 1 number, 1 special char.</small>
        </div>

        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="error"><?php echo $confirm_password_error; ?></span>
        </div>

        <div>
            <input type="submit" value="Register User">
        </div>
    </form>
    
</body>
</html>