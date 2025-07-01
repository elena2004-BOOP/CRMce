<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Inscripción</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            color: #253a5e;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(37, 58, 94, 0.2);
        }
        h1, h3 {
            border-bottom: 2px solid #253a5e;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }
        input[type="submit"], .button-link {
            background-color: #253a5e;
            color: white;
            padding: 10px 20px;
            border: none;
            margin-top: 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
        }
        input[type="submit"]:hover, .button-link:hover {
            background-color: #1a2d4a;
        }
    </style>
    <script>
        function calcular() {
            let n = parseInt(document.getElementById('numero_participantes').value) || 0;
            let p = parseFloat(document.getElementById('precio_unitario').value) || 0;
            let subtotal = n * p;
            let iva = subtotal * 0.16;
            let total = subtotal + iva;

            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('iva').value = iva.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Ficha de Inscripción</h1>
    <form action="guardarf.php" method="POST">

        <label>Fecha de Inscripción:
            <input type="date" name="fecha_inscripcion" value="<?= date('Y-m-d') ?>" required>
        </label>

        <label>Consultor:
            <input type="text" name="consultor" required>
        </label>

        <label>Curso:
            <input type="text" name="curso" required>
        </label>

        <label>Participantes:
            <textarea name="participantes" rows="4" required></textarea>
        </label>

        <h3>Datos de Facturación</h3>
        <label>Razón Social: <input type="text" name="razon_social"></label>
        <label>Calle y Número: <input type="text" name="calle_numero"></label>
        <label>Colonia y C.P.: <input type="text" name="colonia_cp"></label>
        <label>Ciudad, Estado: <input type="text" name="ciudad_estado"></label>
        <label>RFC: <input type="text" name="rfc"></label>
        <label>Teléfono: <input type="text" name="telefono"></label>
        <label>Régimen: <input type="text" name="regimen"></label>
        <label>Método de Pago: <input type="text" name="metodo_pago"></label>
        <label>Forma de Pago: <input type="text" name="forma_pago"></label>
        <label>Uso de CFDI: <input type="text" name="uso_cfdi"></label>
        <label>Orden de Compra: <input type="text" name="orden_compra"></label>
        <label>Correo: <input type="email" name="correo"></label>

        <h3>Costos</h3>
        <label>No. Participantes:
            <input type="number" name="numero_participantes" id="numero_participantes" oninput="calcular()">
        </label>
        <label>Precio Unitario:
            <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" oninput="calcular()">
        </label>
        <label>Subtotal:
            <input type="number" name="subtotal" id="subtotal" readonly>
        </label>
        <label>IVA:
            <input type="number" name="iva" id="iva" readonly>
        </label>
        <label>Total:
            <input type="number" name="total" id="total" readonly>
        </label>

        <h3>Evento</h3>
        <label>Condiciones de Pago:
            <input type="text" name="condiciones_pago" value="TRÁMITE">
        </label>
        <label>Sede:
            <input type="text" name="sede" value="TEAMS">
        </label>
        <label>Fecha del evento:
            <input type="date" name="fecha">
        </label>
        <label>Horario:
            <input type="text" name="horario">
        </label>

        <input type="submit" value="Enviar Ficha">
    </form>
    <a href="listarf.php" class="button-link">Ver Registros</a>
</div>
</body>
</html>
