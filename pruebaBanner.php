<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba Banner Vertical</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 220px;
            background-color: #003366;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .banner-inferior {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background-color: #003366;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .vertical-banner {
            position: fixed;
            top: 220px;     /* debajo del header */
            bottom: 120px;  /* arriba del banner inferior */
            left: 0;
            width: 120px;
            background-color: #004080;
            padding: 10px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            border-radius: 0 8px 8px 0;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.3);
            z-index: 999;
            transition: left 0.3s ease;
        }

        .vertical-banner button {
            margin: 5px 0;
            padding: 10px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .toggle-banner-btn {
            position: fixed;
            top: 240px;
            left: 120px;
            width: 30px;
            height: 30px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            z-index: 1001;
        }

        .contenido {
            margin-top: 240px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <header>
        Header Fijo
    </header>

    <div class="vertical-banner" id="verticalBanner">
        <!-- Botones de ejemplo -->
        <button>Botón 1</button>
        <button>Botón 2</button>
        <button>Botón 3</button>
        <button>Botón 4</button>
        <button>Botón 5</button>
        <button>Botón 6</button>
        <button>Botón 7</button>
        <button>Botón 8</button>
        <button>Botón 9</button>
        <button>Botón 10</button>
    </div>

    <button class="toggle-banner-btn" id="toggleBtn">☰</button>

    <div class="contenido">
        <p>Contenido principal de la página.</p>
        <p>(Este contenido puede ser largo y con scroll)</p>
        <p style="height: 2000px;"></p>
    </div>

    <div class="banner-inferior">
        Banner Inferior Fijo
    </div>

    <script>
        const banner = document.getElementById('verticalBanner');
        const toggleBtn = document.getElementById('toggleBtn');

        toggleBtn.addEventListener('click', () => {
            if (banner.style.left === '0px' || banner.style.left === '') {
                banner.style.left = '-130px';  // Oculta
                toggleBtn.style.left = '0px';
            } else {
                banner.style.left = '0px';     // Muestra
                toggleBtn.style.left = '120px';
            }
        });
    </script>

</body>
</html>
