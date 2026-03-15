<h1 class="nombre-pagina">Recuperar contraseña</h1>

<p class="descripcion-pagina">Escribe tu nueva contraseña para tu cuenta</p>


<?php include_once __DIR__ . '/../templates/alertas.php' ?>


<?php if ($error) return; ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Nueva contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu nueva contraseña" />
    </div>

    <input type="submit" class="boton" value="Cambiar contraseña">

</form>


<div class="acciones">
    <a href="/">¿Recordaste tu contraseña?: Logeate!!</a>
</div>