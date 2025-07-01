<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// Obtener estadísticas
$resultClientes = mysqli_query($conexion, "SELECT COUNT(*) as total FROM clientes");
$totalClientes = mysqli_fetch_assoc($resultClientes)['total'];

$resultSeguimientos = mysqli_query($conexion, "SELECT COUNT(*) as total FROM seguimientos");
$totalSeguimientos = mysqli_fetch_assoc($resultSeguimientos)['total'];

$resultUrgentes = mysqli_query($conexion, "SELECT COUNT(*) as total FROM clientes WHERE estatus_color = '#FF0000'");
$totalUrgentes = mysqli_fetch_assoc($resultUrgentes)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Principal | CRM</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            color: #333;
        }
        .sidebar {
            width: 240px;
            background-color: #1f2937;
            color: #f9fafb;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #374151;
            padding-bottom: 20px;
        }
        .sidebar .logo img {
            height: 48px;
            margin-right: 12px;
            border-radius: 6px;
            object-fit: cover;
        }
        .sidebar .logo-text {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            user-select: none;
        }
        .sidebar nav {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .sidebar nav a {
            color: #d1d5db;
            text-decoration: none;
            padding: 14px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar nav a:hover, .sidebar nav a.active {
            background-color: #3b82f6;
            color: #fff;
        }
        .sidebar .user-info {
            border-top: 1px solid #374151;
            padding-top: 20px;
            font-size: 15px;
            line-height: 1.4;
        }
        .sidebar .user-info strong {
            display: block;
            margin-bottom: 4px;
            color: #9ca3af;
        }
        .button-logout {
            margin-top: 15px;
            background-color: #ef4444;
            border: none;
            color: white;
            padding: 12px 0;
            width: 100%;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-logout:hover {
            background-color: #b91c1c;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px 50px;
            width: calc(100% - 240px);
            overflow-y: auto;
            background: #fff;
            box-shadow: inset 0 0 20px #e2e8f0;
        }
        h2 {
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 25px;
            color: #111827;
        }
        .stats-container {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
        }
        .card {
            flex: 1;
            background: #e0e7ff;
            border-radius: 12px;
            padding: 30px 25px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #1e3a8a;
            font-weight: 700;
            font-size: 32px;
            user-select: none;
            transition: transform 0.3s ease;
        }
        .card.urgente {
            background: #fee2e2;
            color: #b91c1c;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
        }
        .card .label {
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
            color: #374151;
            user-select: text;
        }
        .buttons-container {
            display: flex;
            gap: 20px;
        }
        .button {
            background-color: #2563eb;
            color: white;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.4);
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            user-select: none;
        }
        .button:hover {
            background-color: #1d4ed8;
            box-shadow: 0 6px 15px rgba(29, 78, 216, 0.6);
        }

        @media (max-width: 900px) {
            .main-content {
                padding: 30px 20px;
            }
            .stats-container {
                flex-direction: column;
            }
            .buttons-container {
                flex-direction: column;
            }
            .button {
                justify-content: center;
                width: 100%;
                padding: 14px 0;
            }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 15px;
                box-shadow: none;
            }
            .sidebar nav {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 10px;
                padding: 0;
                margin-left: 20px;
            }
            .sidebar nav a {
                margin: 0;
                padding: 10px 15px;
                font-size: 14px;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="img/consultoria.png.jpg" alt="Logo de la empresa" />
            <div class="logo-text">CRM</div>
        </div>
        <nav>
            <a href="dashboard.php" class="active">🏠 Dashboard</a>
            <a href="clientes.php">📋 Clientes</a>
            <a href="seguimientos.php">📝 Seguimientos</a>
            <a href="llamadas_urgentes.php">☎️ Llamadas Urgentes</a>
            <a href="inscripciones.php">🎓 Inscritos a Cursos</a>
            <a href="cambiar_contrasena.php">🔒 Cambiar Contraseña</a>

            <?php if ($rol === 'admin'): ?>
                <a href="backup.php" onclick="return confirm('¿Deseas generar un respaldo ahora?')">🛡️ Generar Respaldo</a>
                <a href="subir_excel.php">📤 Subir Documentos Excel</a>
                <a href="descargar.php">⬇️ Descargar Datos</a>
            <?php endif; ?>
        </nav>
        <div class="user-info">
            <strong>Usuario</strong> <?php echo htmlspecialchars($usuario); ?><br>
            <strong>Rol</strong> <?php echo htmlspecialchars($rol); ?>
            <form action="logout.php" method="post" style="margin-top: 15px;">
                <button type="submit" class="button-logout">Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?> 👋</h2>

        <div class="stats-container">
            <div class="card">
                📊 <?php echo $totalClientes; ?>
                <div class="label">Total de Clientes</div>
            </div>
            <div class="card">
                📝 <?php echo $totalSeguimientos; ?>
                <div class="label">Total de Seguimientos</div>
            </div>
            <div class="card urgente">
                🔴 <?php echo $totalUrgentes; ?>
                <div class="label">Llamadas Urgentes</div>
            </div>
        </div>

        <!-- ... lo demás queda igual ... -->

        <div class="buttons-container">
            <a href="clientes.php" class="button">📋 Ver Clientes</a>
            <a href="llamadas_urgentes.php" class="button">☎️ Llamadas Urgentes</a>
            <a href="ver_documentos.php" class="boton-excel">📁 Ver Historial de Excel</a>
        </div>

        <style>
            .boton-excel {
                display: inline-block;
                background: linear-gradient(135deg, #007bff, #0056b3);
                color: white;
                padding: 14px 28px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
                font-size: 16px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                transition: background 0.3s ease, transform 0.2s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .boton-excel:hover {
                background: linear-gradient(135deg, #0056b3, #003f88);
                transform: translateY(-2px);
            }
        </style>

<!-- ... lo demás sigue igual ... -->


    </main>
</body>
</html>
