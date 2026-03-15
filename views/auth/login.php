<h1 class="nombre-pagina">Login</h1>

<p class="descripcion-pagina">Inicia sesion con tus datos</p>


<?php include_once __DIR__ . '/../templates/alertas.php' ?>


<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu contraseña" />
    </div>

    <input type="submit" class="boton" value="Inicial Sesion">
</form>

<hr>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?: Crea Una aqui</a>

    <a href="/olvide">¿Olvisdaste tu cuenta?</a>
</div>