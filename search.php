<?php
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $city = isset($_GET['city']) ? $conn->real_escape_string($_GET['city']) : '';
    $area = isset($_GET['area']) ? $conn->real_escape_string($_GET['area']) : '';
    $service = isset($_GET['service']) ? $conn->real_escape_string($_GET['service']) : '';
    
    $where = [];
    if ($city) $where[] = "city = '$city'";
    if ($area) $where[] = "area = '$area'";
    if ($service) $where[] = "FIND_IN_SET('$service', services) > 0";
    
    $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
    
    $sql = "SELECT * FROM maids $whereClause ORDER BY rating DESC";
    $result = $conn->query($sql);
    
    $maids = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $maids[] = $row;
        }
    }
    
    echo json_encode([
        "success" => true,
        "data" => $maids
    ]);
}

$conn->close();
?>