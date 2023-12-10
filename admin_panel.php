<?php
session_start();

// Check if the admin is not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

// Handle movie cover upload and database update here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDirectory =  "assets/moviepics/";
    $targetFile = $targetDirectory . basename($_FILES["movieCover"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["movieCover"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    if ($_FILES["movieCover"]["size"] > 500000) {
        echo "File size is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Invalid file format. Only JPG, PNG, and JPEG files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["movieCover"]["tmp_name"], $targetFile)) {
            $movieTitle = $_POST['movieTitle'];
            $mainLink = $_POST['mainLink'];
            $server1Link = $_POST['server1Link'];
            $server2Link = $_POST['server2Link'];
            $server3Link = $_POST['server3Link'];

            $filename = basename($targetFile);

            $host = "localhost";
            $username = "root";
            $password = ""; // Add your database password here
            $database = "filmnest";

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO movies (moviepic, title, mainlink, server1, server2, server3)
                    VALUES ('$filename', '$movieTitle', '$mainLink', '$server1Link', '$server2Link', '$server3Link')";
            if ($conn->query($sql) === true) {
                echo "Movie added successfully.";
            } else {
                echo "Error updating movie information: " . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            margin-top: 20px;
            color: #333;
            text-decoration: none;
            display: block;
        }

        a:hover {
            color: #4caf50;
        }
    </style>
</head>
<body>
    <h2>Welcome to the Admin Panel</h2>
    <form method="post" action="admin_panel.php" enctype="multipart/form-data">
        <label for="movieCover">Movie Cover:</label>
        <input type="file" id="movieCover" name="movieCover" accept="image/*" required>

        <label for="movieTitle">Movie Title:</label>
        <input type="text" id="movieTitle" name="movieTitle" required>

        <label for="mainLink">Main Link:</label>
        <input type="text" id="mainLink" name="mainLink" required>

        <label for="server1Link">Server 1 Link:</label>
        <input type="text" id="server1Link" name="server1Link" required>

        <label for="server2Link">Server 2 Link:</label>
        <input type="text" id="server2Link" name="server2Link" required>

        <label for="server3Link">Server 3 Link:</label>
        <input type="text" id="server3Link" name="server3Link" required>

        <button type="submit" name="submit">Upload Movie</button>
    </form>
    
    <a href="logout.php">Logout</a>
</body>
</html>
