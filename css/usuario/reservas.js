fetch('http://localhost/oscar/animalesyo/presentacion/api/agregar_reserva.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(datos)
})
.then(res => res.text())  // lee como texto para debug
.then(text => {
    console.log("Respuesta completa del servidor:", text);
    try {
        const data = JSON.parse(text);
        if (data.ok) {
            window.location.href = "reservascarrito.php";
        } else {
            alert("âŒ Error al agregar: " + data.mensaje);
        }
    } catch(e) {
        console.error("âŒ No es JSON vÃ¡lido:", e);
        alert("âŒ La respuesta del servidor no es JSON vÃ¡lido.");
    }
})
.catch(err => {
    console.error("âŒ Error:", err);
    alert("âŒ Error al conectar con el servidor.");
});

        const datos = {
    id: button.dataset.libro_id,  // Aquí el nombre del campo es 'id'
    nombre: button.dataset.nombre
};
        
        
       // fetch('Reservas.php', {
       //   method: 'POST',
        //  headers: { 'Content-Type': 'application/json' },
       //   credentials: 'include',
       //   body: JSON.stringify(datos)
      //  })
        .then(res => res.text())
        .then(text => {
          console.log('Respuesta cruda:', text);
          try {
            const data = JSON.parse(text);
            if (data.ok) {
              alert('âœ… Reserva agregada al carrito');
            } else {
              alert('âŒ Error: ' + (data.mensaje || 'Error desconocido'));
            }
          } catch (e) {
            alert('âŒ Error inesperado. RevisÃ¡ la consola.');
            console.error('JSON invÃ¡lido:', text);
          }
        })
        .catch(err => {
          alert('âŒ Error de red o servidor');
          console.error(err);
        });

