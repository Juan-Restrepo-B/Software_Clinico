<?php
    ob_start();
     session_start();
    
    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
    header('location: ../login.php');

    $id=$_SESSION['id'];
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

    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="../../backend/css/datatable.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/buttonsdataTables.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/font.css">

    <title><?php echo htmlspecialchars($setting['nomem']); ?> | Listado de las citas</title>

</head>
<body>
    
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="escritorio.php" class="brand"><img src="../../backend/img/subidas/<?php echo htmlspecialchars($setting['foto']); ?>" alt="Logo Clinica"></a>
        <ul class="side-menu">
            <li><a href="../admin/escritorio.php" ><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
            <li class="divider" data-text="main">Main</li>
            <li>
                <a href="#" class="active"><i class='bx bxs-book-alt icon' ></i> Citas <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../citas/mostrar.php">Todas las citas</a></li>
                    <li><a href="../citas/nuevo.php">Nueva</a></li>
                    <li><a href="../citas/calendario.php">Calendario</a></li>
                   
                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-user icon' ></i> Pacientes <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../pacientes/mostrar.php" >Lista de pacientes</a></li>
                    <li><a href="../pacientes/pagos.php">Pagos</a></li>
                    <li><a href="../pacientes/historial.php">Historial de los pacientes</a></li>
                    <li><a href="../pacientes/documentos.php">Documentos</a></li>
                   
                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-briefcase icon' ></i> Médicos <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                    <li><a href="../medicos/historial.php">Historial de los médicos</a></li>
                   
                </ul>
            </li>



            <li>
                <a href="#"><i class='bx bxs-user-pin icon' ></i> Recursos humanos<i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../recursos/enfermera.php">Enfermera</a></li>
                    <li><a href="../recursos/laboratiorios.php">Laboratorios</a></li>
                    
                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-diamond icon' ></i> Actividades financieras<i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../actividades/mostrar.php">Pagos</a></li>
                    <li><a href="../actividades/nuevo.php">Nuevo pago</a></li>
                   
                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-spray-can icon' ></i> Medicina<i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../medicinas/venta.php">Vender</a></li>
                    <li><a href="../medicinas/mostrar.php">Listado</a></li>
                    <li><a href="../medicinas/nuevo.php">Nueva</a></li>
                    <li><a href="../medicinas/categoria.php">Categoria</a></li>

                </ul>
            </li>

            <li>
                <a href="#"><i class='bx bxs-cog icon' ></i> Ajustes<i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="../ajustes/mostrar.php">Ajustes</a></li>
                    <li><a href="../ajustes/idioma.php">Idioma</a></li>
                    <li><a href="../ajustes/base.php">Base de datos</a></li>
                    
                </ul>
            </li>

           <li><a href="../acerca/mostrar.php"><i class='bx bxs-info-circle icon' ></i> Acerca de</a></
          
           
        </ul>
       

    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu toggle-sidebar' ></i>
            <form action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search icon' ></i>
                </div>
            </form>
            
           
            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                <ul class="profile-link">
                   <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
                    
                    <li>
                     <a href="../salir.php"><i class='bx bxs-log-out-circle' ></i> Logout</a>
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
                <li><a href="#" class="active">Listado de las citas</a></li>
            </ul>
            <button class="button" onclick="location.href='nuevo.php'">Nuevo</button>
          <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Citas</h3>
                      

                    </div>
                   <div class="table-responsive" style="overflow-x:auto;">
                       <?php 
                            require '../../backend/bd/Conexion.php';
                                $sentencia = $connect->prepare("SELECT e.id, e.title, p.idpa, 
                                p.numhs, p.nompa, p.apepa, d.idodc, d.ceddoc, 
                                d.nodoc, d.apdoc, l.idlab, l.nomlab, e.start, 
                                e.end, e.color, e.state, e.chec, e.monto,
                                CONCAT(
                                    COALESCE(d.nodoc, ' '), ' ', 
                                    COALESCE(d.apdoc, ' '),
                                    COALESCE(n.nomnur, ' '), ' ', 
                                    COALESCE(n.apenur, ' ')
                                ) AS doctor
                                FROM events e
                                INNER JOIN docnur dn ON dn.iddocnur = e.iddocnur
                                INNER JOIN patients p ON e.idpa = p.idpa
                                LEFT JOIN doctor d ON dn.idodc = d.idodc 
                                LEFT JOIN nurse n ON dn.idnur = n.idnur
                                LEFT JOIN event_labs el ON el.event_id = e.ideve
                                LEFT JOIN laboratory l ON el.idlab = l.idlab
                                ORDER BY id DESC;");
                                $sentencia->execute();
                                $data =  array();
                            if($sentencia){
                            while($r = $sentencia->fetchObject()){
                                $data[] = $r;
                            }
                            }
                            
                            if(count($data)>0):
                        ?>
         <table id="example" class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Pacientes</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Médico</th>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Fecha inicio</th>
                    <th scope="col">Fecha fin</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $d):?>
                    <tr>
                        <th scope="row"><?php echo mb_convert_case(mb_strtolower($d->nompa, "UTF-8"), MB_CASE_TITLE, "UTF-8"); ?>&nbsp;<?php echo mb_convert_case(mb_strtolower($d->apepa, "UTF-8"), MB_CASE_TITLE, "UTF-8"); ?></th>
                        <td data-title="Cita"><?php echo mb_convert_case(mb_strtolower($d->title, "UTF-8"), MB_CASE_TITLE, "UTF-8"); ?></td>
                        <td data-title="Médico"><?php echo mb_convert_case(mb_strtolower($d->doctor, "UTF-8"), MB_CASE_TITLE, "UTF-8")?></td>
                        <td data-title="Laboratorio"><?php echo mb_convert_case(mb_strtolower($d->nomlab, "UTF-8"), MB_CASE_TITLE, "UTF-8"); ?></td>
                        <td data-title="Fecha inicio"><?php echo $d->start ?></td>
                        <td data-title="Fecha fin"><?php echo $d->end ?></td>
                       
                        
                        <td data-title="Estado">
    
                        <label class="switch">
                          <input type="checkbox" id="<?=$d->id?>" value="<?=$d->chec ?>" <?=$d->chec == '1' ? 'checked' : '' ;?>/> 

                          <span class="slider"></span>
                        </label>
                        </td>
                        <td>

                            

                <a title="Información" href="../citas/info.php?id=<?php echo $d->id ?>" class="fa fa-info"></a>
               
                
                <?php 
                                if ($d->chec == '0') {
                                    echo '<a title="Pago"  href="../citas/money.php?id='.$d->idpa.'" class="fa fa-money"></a>';
                                }else {
                                    echo '<a title="Boleta"  href="../citas/documento.php?id='.$d->id.'" class="fa fa-file-text-o"></a>';
                                    echo '<a title="Ticket"  href="../citas/ticket.php?id='.$d->id.'" class="fa fa-ticket"></a>';                  
                                }

                             ?>

                             
                          
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
         </table> 
         <?php else:?>
  
    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <strong>Danger!</strong> No hay datos.
    </div>
    <?php endif; ?>
                    </div>
                </div>
            </div>  

        </main>
        <!-- MAIN -->
    </section>
    
    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>
    
    <script src="../../backend/js/script.js"></script>
    
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
 
</body>
</html>


