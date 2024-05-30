<?php
// Include the database configuration file
require_once('config.php');

// Handle form submission to add a new torrent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Validate and sanitize user inputs as needed
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    // File upload handling
    $uploadDir = "torrent_files/"; // Specify the folder where torrent files should be stored

    $torrentFile = $_FILES['torrent_file'];

    // Check if a file was uploaded successfully
    if ($torrentFile['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($torrentFile['name']);
        $targetFilePath = $uploadDir . $fileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($torrentFile['tmp_name'], $targetFilePath)) {
            // Initialize the image variables
            $imageFileName = null;
            $targetImagePath = null;

            // Check if an image file was uploaded
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageFile = $_FILES['image'];
                $imageFileName = basename($imageFile['name']);
                $targetImagePath = "images/" . $imageFileName;

                // Move the uploaded image file to the specified directory
                if (!move_uploaded_file($imageFile['tmp_name'], $targetImagePath)) {
                    echo "Error uploading the image file.";
                    exit; // Exit the script
                }
            }

            // Insert torrent data into the database, including the file path and image path
            $insertSql = "INSERT INTO torrents (title, description, file_path, image_path, uploaded_by) VALUES ('$title', '$description', '$targetFilePath', '$targetImagePath', 'uploaded_by_here')";

            if ($conn->query($insertSql) === TRUE) {
                echo "Torrent added successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Error uploading the torrent file.";
        }
    } else {
        echo "File upload error: " . $torrentFile['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Torrent Tracker - Add Torrent</title>
</head>
<body>
    <h1>Add a New Torrent</h1>
    <form action="" method="POST" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br><br>

    <label for="description">Description:</label><br>
    <textarea name="description" rows="4" cols="50" required></textarea><br><br>

    <label for="torrent_file">Torrent File:</label>
    <input type="file" name="torrent_file" required><br><br>

    <label for="image">Image:</label>
    <input type="file" name="image"><br><br>

    <input type="submit" value="Add Torrent">
</form>
    <a href="index.php">Back to Home</a>
</body>
</html>

