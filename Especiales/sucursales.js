/*
    sucursales.js - Variable de texto JSON con la tabla AUXILIAR.

    Cumple el mismo rol que la tabla "familias" del ejemplo del profesor: sirve
    para poblar dinamicamente el <select> de sucursal del formulario de ALTA,
    en lugar de escribir las <option> a mano (pag. 5 y 6 del apunte de json).

    No hay tabla auxiliar asignada por la catedra todavia, asi que se arma esta
    con datos INVENTADOS a partir de las sucursales que aparecen en clientes.js.
*/
var textoJSONSucursales = '{"sucursales":' +
    '[' +
    '{"codSucursal":"SUC01","nombreSucursal":"CABA Centro","direccionSucursal":"Av. Corrientes 1200, CABA"},' +
    '{"codSucursal":"SUC02","nombreSucursal":"La Plata","direccionSucursal":"Calle 12 N 800, La Plata"},' +
    '{"codSucursal":"SUC03","nombreSucursal":"Rosario","direccionSucursal":"Bv. Oroño 900, Rosario"},' +
    '{"codSucursal":"SUC04","nombreSucursal":"Cordoba Capital","direccionSucursal":"Av. Colon 1500, Cordoba"}' +
    ']' +
    '}';
