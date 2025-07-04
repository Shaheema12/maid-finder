<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadsDir = "uploads/";
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir);
    }

    $photo = $_FILES['photo'];
    $photoName = basename($photo['name']);
    $photoPath = $uploadsDir . time() . "_" . $photoName;

    if (move_uploaded_file($photo["tmp_name"], $photoPath)) {
        $maid = [
            "photo" => $photoPath,
            "name" => $_POST["name"],
            "age" => $_POST["age"],
            "email" => $_POST["email"],
            "salary" => $_POST["salary"],
            "location" => $_POST["location"]
        ];

        $file = "maids.json";
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $data[] = $maid;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        
        header("Location: admin-view.php");
        exit();
    } else {
        echo "Photo upload failed.";
    }
}
?>
