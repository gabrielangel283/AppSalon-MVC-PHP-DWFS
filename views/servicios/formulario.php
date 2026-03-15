<div class="campo">
    <label for="nombre">Nombre: </label>
    <input type="text"
        placeholder="El nombre del servicio"
        id="nombre"
        name="nombre"
        value="<?php echo s($servicio->nombre) ?? '' ?>">
</div>

<div class="campo">
    <label for="precio">Precio: </label>
    <input type="number"
        placeholder="El precio del servicio"
        id="precio"
        name="precio"
        value="<?php echo s($servicio->precio) ?? '' ?>">
</div>