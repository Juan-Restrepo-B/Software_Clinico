<?php
require '../../backend/bd/Conexion.php';
$continentes = $_POST['continente'] ?? [];

if (!empty($continentes)) {
    $placeholders = implode(',', array_fill(0, count($continentes), '?'));

    $stmt = $connect->prepare("SELECT SUM(l.precio) AS TOTAL FROM laboratory l WHERE l.idlab IN ($placeholders)");
    foreach ($continentes as $index => $id) {
        $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row && $row['TOTAL'] !== null ? $row['TOTAL'] : "0.0";
    } else {
        echo "0.0";
    }
} else {
    echo "0.0";
}
?>
