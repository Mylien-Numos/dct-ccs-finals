<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to get the list of users (for demonstration purposes, this is hardcoded)
function getUsers() {
    return [
        ["email" => "myss@email.com", "password" => "password1234"],
        ["email" => "myss1@email.com", "password" => "password21"],
        ["email" => "mylien@email.com", "password" => "123"],
        ["email" => "myliennumos@email.com", "password" => "pass12345678"],
        // Add more users as needed
    ];
}

// Function to validate login credentials
function validateLoginCredentials($email, $password) {
    $errors = [];
    if (empty($email)) $errors[] = "Email is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($password)) $errors[] = "Password is required.";
    return $errors;
}

// Function to check if the login credentials are correct
function checkLoginCredentials($email, $password) {
    foreach (getUsers() as $user) {
        if ($user["email"] === $email && $user["password"] === $password) {
            return true;
        }
    }
    return false;
}

// Function to display errors (for login validation)
function displayErrors($errors) {
    if (empty($errors)) return "";
    $output = "<div class='alert alert-danger' role='alert'><strong>Errors:</strong><ul>";
    foreach ($errors as $error) $output .= "<li>$error</li>";
    $output .= "</ul></div>";
    return $output;
}

// Function to sanitize input data (to prevent XSS attacks)
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

?>
