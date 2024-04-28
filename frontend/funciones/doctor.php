<?php
require '../../backend/bd/Conexion.php';
echo '<option value="0">Seleccione</option>';
$stmt = $connect->prepare('
SELECT 
d.iddocnur AS Id,
CONCAT(COALESCE(dc.nodoc, ""), " ", COALESCE(dc.apdoc, ""), COALESCE(n.nomnur, ""), " ", COALESCE(n.apenur, "")) AS nombre_completo
FROM 
docnur d 
LEFT JOIN 
doctor dc ON dc.idodc = d.idodc
LEFT JOIN 
nurse n ON n.idnur = d.idnur
ORDER BY 
dc.idodc ASC
');

$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <option name="appdoc" value="<?php echo htmlspecialchars($row['Id']); ?>"><?php echo htmlspecialchars($row['nombre_completo']); ?>
    </option>
    <?php
}
?>