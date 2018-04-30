<?php
require_once("php/Fabrica.php");
require_once("php/Empleado.php");

$extension = pathinfo($_FILES['foto']['name']);

if ($extension['extension'] != 'jpg' && $extension['extension'] != 'png' && $extension['extension'] != 'jpeg' && $extension['extension'] != 'gif' && $extension['extension'] != 'bmp' && $extension['size'] > 1024) {
    echo "Error";
} else {
    if (isset($_POST['nombre'])) {
        $fabrica = new Fabrica("La de vivir", 7);
        $fabrica->TraerDeArchivo();
        if (isset($_POST['hdnModificar'])) {
            $empleados = $fabrica->GetEmpleados();
            foreach ($empleados as $emp) {
                if ($_POST['dni'] == $emp->GetDni()) {
                    if (!$fabrica->EliminarEmpleado($emp)) {

                        echo "No se pudo eliminar el empleado recibido por MODIFICAR EMP PHP";
                    }
                    break;
                }
            }
        }
        $pathArchivo = "./fotos/" . $_POST['dni'] . "-" . $_POST['apellido'] . "." . $extension['extension'];
        $empleadoForm = new Empleado($_POST['nombre'], $_POST['apellido'], $_POST['dni'], $_POST['genero'], $_POST['legajo'], $_POST['sueldo'], $_POST['turnos']);
        $empleadoForm->SetPathFoto(trim($pathArchivo));

        if ($fabrica->AgregarEmpleado($empleadoForm)) {
            move_uploaded_file($_FILES['foto']['tmp_name'], $pathArchivo);
            $fabrica->GuardarEnArchivo();
            echo "Empleado guardado perfectamente " ?>
             </br><a href="login.html">Login</a>
              <?php

            } else {
                echo "No pudo Agregarse a la fabrica";
            }
        }

    }



    ?>

</br><a href="index.html">Volver</a>