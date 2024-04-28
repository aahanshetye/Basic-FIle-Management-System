<?php
$filename = 'sample.txt'; // The file to operate on

switch ($action) {
    case 'view':
        if (file_exists($filename)) {
            $fp = fopen($filename, 'r'); // Open file for reading
            $content = fread($fp, filesize($filename)); // Read the whole file
            fclose($fp); // Close the file
            echo "<h3>File Contents:</h3>";
            echo "<pre>" . htmlspecialchars($content) . "</pre>"; // Display content in a pre-formatted block
        } else {
            echo "<p>The file does not exist.</p>";
        }
        break;

    case 'write':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            $fp = fopen($filename, 'w'); // Open file for writing, truncate existing content
            fwrite($fp, $_POST['content']); // Write new content
            fclose($fp); // Close the file
            echo "<p>File written successfully.</p>";
        } else {
            echo '
            <h3>Write to File</h3>
            <form method="post">
                <textarea name="content" class="form-control" rows="5" placeholder="Enter text to write"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Write</button>
            </form>';
        }
        break;

    case 'append':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            $fp = fopen($filename, 'a'); // Open file for appending
            fwrite($fp, "\n" . $_POST['content']); // Append new content with newline
            fclose($fp); // Close the file
            echo "<p>File appended successfully.</p>";
        } else {
            echo '
            <h3>Append to File</h3>
            <form method="post">
                <textarea name="content" class="form-control" rows="5" placeholder="Enter text to append"></textarea>
                <button type="submit" class="btn btn-primary mt-2">Append</button>
            </form>';
        }
        break;

    case 'delete':
        if (file_exists($filename)) {
            unlink($filename); // Delete the file
            echo "<p>File deleted successfully.</p>";
        } else {
            echo "<p>The file does not exist.</p>";
        }
        break;

    case 'download':
        if (file_exists($filename)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $fp = fopen($filename, 'r'); // Open file for reading
            fpassthru($fp); // Stream the file to the client
            fclose($fp); // Close the file
            exit; // End script to avoid further processing
        } else {
            echo "<p>The file does not exist.</p>";
        }
        break;

    default:
        echo "<p>No action specified.</p>";
}
?>
