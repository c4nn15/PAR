/*
    script.js - js14 - Variables de tipo objeto

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

/* --------------------------------------------------------------------
   DATOS EN MEMORIA (pag. 6 y 7). No hay base de datos: si se recarga
   la pagina se vuelve a estas dos personas iniciales.
   -------------------------------------------------------------------- */

// Variable de tipo objeto con asignacion de valores: pares clave:valor
let objetoPersona = { nombre: "Pablo", apellido: "Galdi", fechaNac: "01/07/1956" };

// Arreglo de objetos: el primer elemento es objetoPersona
let arregloPersonas = [objetoPersona];

// Segundo objeto persona cargado con push()
arregloPersonas.push({ nombre: "Jose", apellido: "Witt", fechaNac: "17/01/1985" });

// Objeto final que representa al arreglo de objetos
var objetoPersonas = { personas: arregloPersonas };

// Objetos del DOM que se usan varias veces
const objNombre = document.getElementById("nombre");
const objApellido = document.getElementById("apellido");
const objFechaNac = document.getElementById("fechaNac");
const objPresentacion = document.getElementById("presentacion");

/* --------------------------------------------------------------------
   Arma la tabla de personas en un string y la asigna a innerHTML
   (pag. 9). El forEach recorre el arreglo: item es cada objeto persona
   e indice su posicion numerica (pag. 10).
   -------------------------------------------------------------------- */
function listarPersonas() {
    var texto = "<h1>Presentacion</h1>";

    texto = texto + "<table style='border-collapse:collapse;border:solid'>";
    texto = texto + "<tr><th>Indice</th><th>Nombre</th><th>Apellido</th><th>Fecha de nacimiento</th></tr>";

    objetoPersonas.personas.forEach(function (item, indice) {
        texto = texto + "<tr>";
        texto = texto + "<td>" + indice + "</td>";
        texto = texto + "<td>" + item.nombre + "</td>";
        texto = texto + "<td>" + item.apellido + "</td>";
        texto = texto + "<td>" + item.fechaNac + "</td>";
        texto = texto + "</tr>";
    });

    texto = texto + "</table>";
    texto = texto + "<h4>Longitud del arreglo de objetos: " + arregloPersonas.length + "</h4>";

    objPresentacion.innerHTML = texto;
    objPresentacion.style.display = "block";
}

/* --------------------------------------------------------------------
   Crear persona: valida los tres inputs con checkValidity() (pag. 8).
   Si validan, crea el objeto, lo agrega al arreglo y relista.
   -------------------------------------------------------------------- */
document.getElementById("btnCrear").addEventListener("click", function () {
    if (objNombre.checkValidity() == true &&
        objApellido.checkValidity() == true &&
        objFechaNac.checkValidity() == true) {

        // El input date entrega "aaaa-mm-dd": con substr lo pasamos a dd/mm/aaaa
        let fecha = objFechaNac.value;
        let fechaFormateada = fecha.substr(8, 2) + "/" + fecha.substr(5, 2) + "/" + fecha.substr(0, 4);

        arregloPersonas.push({
            nombre: objNombre.value,
            apellido: objApellido.value,
            fechaNac: fechaFormateada
        });

        listarPersonas();

        // Blanqueo las entradas y dejo el cursor en el primer input
        objNombre.value = "";
        objApellido.value = "";
        objFechaNac.value = "";
        objNombre.select();
    }
    else {
        alert("Falla de la validacion: completar nombre, apellido y fecha de nacimiento.");
        objNombre.select();
    }
});

document.getElementById("btnListar").addEventListener("click", function () {
    listarPersonas();
});

/* display = "none" hace desaparecer al div y recupera su espacio (pag. 10) */
document.getElementById("btnOcultar").addEventListener("click", function () {
    objPresentacion.style.display = "none";
});
