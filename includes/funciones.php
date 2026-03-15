<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    if ($html == null) {
        return "";
    }

    $s = htmlspecialchars($html);
    return $s;
}

// funcion par avalidar autenticacion
function isAuth(): void
{

    if (!isset($_SESSION['login'])) {
        header('Location: /');
        exit;
    }
}

function isAdmin(): void
{
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}

function esUltimo(string $actual, string $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}
