<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/includes/functions.php';
requireLogin();

$productos = $pdo->query('SELECT COUNT(*) AS total FROM productos')->fetch();
$clientes = $pdo->query('SELECT COUNT(*) AS total FROM clientes')->fetch();
$ventas = $pdo->query('SELECT COUNT(*) AS total FROM ventas')->fetch();
$pedidos = $pdo->query('SELECT COUNT(*) AS total FROM pedidos')->fetch();
$ingresosHoy = $pdo->query("SELECT COALESCE(SUM(total), 0) AS total FROM ventas WHERE DATE(fecha_hora) = CURDATE()")->fetch();
$ventasRecientes = $pdo->query("SELECT v.*, u.nombre AS vendedor FROM ventas v LEFT JOIN usuarios u ON u.id = v.vendedor_id ORDER BY v.fecha_hora DESC LIMIT 5")->fetchAll();
$stockBajo = $pdo->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON c.id = p.categoria_id WHERE p.stock <= p.stock_minimo ORDER BY p.stock ASC LIMIT 5")->fetchAll();
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<div class="app-shell">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="page-header">
            <div>
                <span class="eyebrow">Panel general</span>
                <h1>Dashboard</h1>
            </div>
            <div class="page-tag">Bienvenido(a), <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></div>
        </div>

        <div class="stats-grid">
            <div class="stat-card accent">
                <div class="stat-icon"><i class="fa-solid fa-box-open"></i></div>
                <div>
                    <span>Productos</span>
                    <strong><?= (int)$productos['total'] ?></strong>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <span>Clientes</span>
                    <strong><?= (int)$clientes['total'] ?></strong>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-icon"><i class="fa-solid fa-cash-register"></i></div>
                <div>
                    <span>Ventas</span>
                    <strong><?= (int)$ventas['total'] ?></strong>
                </div>
            </div>
            <div class="stat-card info">
                <div class="stat-icon"><i class="fa-solid fa-truck-fast"></i></div>
                <div>
                    <span>Pedidos</span>
                    <strong><?= (int)$pedidos['total'] ?></strong>
                </div>
            </div>
        </div>

        <div class="content-grid two-columns">
            <div class="panel">
                <div class="panel-header">
                    <h3>Ingresos del día</h3>
                </div>
                <div class="total-amount"><?= formatMoney($ingresosHoy['total']) ?></div>
                <p class="muted">Resumen del total recaudado hoy en ventas registradas.</p>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Productos con stock bajo</h3>
                </div>
                <ul class="simple-list">
                    <?php foreach ($stockBajo as $item): ?>
                        <li>
                            <span><?= htmlspecialchars($item['nombre']) ?></span>
                            <strong><?= (int)$item['stock'] ?> unidades</strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3>Ventas recientes</h3>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Pago</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventasRecientes as $venta): ?>
                            <tr>
                                <td><?= htmlspecialchars($venta['codigo']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($venta['fecha_hora'])) ?></td>
                                <td><?= htmlspecialchars($venta['vendedor'] ?? 'Sin asignar') ?></td>
                                <td><?= htmlspecialchars($venta['metodo_pago']) ?></td>
                                <td><?= formatMoney($venta['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
