<?php
session_start();
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username, email, and password are set
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Get form data
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate input (You should add more validation)
        if (empty($username) || empty($password)) {
            echo "All fields are required.";
            exit;
        }

        // Check if username or email already exists in the database
        $query = "SELECT * FROM adminaccount WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username already exists.";
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $insert_query = "INSERT INTO adminaccount (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            // Registration successful, redirect to index.php with success message
            $_SESSION['registration_success'] = true;
            header("Location: adminregister.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
}
?>
