<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="styles/register.css">
  <style>
  </style>
</head>
<body>

<div class="container">
  <h1>Registration Form</h1>
  
  <?php
  require 'db_config.php';

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Get the user's input
      $name = $_POST['name'];
      $email = $_POST['email'];
      $contact = $_POST['contact'];
      $password = $_POST['password'];

      // Validate the user's input
      $errors = [];
      if (empty($name)) {
        $errors[] = 'Please enter your full name.';
      }
      if (empty($email)) {
        $errors[] = 'Please enter your email address.';
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
      }
      if (empty($contact)) {
        $errors[] = 'Please enter your contact number.';
      } elseif (!preg_match('/^\d{10}$/', $contact)) {
        $errors[] = 'Please enter a valid contact number.';
      }
      if (empty($password)) {
        $errors[] = 'Please enter a password.';
      } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
      } elseif ($password !== $_POST['confirm_password']) {
        $errors[] = 'Password and confirm password do not match.';
      }

      // If there are no errors, insert the user's information into the database
      if (empty($errors)) {
        $sql = "INSERT INTO users (name, email, contact, password) VALUES ('$name', '$email', '$contact', '$password')";
        $result = $conn->query($sql);
        if ($result) {
          header('Location: login.php');
          exit;
        } else {
          echo '<p class="error">Registration failed. Please try again.</p>';
        }
      } else {
        foreach ($errors as $error) {
          echo '<p class="error">' . $error . '</p>';
        }
      }
    }
  ?>

  <form method="post">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="contact">Contact:</label>
    <input type="text" id="contact" name="contact" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <label>Confirm Password:</label>
    <input type="password" name="confirm_password">

    <input type="submit" value="Register">
  </form>
</div>

</body>
</html>
