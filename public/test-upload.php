<?php
// public/test-upload.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h1>Upload Received!</h1>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['file']['tmp_name'];
        $name = basename($_FILES['file']['name']);
        $destination = __DIR__ . '/uploads/' . $name;
        
        // Create uploads folder if it doesn't exist
        if (!is_dir(__DIR__ . '/uploads')) {
            mkdir(__DIR__ . '/uploads', 0777, true);
        }

        if (move_uploaded_file($tmpName, $destination)) {
            echo "<p style='color:green'>✅ SUCCESS! File saved to: " . $destination . "</p>";
        } else {
            echo "<p style='color:red'>❌ FAILED to move file. Check permissions.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Upload Error Code: " . ($_FILES['file']['error'] ?? 'No file') . "</p>";
        echo "<p>Error Meanings: 0=Success, 1=Too Large, 3=Partial, 6=No Temp Folder, 7/8=Write Failed</p>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Raw PHP Upload Test</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    <hr>
    <h3>PHP Info:</h3>
    <p>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></p>
    <p>post_max_size: <?php echo ini_get('post_max_size'); ?></p>
    <p>file_uploads: <?php echo ini_get('file_uploads') ? 'On' : 'Off'; ?></p>
    <p>upload_tmp_dir: <?php echo ini_get('upload_tmp_dir'); ?></p>
</body>
</html>