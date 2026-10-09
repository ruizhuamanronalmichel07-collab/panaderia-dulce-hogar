<?php
function requireLogin(): void
{
    if (empty($_SESSION['usuario'])) {
        header('Location: /panaderia-dulce-hogar/login.php');
        exit;
    }
}

function requireRole(array $roles): void
{
    requireLogin();

    if (!in_array($_SESSION['usuario']['rol'], $roles, true)) {
        $_SESSION['error_permiso'] = 'No tienes permisos para acceder a esta sección.';
        header('Location: /panaderia-dulce-hogar/dashboard.php');
        exit;
    }
}

function formatMoney(float $amount): string
{
    return 'S/ ' . number_format($amount, 2, '.', ',');
}

function getUserName(): string
{
    return $_SESSION['usuario']['nombre'] ?? 'Usuario';
}
