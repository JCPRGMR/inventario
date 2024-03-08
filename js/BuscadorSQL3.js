const buscador = document.getElementById("buscador");

var xhr = new XMLHttpRequest();

buscador.addEventListener("keyup", function() {
  if (buscador.value === "") {
    cargarDatos();
    return;
  }

  xhr.open("POST", "../request/botones.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response) {
        actualizarTabla(response);
      } else {
        id_activo.innerHTML = "Sin id";
        codigo_ubicacion_gral_old.innerHTML = "Sin UG";
      }
    }
  };

  xhr.send("dato=" + buscador.value);
});

var tabla = document.querySelector('table');

function cargarDatos() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../request/botones.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);
      actualizarTabla(data);
    }
  };
  xhr.send();
}

function actualizarTabla(data) {
  var filas = tabla.querySelectorAll('tbody tr');

  for (var i = 0; i < data.length; i++) {
    var row = data[i];
    var fila = filas[i];

    if (fila) {
      // fila.querySelector('#id_activo').textContent = row.id_activo;
      fila.querySelector('#codigo_ubicacion_gral_old').textContent = row.codigo_ubicacion_gral_old || '';
      fila.querySelector('#codigo_rubro_old').textContent = row.codigo_rubro_old || '';
      fila.querySelector("#correlativo_old").textContent = row.correlativo_old || '';
      
      fila.querySelector("#codigo_ubicacion_gral_new").textContent = row.codigo_ubicacion_gral_new || '';
      fila.querySelector("#codigo_ubicacion_esp_new").textContent = row.codigo_ubicacion_gral_new || '';
      fila.querySelector("#codigo_rubro_new").textContent = row.codigo_rubro_new || '';
      fila.querySelector("#correlativo_new").textContent = row.correlativo_new || '';

      fila.querySelector("#des_tipo").textContent = row.des_tipo || '';
      fila.querySelector("#detalles").textContent = row.detalles || '';
      fila.querySelector("#des_marca").textContent = row.des_marca || '';
      fila.querySelector("#modelo").textContent = row.modelo || '';
      fila.querySelector("#serie").textContent = row.serie || '';
      fila.querySelector("#des_pais").textContent = row.des_pais || '';
      fila.querySelector("#año_compra").textContent = row.año_compra || '';

      fila.querySelector("#empresa_factura").textContent = row.empresa_factura || '';
      fila.querySelector("#nro_factura").textContent = row.nro_factura || '';
      fila.querySelector("#codigo_estado").textContent = row.codigo_estado || '';
      fila.querySelector("#valor_inicial").textContent = row.valor_inicial || '';
      fila.querySelector("#al_2021").textContent = row.al_2021 || '';
      fila.querySelector("#valor_recidual").textContent = row.valor_recidual || '';
    }
  }
}

// Cargar datos al cargar la página
cargarDatos();

document.addEventListener('DOMContentLoaded', function() {
  var buscador = document.getElementById('buscador');
  var tbody = document.querySelector('#miTabla tbody');
  var filas = tbody.getElementsByTagName('tr');

  buscador.addEventListener('input', function() {
    var filtro = buscador.value.trim().toLowerCase();

    for (var i = 0; i < filas.length; i++) {
      var fila = filas[i];
      var contenido = fila.textContent.trim().toLowerCase();

      if (contenido.includes(filtro)) {
        fila.style.display = 'table-row';
      } else {
        fila.style.display = 'none';
      }
    }
  });
});

function redirigirAScript(fila) {
  var celda = fila.getElementsByTagName('td')[0]; // Supongamos que obtienes la primera celda
  var valorCelda = celda.textContent;
  // Redirigir a script.php pasando el valor de la celda como parámetro
  window.location.href = 'activo_editar.php?valor=' + encodeURIComponent(valorCelda);
}