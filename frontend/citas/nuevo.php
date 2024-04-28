<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
require_once('../../backend/bd/Conexion.php');

$settings = $connect->prepare("SELECT nomem, foto FROM settings");
$settings->execute();
$setting = $settings->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../backend/css/admin.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    
    <title><?php echo htmlspecialchars($setting['nomem']); ?> | Nueva Cita</title>

</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="../admin/escritorio.php" class="brand"><img src="../../backend/img/subidas/<?php echo htmlspecialchars($setting['foto']); ?>" alt="Logo Clinica"></a>

        <ul class="side-menu">
            <li><a href="../admin/escritorio.php"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
            <li class="divider" data-text="main">Main</li>
            <li>
                <a href="#" class="active"><i class='bx bxs-book-alt icon'></i> Citas <i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../citas/mostrar.php">Todas las citas</a></li>
                    <li><a href="../citas/nuevo.php">Nueva</a></li>
                    <li><a href="../citas/calendario.php">Calendario</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-user icon'></i> Pacientes <i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../pacientes/mostrar.php">Lista de pacientes</a></li>
                    <li><a href="../pacientes/pagos.php">Pagos</a></li>
                    <li><a href="../pacientes/historial.php">Historial de los pacientes</a></li>
                    <li><a href="../pacientes/documentos.php">Documentos</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-briefcase icon'></i> Médicos <i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>

                </ul>
            </li>




            <li>
                <a href="#"><i class='bx bxs-user-pin icon'></i> Recursos humanos<i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../recursos/enfermera.php">Enfermera</a></li>
                    <li><a href="../recursos/laboratiorios.php">Laboratorios</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-diamond icon'></i> Actividades financieras<i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../actividades/mostrar.php">Pagos</a></li>
                    <li><a href="../actividades/nuevo.php">Nuevo pago</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-spray-can icon'></i> Medicina<i
                        class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicinas/venta.php">Vender</a></li>
                    <li><a href="../medicinas/mostrar.php">Listado</a></li>
                    <li><a href="../medicinas/nuevo.php">Nueva</a></li>
                    <li><a href="../medicinas/categoria.php">Categoria</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-cog icon'></i> Ajustes<i class='bx bx-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="../ajustes/mostrar.php">Ajustes</a></li>
                    <li><a href="../ajustes/idioma.php">Idioma</a></li>
                    <li><a href="../ajustes/base.php">Base de datos</a></li>

                </ul>
            </li>

            <li><a href="../acerca/mostrar.php"><i class='bx bxs-info-circle icon'></i> Acerca de</a></ </ul>


    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">

        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu toggle-sidebar'></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon'></i>
                </div>
            </form>


            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                    alt="">
                <ul class="profile-link">
                    <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon'></i> Profile</a></li>

                    <li>
                        <a href="../salir.php"><i class='bx bxs-log-out-circle'></i> Logout</a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../citas/mostrar.php">Listado de las citas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nueva cita</a></li>
            </ul>

            <!-- multistep form -->


            <form action="../../backend/php/add_appointment.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                <div class="containerss">
                    <h1>Nueva cita</h1>

                    <div class="alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span
                            class="badge-warning">*</span><br>

                    </div>
                    <hr>
                    <br>
                    <label for="email"><b>Motivo de la cita</b></label><span class="badge-warning">*</span>
                    <textarea name="appnam" style="height:200px" placeholder="Write something.."> </textarea>

                    <label for="psw"><b>Nombre del paciente</b></label><span class="badge-warning">*</span>
                    <select required name="apppac" id="pati">
                        <option>Seleccione</option>
                    </select>

                    <label for="psw"><b>Nombre profesional</b></label><span class="badge-warning">*</span>
                    <select required id="doc" name="appdoc">
                        <option>Seleccione</option>
                    </select>

                    <label for="email"><b>Especialidad</b></label><span class="badge-warning">*</span>

                    <select disabled id="spe" name="appdoc">
                        <option>Seleccione</option>
                    </select>


                    <label for="psw"><b>Tipo Cita</b></label><span class="badge-warning">*</span>
                    <select id="lab" multiple>
                        <option>Seleccione</option>
                    </select>

                    <!-- Botones para mover opciones entre selectores -->
                    <button type="button" onclick="moveToSelected()">Agregar →</button>
                    <button type="button" onclick="moveToAvailable()">← Quitar</button>

                    <!-- Select para las opciones seleccionadas que se enviarán -->
                    <select required id="labs" name="applab[]" multiple onchange="updateTotal()">
                    </select>


                    <label for="psw"><b>Prioridad</b></label><span class="badge-warning">*</span>
                    <select required name="appco" id="gep">
                        <option style="color:#8B0000;" value="Alta">&#9724; Alta</option>
                        <option style="color:#FFFF00;" value="Media">&#9724; Media</option>
                        <option style="color:#FFB6C1;" value="Baja">&#9724; Baja</option>


                    </select>

                    <label for="email"><b>Fecha inicial</b></label><span class="badge-warning">*</span>
                    <input type="datetime-local" name="appini" required="">

                    <label for="email"><b>Fecha final</b></label><span class="badge-warning">*</span>
                    <input type="datetime-local" name="appfin" required="">

                    <label for="email"><b>Monto a pagar</b></label><span class="badge-warning">*</span>
                    <div id="total">Total: $0.0</div>
                    <input type="hidden" id="appmont" name="appmont" value="0.0">

                    <br><br>
                    <label for="email"><b>Realiza pago</b></label><span class="badge-warning">*</span>
                    <label>SI</label>
                    <input type="checkbox" name="appreal" value="1">


                    <hr>

                    <button type="submit" name="add_appointment" class="registerbtn">Guardar</button>

                </div>

            </form>

        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>


    <!-- NAVBAR -->

    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
    <script src="../../backend/js/patiens.js"></script>
    <script src="../../backend/js/doctor.js"></script>
    <script src="../../backend/js/laboratory.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
    function moveToSelected() {
        var available = document.getElementById('lab');
        var selected = document.getElementById('labs');
        var selectedOptions = Array.from(available.selectedOptions);
        
        selectedOptions.forEach(option => {
            selected.appendChild(option);  // Moves the option to the selected list
            option.selected = true;  // Ensure the option is selected for form submission
        });

        updateTotal();  // Update the total whenever an option is moved
    }

        function moveToAvailable() {
            var available = document.getElementById('lab');
            var selected = document.getElementById('labs');
            var selectedOptions = Array.from(selected.selectedOptions);

            selectedOptions.forEach(option => {
                available.appendChild(option);  // Moves the option back to the available list
                option.selected = false;  // Ensure the option is deselected
            });

            updateTotal();  // Update the total whenever an option is moved
        }

        $(document).ready(function() {
            $('#labs').change(updateTotal);  // Update the total when the selection changes
        });

        function updateTotal() {
            var selectedIds = $('#labs').val();

            if (selectedIds && selectedIds.length > 0) {
                $.post('../../frontend/funciones/monto.php', { continente: selectedIds }, function(response) {
                    $('#total').text('Total: $' + response);
                    $('#appmont').val(response);  // Update the hidden input field as well
                }).fail(function(xhr) {
                    console.error("Error: " + xhr.responseText);
                    alert("Error al procesar la solicitud.");
                });
            } else {
                $('#total').text('Total: $0.0');
                $('#appmont').val('0.0');  // Update the hidden input field as well
            }
        }
    </script>

    <?php include_once '../../backend/php/add_appointment.php' ?>

</body>

</html>