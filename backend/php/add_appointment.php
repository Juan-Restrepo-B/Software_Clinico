<?php
require_once('../../backend/bd/Conexion.php');

if (isset($_POST['add_appointment'])) {
    $title = trim($_POST['appnam']);
    $idpa = trim($_POST['apppac']);
    $idodc = trim($_POST['appdoc']); // Assuming this is supposed to be `iddocnur`
    $color = trim($_POST['appco']);
    $start = $_POST['appini'];
    $end = $_POST['appfin'];
    $monto = $_POST['appmont'];
    $chec = isset($_POST['appreal']) ? 1 : 0;

    // Validate the existence of iddocnur in docnur table
    $checkDoc = $connect->prepare("SELECT iddocnur FROM docnur WHERE iddocnur = :idodc");
    $checkDoc->bindParam(':idodc', $idodc);
    $checkDoc->execute();
    if ($checkDoc->rowCount() == 0) {
        echo '<script type="text/javascript">
            swal("Error!", "Doctor/Nurse ID provided does not exist.", "error").then(function() {
                window.location = "nuevo.php";
            });
            </script>';
        exit;
    }

    // Proceed with insertion if the foreign key exists
    try {
        $stmt = $connect->prepare("INSERT INTO events 
        (title, idpa, iddocnur, color, start, end, state, monto, chec) 
        VALUES (:title, :idpa, :idodc, :color, :start, :end, 1, :monto, :chec)");
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

        if (!empty($_POST['applab'])) {
            foreach ($_POST['applab'] as $lab_id) {
                $lab_id = trim($lab_id);
                $stmtLab = $connect->prepare("INSERT INTO event_labs (event_id, lab_id) VALUES (:event_id, :lab_id)");
                $stmtLab->bindParam(':event_id', $event_id);
                $stmtLab->bindParam(':lab_id', $lab_id);
                $stmtLab->execute();
            }
        }
        header('Location: ../../frontend/citas/nuevo.php');

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
