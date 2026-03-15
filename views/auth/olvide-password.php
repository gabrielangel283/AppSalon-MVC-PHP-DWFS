<h1 class="nombre-pagina">¡Olvide mi contraseña!</h1>

<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuacion</p>


<?php include_once __DIR__ . '/../templates/alertas.php' ?>


<form action="/olvide" method="POST" class="formulario">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu correo para identificarte">
    </div>

    <input type="submit" class="boton" value="Enviar mensaje">

</form>

<hr>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta?: Inicia sesion</a>

    <a href="/crear-cuenta">¿No tiens cuenta aún?: Registrate</a>
</div>