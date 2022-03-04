<?php
/**
 * Created by PhpStorm.
 * User: CesarJose39
 * Date: 22/10/2018
 * Time: 20:44
 */
?>
<!DOCTYPE html>
<html lang="es" >
<head>
    <meta charset="UTF-8">
    <title>¡ERROR! :c</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo _SERVER_;?>styles/error/css/style.css">
    <link rel="icon" href="<?php echo _SERVER_ . _ICON_;?>">
</head>

<body>

<main class="bsod container">
    <h1 class="neg title"><span class="bg">Lo sentimos, te hemos fallado :(</span></h1>
    <p>Ocurrió un error en el sitio web. Para continuar, puedes:</p>
    <p>* Volver al inicio.<br/>
        * Ponerte en contacto con el que hizo esto y decirle lo que pasó :(.<br/>
        * Reflexionar y esperar que se arregle solo (no golpees la pantalla, que eso no funciona).
    </p>
    <nav class="nav">
        <a href="<?php echo _SERVER_;?>" class="link">Inicio</a>&nbsp;|&nbsp;<a href="<?php echo _MYSITE_;?>" class="link" target="_blank">Ir a discutir con el equipo</a>
    </nav>
</main>


</body>

</html>