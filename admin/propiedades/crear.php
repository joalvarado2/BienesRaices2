<?php
// base de datos
require "../../includes/config/database.php";
$db = conectarDB();

// consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// arreglo con mensaje de errores
$errores = [];

$titulo = "";
$precio = "";
$descripcion = "";
$habitaciones = "";
$wc = "";
$estacionamiento = "";
$vendedorId = "";

// ejecutar el codigo despues de que el usuario envia  el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    //mysqli_real_escape_string() --> sataniza el codigo es decir limpia lo que escribe el usuario y no sirve
    $titulo = mysqli_real_escape_string( $db, $_POST["titulo"]);
    $precio = mysqli_real_escape_string( $db, $_POST["precio"]);
    $descripcion = mysqli_real_escape_string( $db, $_POST["descripcion"]);
    $habitaciones = mysqli_real_escape_string( $db, $_POST["habitaciones"]);
    $wc = mysqli_real_escape_string( $db, $_POST["wc"]);
    $estacionamiento = mysqli_real_escape_string( $db, $_POST["estacionamiento"]);
    $vendedorId = mysqli_real_escape_string( $db, $_POST["vendedor"]);
    $creado =  date("Y/m/d");

    // asignar files hacia una variable
    $imagen = $_FILES["imagen"];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if (!$precio) {
        $errores[] = "el precio es Obligatorio";
    }
    if (strlen($descripcion) < 50) {
        $errores[] = "la descripcion es obligatoria y debe contener al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "el numero de habitaciones es obligatorio";
    }
    if (!$wc) {
        $errores[] = "el numero de baños es obligatorio";
    }
    if (!$estacionamiento) {
        $errores[] = "el numero de estacionamiento es obligatorio";
    }
    if (!$vendedorId) {
        $errores[] = "el obligatorio escoger el vendedor con el que realizo la cotizacion";
    }
    if (!$imagen["name"] || $imagen["error"]) {
        $errores[] = "la imagen es obligatoria";
    }

    // validar por tamaño (100 kb maximo)
    $medida = 1000 * 100;

    if($imagen["size"] > $medida) {
        $errores[] = "la imagen es muy pesada supera 100 kb";
    }

    // revisar que  el array de errores este vacio
    if (empty($errores)) {

        // Insertar en la base de datos
        $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) VALUES
        ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

        echo $query;

        $resultado = mysqli_query($db, $query); // enviando a la base de datos

        if ($resultado) {
            // redireccionando usuario
            header("Location: /admin");
        }
    }
}

require "../../includes/funciones.php";
inclirTemplate("header");
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde"> Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" placeholder="Titulo Propiedad" name="titulo" value="<?php echo $titulo; ?>">

            <label for="precio">Precio</label>
            <input type="number" id="precio" placeholder="Precio Propiedad" name="precio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" accept="image/png, image/jpeg" name="imagen">

            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion"> <?php echo $descripcion; ?> </textarea>

        </fieldset>

        <fieldset>
            <legend>Informacion Propiedad</legend>

            <label for="habitaciones">Habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej:3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej:3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej:3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="">
                <option value="" disabled selected>--Seleccione--</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedorId === $vendedor["id"] ? "selected" : ""; ?> value="<?php echo $vendedor['id']; ?>">
                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php inclirTemplate("footer"); ?>