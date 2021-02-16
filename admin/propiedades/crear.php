<?php
// base de datos
require "../../includes/config/database.php";
$db = conectarDB();

// arreglo con mensaje de errores
$errores = [];

// ejecutar el codigo despues de que el usuario envia  el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    /* echo "<pre>";
    var_dump($_POST);
    echo "</pre>"; */

    $titulo = $_POST["titulo"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $habitaciones = $_POST["habitaciones"];
    $wc = $_POST["wc"];
    $estacionamiento = $_POST["estacionamiento"];
    $vendedorId = $_POST["vendedor"];

    if(!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if(!$precio) {
        $errores[] = "el precio es Obligatorio";
    }
    if( strlen($descripcion) < 50) {
        $errores[] = "la descripcion es obligatoria y debe contener al menos 50 caracteres";
    }
    if(!$habitaciones) {
        $errores[] = "el numero de habitaciones es obligatorio";
    }
    if(!$wc) {
        $errores[] = "el numero de baños es obligatorio";
    }
    if(!$estacionamiento) {
        $errores[] = "el numero de estacionamiento es obligatorio";
    }
    if(!$vendedorId) {
        $errores[] = "el obligatorio escoger el vendedor con el que realizo la cotizacion";
    }

    // revisar que  el array de errores este vacio
    if(empty($errores)) {

        // Insertar en la base de datos
        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedorId) VALUES
        ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedorId')";
        
         echo $query;
    
        $resultado = mysqli_query($db, $query); // enviando a la base de datos
    
        if($resultado) {
            echo "Insertado correctamente";
        } else {
            echo "algo anda mal";
        }
    }

}

require "../../includes/funciones.php";
inclirTemplate("header");
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde"> Volver</a>

    <?php foreach($errores as $error): ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>

    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" placeholder="Titulo Propiedad" name="titulo">

            <label for="precio">Precio</label>
            <input type="number" id="precio" placeholder="Precio Propiedad" name="precio">

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/png, image/jpeg">

            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion"></textarea>

        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej:3" min="1" max="9">

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej:3" min="1" max="9">

            <label for="estacionamiento">Estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej:3" min="1" max="9">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="">
                <option value="" disabled selected >--Seleccione--</option>
                <option value="1">Jonathan</option>
                <option value="2">Diana</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php inclirTemplate("footer"); ?>