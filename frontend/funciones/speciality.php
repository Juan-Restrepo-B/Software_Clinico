<?php 
require '../../backend/bd/Conexion.php'; 
$el_continente = $_POST['continente'];

// Usar consultas preparadas para evitar inyecciones SQL
$stmt = $connect->prepare('
    SELECT
    d.iddocnur AS Id,
        CONCAT(COALESCE(dc.nomesp, ""), COALESCE(d.spec, "")) AS Especialidad
    FROM docnur d 
        LEFT JOIN 
            doctor dc ON dc.idodc = d.idodc
        LEFT JOIN 
            nurse n ON n.idnur = d.idnur
    WHERE d.iddocnur = :continente
');

// Vincular el parámetro de manera segura
$stmt->bindParam(':continente', $el_continente);

// Ejecutar la consulta
$stmt->execute();

// Procesar los resultados
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<option name="appdoc" value="' . htmlspecialchars($row['Id']) . '">' . htmlspecialchars($row['Especialidad']) . '</option>' . "\n";
}
?>