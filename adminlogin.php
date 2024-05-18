<?php
session_start();
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
            echo "All fields are required.";
            exit;
        }

        $query = "SELECT * FROM adminaccount WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Password is correct, set username in session
                $_SESSION['username'] = $username;
                header("Location: admindashboard.php");
                exit;
            } else {
                echo "Incorrect password.";
                exit;
            }
        } else {
            echo "No user found with this username.";
            exit;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
}
?>
