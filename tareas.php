Problemas a solucionar:

Usuario
-Inscripciones a talleres
-Mejorar presentacion Autoridades
-Enviar historial de pagos a su perfil

Admin
General
-Borrar imagenes al reemplazarlas
-Datos reales con count en index
-Arreglar Dropdown
-Añadir decoracion en pie/footer
-Añadir apartado propio de pagos

Talleres
-Boton de quitar imagen en Talleres
-Mejorar Presentacion de talleres
-Añadir boton de "ir a editar" en vista talleres

Libros
-Añadir Estados activo-inactivo en libros
-Count de libros prestados y devueltos

Socios
-Limit 5 en registro de socios
-Arreglar contraseña en registro socios
-Arreglar Nro de socio en socios pendientes, al crear una cuenta el socio pendiente tiene como NRo de socio su nombre y apellido completo
-Quitar apellidos, dejar nombre completo
-añadir editar en socios registro
-Añadir filtrado de socios pendientes en Vista socios

PAgos
-Mejorar pagos:
-Separar quienes pagaron de quienes no en 2 archivos distintos, añadir buscador en pagos pendientes
-Solo socios activos pueden pagar
-Opcion de quitar pago 
-Historial de meses de pagos, ver pagos de meses pasados
-Que el %de socios que pagaron solo sea en base a los socios activos no los totales.


Avisos:
-Mejorar Avisos(Incluir imagenes)

General
-Carpetas de imagenes por serparado
-Pie con decoracion, redes sociales, numero, direccion e informacion
-Arreglar institucion
-Añadir sitio de ayuda y preguntas frecuentes

<div style="background: yellow; padding: 10px; margin: 10px 0;">
    <strong>DEBUG:</strong><br>
    - Carrito count: <?php echo count($_SESSION['carrito_reservas']); ?><br>
    - Action URL: controladores/reservaController.php<br>
    - Session ID: <?php echo $_SESSION['id'] ?? 'No encontrado'; ?>
</div>