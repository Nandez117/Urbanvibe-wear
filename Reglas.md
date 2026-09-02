# Normativas y Estándares de Desarrollo (Urbanvibe-wear)

Este documento define las políticas técnicas y de estilo que el equipo debe seguir para garantizar la calidad, legibilidad y consistencia del código. El incumplimiento de estas normas conlleva penalizaciones en la evaluación.

## 1. Enrutamiento
- **Responsabilidad Exclusiva:** Los archivos de rutas tienen un único propósito: vincular una URL específica con el método de un controlador. Queda estrictamente prohibido incluir lógica de negocio, validaciones o consultas a la base de datos en estos archivos.
- **Referencias:** Se debe utilizar el formato de cadena de texto (String-based reference) para la definición de rutas.

## 2. Controladores
- **Separación de Validaciones (-0.2):** Los controladores deben mantenerse limpios. Toda validación de datos debe delegarse a clases externas (como los Form Requests) para fomentar la reutilización de código (DRY).
- **Tipado Estricto y Retornos:** Es obligatorio definir el tipo de dato de los parámetros recibidos. Las clases importadas deben ubicarse al inicio del archivo y el tipo de retorno de las funciones debe declararse explícitamente (por ejemplo, public function show(string $id): View).
- **Inyección de Modelos (-0.3):** No se permite el uso de *Route Model Binding* directo en los parámetros. Por ejemplo, en los métodos para mostrar detalles, se debe recibir el identificador como texto ($id) y realizar la búsqueda manualmente.
- **Paso de Datos a Vistas (-0.2):** La transferencia de información hacia las vistas debe realizarse exclusivamente mediante la variable $viewData, utilizando arreglos asociativos.
- **Consistencia de Idioma (-0.2):** El código debe escribirse completamente en inglés. No se permite la mezcla de español e inglés en nombres de variables o métodos dentro del controlador.

## 3. Modelado y Base de Datos
- **Nomenclatura y Convenciones:** 
  - Los modelos deben nombrarse en singular utilizando *PascalCase*.
  - Las tablas en la base de datos deben estar en plural y sus columnas en *snake_case*.
  - Al instanciar un modelo, la variable debe tener el mismo nombre que la clase (ej. $product = new Product();).
- **Encapsulamiento (-0.4):** 
  - **Excepción Eloquent vs UML:** En Laravel (Eloquent), declarar propiedades private interfiere con el funcionamiento interno del ORM (que usa el arreglo attributes). Por lo tanto, el estándar para cumplir con el encapsulamiento es:
  - Declarar el listado completo de atributos como un gran comentario (DocBlock) en la parte superior de la clase.
  - Crear todos los métodos accesores y mutadores (getters y setters) en notación camelCase (ej. getNombre()) utilizando internamente $this->attributes['nombre']. Así se respeta el encapsulamiento estricto sin romper el framework.
  - **Tipado Estricto y Retornos:** Es obligatorio definir el tipo de dato de los parámetros recibidos en los setters y el tipo de retorno en los getters (ej. `public function getId(): int`).
- **Métodos y Relaciones:** 
  - Los métodos internos deben ser privados, escritos en camelCase y siempre incluir paréntesis ().
  - Las relaciones del diagrama de clases se traducen en dos funciones (propiedades dinámicas) que conectan ambos modelos. No se deben incluir multiplicidades numéricas en el código.
- **Gestión de la Base de Datos:** 
  - El control de versiones de la base de datos se hará exclusivamente mediante el sistema de **Migraciones** de Laravel.
  - Se debe priorizar el uso de Eloquent ORM; el uso de consultas SQL crudas está prohibido a menos que sea estrictamente necesario.
  - **Datos de prueba y Factories:** Todo modelo que implemente el trait HasFactory debe contar con su respectivo archivo Factory. Una vez generado un volumen adecuado de datos ficticios, se exportará un archivo SQL con las inserciones y se subirá al repositorio únicamente para facilitar la evaluación.

## 4. Calidad del Código y Arquitectura
- **Legibilidad ("Código que respire"):** Se deben respetar los espacios entre operadores matemáticos y bloques lógicos para asegurar que el código no se vea saturado.
- **Uso de Interfaces:** Se fomentará la creación de interfaces para abstraer el comportamiento, facilitando la escalabilidad y el mantenimiento.
- **Configuración del Entorno:** El archivo .env está reservado exclusivamente para credenciales y parámetros de conexión (bases de datos, APIs, etc.).
- **Comentarios Significativos:** Los comentarios deben explicar la razón detrás de una decisión técnica (el "por qué"), evitando describir obviedades que el propio código ya explica.
- **Optimización:** Se deben aplicar conceptos como *Dynamic loading* y funciones accesorias (*accessors*) cuando el contexto lo amerite para mejorar el rendimiento y la limpieza.

## 5. Estandarización Automática (Laravel Pint)
Para asegurar que todo el equipo comparta el mismo estilo de formateo, se utilizará **Laravel Pint**.

- **Flujo Obligatorio:** Antes de confirmar cualquier cambio (git commit), cada desarrollador debe ejecutar en su terminal el comando ./vendor/bin/pint (o php artisan pint). 
- **Revisión en Pull Requests:** Si un PR contiene problemas de formato que Pint podría haber corregido, no será integrado en la rama develop hasta que el autor aplique la corrección.
