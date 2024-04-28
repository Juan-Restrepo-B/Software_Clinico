<?php
require_once ('../../backend/bd/Conexion.php');

if (isset($_POST['add_appointment'])) {
    $title = trim($_POST['appnam']);
    $idpa = trim($_POST['apppac']);
    $idodc = trim($_POST['appdoc']);
    $color = trim($_POST['appco']);
    $start = $_POST['appini'];
    $end = $_POST['appfin'];
    $monto = $_POST['appmont'];
    $chec = isset($_POST['appreal']) ? 1 : 0;

    try {
        // Insertar el evento principal
        $stmt = $connect->prepare("INSERT INTO events (title, idpa, iddocnur, color, start, end, state, monto, chec) VALUES (:title, :idpa, :idodc, :color, :start, :end, 1, :monto, :chec)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':idpa', $idpa);
        $stmt->bindParam(':idodc', $idodc);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':chec', $chec);
        $stmt->execute();
        $event_id = $connect->lastInsertId();

        // Insertar las relaciones de laboratorio si existen
        if (!empty($_POST['applab'])) {
            foreach ($_POST['applab'] as $lab_id) {
                $lab_id = trim($lab_id);
                $stmtLab = $connect->prepare("INSERT INTO event_labs (event_id, idlab) VALUES (:event_id, :lab_id)");
                $stmtLab->bindParam(':event_id', $event_id);
                $stmtLab->bindParam(':lab_id', $lab_id);
                $stmtLab->execute();
            }
        }

        // Consulta del ultimo ID de los Events
        $stmtTemp = $connect->prepare("SELECT MAX(id) as max_id FROM events");
        $stmtTemp->execute();
        $result = $stmtTemp->fetch(PDO::FETCH_ASSOC);
        if ($result && isset($result['max_id'])) {
            $idevent = $result['max_id'];
        } else {
            $idevent = null;
        }

        // Actualizar el evento con alguna información adicional post-insert
        $updateStmt = $connect->prepare("UPDATE events SET ideve = :event_id WHERE id = :id");
        $updateStmt->bindParam(':id', $idevent);
        $updateStmt->bindParam(':event_id', $event_id);
        $updateStmt->execute();

        echo '<script type="text/javascript">
            swal("¡Registrado!", "Se reservó la cita correctamente", "success").then(function() {
                window.location = "../citas/calendario.php";
            });
            </script>';
    } catch (PDOException $e) {
        echo '<script type="text/javascript">
            swal("Error!", "No se pueden agregar datos: ' . $e->getMessage() . '", "error").then(function() {
                window.location = "nuevo.php";
            });
            </script>';
    }
}
?>