<?php
// Include the database configuration file
require_once('config.php');

// Query to fetch torrent data
$sql = "SELECT id, title, description, file_path, image_path FROM torrents";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Torrent Tracker - Home</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
</head>
<body>
    <header>
        <h1>Welcome to the Torrent Tracker</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <!-- Add other navigation links as needed -->
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Available Torrents</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='torrent-card'>";
                echo "<h3>Torrent Title: " . $row["title"] . "</h3>";
                echo "<p>Description: " . $row["description"] . "</p>";

                // Display the uploaded image if the key exists and the file exists
                if (isset($row["image_path"]) && !empty($row["image_path"]) && file_exists($row["image_path"])) {
                    echo "<img src='" . $row["image_path"] . "' alt='Torrent Image' width='200'>";
                }

                // Add a download button/link for the torrent file
                echo "<a href='" . $row["file_path"] . "' download class='download-link'>Download Torrent</a>";

                echo "</div>";
            }
        } else {
            echo "<p>No torrents available.</p>";
        }
        ?>
    </div>

    <footer>
        <!-- Footer content goes here -->
    </footer>
</body>
</html>