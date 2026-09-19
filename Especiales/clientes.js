/*
    clientes.js - Variable de texto JSON con la tabla principal asignada:
    "Agrupacion de datos logisticos clientes".

    Es una variable de tipo texto (string), NO un objeto de Java script todavia.
    Se declara aca, en un archivo .js aparte, para poder enlazarla con un simple
    <script src="../clientes.js"></script> desde cualquiera de los 4 ejercicios
    (pag. 2 del apunte de especiales).

    La sintaxis tiene que ser JSON perfecto: nombres de atributo entre comillas,
    strings entre comillas, numeros sin comillas, sin coma despues del ultimo
    elemento del array (pag. 1 del apunte de json).

    Los datos de clientes y de fotoPuntoEntrega son INVENTADOS, solo para poder
    probar los ejercicios.
*/
var textoJSONClientes = '{"clientes":' +
    '[' +
    '{"codCliente":"CLI001","codSucursal":"SUC01","direccionEntrega":"Av. Rivadavia 4520, CABA","diaSemanalEntrega":"Lunes","costoPromedioTransporte":1850,"fechaUltimaEntrega":"2025-08-04","fotoPuntoEntrega":"cli001.jpg"},' +
    '{"codCliente":"CLI002","codSucursal":"SUC02","direccionEntrega":"Calle 50 N 1234, La Plata","diaSemanalEntrega":"Martes","costoPromedioTransporte":2100,"fechaUltimaEntrega":"2025-08-05","fotoPuntoEntrega":"cli002.jpg"},' +
    '{"codCliente":"CLI003","codSucursal":"SUC03","direccionEntrega":"Bv. Oroño 2100, Rosario","diaSemanalEntrega":"Miercoles","costoPromedioTransporte":3200,"fechaUltimaEntrega":"2025-07-30","fotoPuntoEntrega":"cli003.jpg"},' +
    '{"codCliente":"CLI004","codSucursal":"SUC01","direccionEntrega":"San Martin 890, CABA","diaSemanalEntrega":"Jueves","costoPromedioTransporte":1700,"fechaUltimaEntrega":"2025-08-06","fotoPuntoEntrega":"cli004.jpg"},' +
    '{"codCliente":"CLI005","codSucursal":"SUC04","direccionEntrega":"Colon 3300, Cordoba","diaSemanalEntrega":"Viernes","costoPromedioTransporte":2900,"fechaUltimaEntrega":"2025-08-01","fotoPuntoEntrega":"cli005.jpg"},' +
    '{"codCliente":"CLI006","codSucursal":"SUC02","direccionEntrega":"Calle 7 N 560, La Plata","diaSemanalEntrega":"Lunes","costoPromedioTransporte":2050,"fechaUltimaEntrega":"2025-08-07","fotoPuntoEntrega":"cli006.jpg"},' +
    '{"codCliente":"CLI007","codSucursal":"SUC03","direccionEntrega":"Pellegrini 1450, Rosario","diaSemanalEntrega":"Martes","costoPromedioTransporte":3050,"fechaUltimaEntrega":"2025-07-28","fotoPuntoEntrega":"cli007.jpg"},' +
    '{"codCliente":"CLI008","codSucursal":"SUC04","direccionEntrega":"Duarte Quiros 2200, Cordoba","diaSemanalEntrega":"Miercoles","costoPromedioTransporte":2750,"fechaUltimaEntrega":"2025-08-03","fotoPuntoEntrega":"cli008.jpg"},' +
    '{"codCliente":"CLI009","codSucursal":"SUC01","direccionEntrega":"Corrientes 2900, CABA","diaSemanalEntrega":"Viernes","costoPromedioTransporte":1650,"fechaUltimaEntrega":"2025-08-02","fotoPuntoEntrega":"cli009.jpg"},' +
    '{"codCliente":"CLI010","codSucursal":"SUC02","direccionEntrega":"Diagonal 74 N 320, La Plata","diaSemanalEntrega":"Jueves","costoPromedioTransporte":2200,"fechaUltimaEntrega":"2025-08-08","fotoPuntoEntrega":"cli010.jpg"}' +
    ']' +
    '}';
