<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/includes/functions.php';

$productos = $pdo->query("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON c.id = p.categoria_id WHERE p.estado = 'Activo' ORDER BY p.fecha_registro DESC LIMIT 6")->fetchAll();
$categorias = $pdo->query("SELECT * FROM categorias WHERE estado = 'Activo' ORDER BY nombre ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería Dulce Hogar</title>
    <meta name="description" content="Panadería Dulce Hogar - productos frescos, panes, pasteles, postres y pedidos a domicilio.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="landing-page">
    <header class="topbar">
        <div class="container navbar">
            <div class="brand">
                <div class="brand-mark">DH</div>
                <div>
                    <strong>Panadería Dulce Hogar</strong>
                    <span>Horneado con tradición</span>
                </div>
            </div>
            <nav class="main-nav">
                <a href="#inicio">Inicio</a>
                <a href="#productos">Productos</a>
                <a href="#promociones">Promociones</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#contacto">Contacto</a>
            </nav>
            <div class="nav-actions">
                <a href="login.php" class="btn btn-outline">Iniciar sesión</a>
            </div>
        </div>
    </header>

    <main>
        <section id="inicio" class="hero">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                <div class="hero-copy">
                    <span class="badge">Pan recién horneado</span>
                    <h1>Delicias caseras para cada momento.</h1>
                    <p>
                        Descubre panes, tortas, galletas, empanadas y postres hechos con ingredientes de calidad y cariño.
                    </p>
                    <div class="hero-actions">
                        <a href="#productos" class="btn btn-primary">Ver productos</a>
                        <a href="login.php" class="btn btn-secondary">Administrar</a>
                    </div>
                    <ul class="hero-stats">
                        <li><strong>15k+</strong><span>Clientes felices</span></li>
                        <li><strong>120+</strong><span>Productos frescos</span></li>
                        <li><strong>8am-9pm</strong><span>Atención diaria</span></li>
                    </ul>
                </div>
                <div class="hero-panel">
                    <div class="mini-card card-1">
                        <i class="fa-solid fa-bread-slice"></i>
                        <span>Pan artesanal</span>
                    </div>
                    <div class="mini-card card-2">
                        <i class="fa-solid fa-cake-candles"></i>
                        <span>Pasteles</span>
                    </div>
                    <div class="mini-card card-3">
                        <i class="fa-solid fa-mug-hot"></i>
                        <span>Bebidas</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="search-section">
            <div class="container search-box">
                <div class="search-label">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Buscar productos</span>
                </div>
                <input type="text" id="productSearch" placeholder="Busca pan, torta, galleta, empanada o postre...">
            </div>
        </section>

        <section class="categories-section">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Categorías</span>
                    <h2>Lo más pedido</h2>
                </div>
                <div class="category-grid">
                    <?php foreach ($categorias as $categoria): ?>
                        <div class="category-item">
                            <div class="icon-circle">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                            <h3><?= htmlspecialchars($categoria['nombre']) ?></h3>
                            <p><?= htmlspecialchars($categoria['descripcion'] ?? 'Productos frescos y deliciosos.') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="productos" class="products-section">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Nuestra selección</span>
                    <h2>Productos destacados</h2>
                </div>
                <div class="product-grid" id="productGrid">
                    <?php foreach ($productos as $producto): ?>
                        <article class="product-card" data-name="<?= strtolower(htmlspecialchars($producto['nombre'])) ?>" data-code="<?= strtolower(htmlspecialchars($producto['codigo'])) ?>">
                            <div class="product-thumb" style="background-image: url('<?= !empty($producto['imagen']) ? htmlspecialchars($producto['imagen']) : 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80' ?>');"></div>
                            <div class="product-body">
                                <span class="product-tag"><?= htmlspecialchars($producto['categoria'] ?? 'General') ?></span>
                                <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                                <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                                <div class="product-meta">
                                    <strong><?= formatMoney($producto['precio_venta']) ?></strong>
                                    <span>Stock: <?= (int)$producto['stock'] ?></span>
                                </div>
                                <button class="btn btn-primary full-width">Agregar al carrito</button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="promociones" class="promo-section">
            <div class="container">
                <div class="promo-banner">
                    <div>
                        <span class="eyebrow light">Promoción</span>
                        <h2>Combo familiar</h2>
                        <p>Obtén un descuento del 15% en panes + torta para compartir este fin de semana.</p>
                    </div>
                    <a href="login.php" class="btn btn-light">Reservar</a>
                </div>
            </div>
        </section>

        <section id="nosotros" class="about-section">
            <div class="container about-grid">
                <div class="about-image"></div>
                <div class="about-content">
                    <span class="eyebrow">Sobre nosotros</span>
                    <h2>Tradición, sabor y calidad en cada elaboración.</h2>
                    <p>
                        En Panadería Dulce Hogar horneamos con recetas caseras, materia prima seleccionada y dedicación en cada preparación. Somos tu mejor opción para desayunos, reuniones familiares y momentos especiales.
                    </p>
                    <div class="info-list">
                        <div>
                            <i class="fa-solid fa-check"></i>
                            <span>Ingredientes frescos y seleccionados.</span>
                        </div>
                        <div>
                            <i class="fa-solid fa-check"></i>
                            <span>Atención rápida y servicio confiable.</span>
                        </div>
                        <div>
                            <i class="fa-solid fa-check"></i>
                            <span>Pedidos para recoger y entrega a domicilio.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-section" id="contacto">
            <div class="container contact-grid">
                <div class="info-card">
                    <span class="eyebrow">Horario</span>
                    <h3>Atención</h3>
                    <ul>
                        <li><strong>Lunes a Viernes:</strong> 7:00 AM - 9:00 PM</li>
                        <li><strong>Sábado:</strong> 8:00 AM - 9:00 PM</li>
                        <li><strong>Domingo:</strong> 8:00 AM - 2:00 PM</li>
                    </ul>
                </div>
                <div class="info-card">
                    <span class="eyebrow">Ubicación</span>
                    <h3>Encuéntranos</h3>
                    <p>Av. Los Olivos 245, Urb. San Martín, Lima.</p>
                    <p>Teléfono: +51 987 654 321</p>
                    <p>Correo: contacto@dulcehogar.pe</p>
                </div>
            </div>
        </section>
    </main>

    <a href="https://wa.me/51987654321" class="whatsapp-float" target="_blank" rel="noopener">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <h4>Panadería Dulce Hogar</h4>
                <p>Horneando momentos especiales con tradición y sabor.</p>
            </div>
            <div>
                <h5>Enlaces</h5>
                <ul>
                    <li><a href="#productos">Productos</a></li>
                    <li><a href="#promociones">Promociones</a></li>
                    <li><a href="login.php">Acceso administrativo</a></li>
                </ul>
            </div>
            <div>
                <h5>Contacto</h5>
                <ul>
                    <li>+51 987 654 321</li>
                    <li>contacto@dulcehogar.pe</li>
                    <li>Av. Los Olivos 245</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                © <?= date('Y') ?> Panadería Dulce Hogar. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="js/app.js"></script>
</body>
</html>
