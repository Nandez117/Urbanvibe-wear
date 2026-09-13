# Normativas y Estándares de Desarrollo (Urbanvibe-wear)

Este documento define las políticas técnicas y de estilo que el equipo debe seguir para garantizar la calidad, legibilidad y consistencia del código. El incumplimiento de estas normas conlleva penalizaciones en la evaluación.

## 1. Enrutamiento (Rutas)
- **Responsabilidad Exclusiva:** Las rutas solo deben encargarse de conectar las URLs con los métodos de los controladores. Queda estrictamente prohibido incluir lógica de negocio, validaciones o consultas a la base de datos en estos archivos.
- **Referencias de Rutas:** Se recomienda utilizar la referencia basada en importación (use ControllerClass) o clases ([Controller::class, 'method']) en lugar de cadenas de texto quemadas (string-based).
- **Nomenclatura:** Poner siempre el alias (nombre) a la vista/ruta usando ->name('alias').

## 2. Controladores
- **Controladores Limpios:** No poner código reutilizable en los controladores. Los controladores solo definen funciones que devuelven las vistas correspondientes (con esos nombres agregando .blade.php).
- **Validaciones y Request:** Las validaciones de datos no deben ir en los controladores, deben delegarse a clases externas (Form Requests) o al modelo (anotar validaciones sueltas en el controlador penaliza, ya que "no es lo mejor"). 
- **Uso de Importaciones:** Las clases deben importarse arriba usando use.
- **Tipado Estricto:** Se deben definir siempre los tipados de los argumentos y los retornos de los métodos (por ejemplo, public function show(string $id): View).
- **Inyección de Modelos:** No se permite el uso de *Route Model Binding* directo en los parámetros. Se debe recibir el identificador y realizar la búsqueda manualmente mediante Eloquent.
- **Datos y Vistas:** No se debe manejar la lista de productos u otra lógica compleja directamente en los controladores. La transferencia de información hacia las vistas debe realizarse exclusivamente mediante la variable $viewData, utilizando arreglos asociativos, NO con compact.
- **Consistencia de Idioma:** El código debe escribirse completamente en inglés. No mezclar español e inglés en nombres de variables o métodos.

## 3. Modelado y Base de Datos
- **Nomenclatura y Convenciones:** 
  - Los modelos deben nombrarse en singular utilizando *PascalCase*.
  - En Laravel todas las tablas en la base de datos tienen que estar en plural y sus columnas en *snake_case*.
  - Al instanciar un modelo, la variable debe tener el mismo nombre que la clase (ej. $product = new Product();).
  - No mezclar inglés y español en el modelo.
  - Importaciones sin usar el use arriba en el modelo están penalizadas.
- **Listado de Atributos:** En el controlador se puede acceder a los atributos del modelo, pero en los modelos no se tienen que definir los atributos nativos de Laravel porque dinámicamente el controlador los trae de la DB. Sin embargo, **SIEMPRE** se debe poner el listado completo de atributos como un comentario (DocBlock) en la parte superior para "reconocerlos".
- **Encapsulamiento y Acceso Único:** Penalización de -0.0 o -0.4 por no hacerlo. Colocar atributos privados (si aplica, aunque Laravel usa $this->attributes) y usar obligatoriamente getters y setters para el encapsulamiento (ej. $product->getName();). Esto garantiza un único punto de acceso desde el código donde se modifica y obtiene cada atributo.
  - **Ordenamiento de Métodos:** Seguir estrictamente este orden:
    1. Getters y Setters de atributos primitivos de la base de datos (los que usan ->attributes).
    2. Getters y Setters de atributos primitivos adicionales.
    3. Getters y Setters no primitivos (relaciones).
- **Relaciones:** Siempre poner a las relaciones getter y setter. Las relaciones se traducen en dos funciones que conectan ambos modelos.
- **Asignación Masiva:** Utilizar $fillable para definir qué atributos del modelo se pueden asignar en masa. La propiedad $guarded debe contener un arreglo con los atributos que no deseas que se asignen masivamente.
- **Consultas DB (N+1):** Usar Eloquent. Solucionar el problema de consultas N+1 haciendo "1 sola consulta para sacar todos los productos" mediante *Eager Loading* (with()).

## 4. Migraciones, Factories y Seeding
- **Migraciones:** 
  - Siempre usar migraciones, tener un archivo por cada tabla.
  - Todo se debe poder reversar mediante los métodos up y down en cada tabla.
  - **Timestamps:** Siempre poner los 	imestamps(). Dado que este método crea internamente created_at y updated_at, **no** se deben combinar creándolos de nuevo a mano, ya que es redundante.
- **Factories:** Define uno o más patrones para crear modelos ficticios. Si a un modelo se le define su propio factory, hay que incluir el trait HasFactory en la clase modelo verificando que sí tenga el archivo factory correspondiente en la carpeta.
- **Seeding:** Utilizar php artisan db:seed para llenar las tablas y probar la app usando datos ficticios obligatoriamente.

## 5. Vistas y Código HTML
- **Código HTML Exclusivo:** El código HTML debe ir exclusivamente en las vistas (views), manteniendo la menor cantidad de elementos posibles para que sean reutilizables.
- **Traducciones:** Utilizar las directivas de lang para el manejo de idiomas en la interfaz.
- **Datos en la Vista:** Enviar datos obligatoriamente con el arreglo asociativo $viewData, nunca con compact.
- **Separación de CSS y HTML:** Se debe separar el CSS del HTML, ubicando los archivos CSS en una carpeta dentro de `public` llamada `css`, y en las vistas (`resources`) llamarlos mediante un *layout*.

## 6. Calidad del Código y Arquitectura
- **Legibilidad:** Respetar espacios entre operadores matemáticos y bloques lógicos.
- **Uso de Interfaces:** Para cumplir el principio de inversión de dependencias se deben usar interfaces, ya que facilitan la escalabilidad y el mantenimiento.
- **Configuración del Entorno:** El archivo .env es reservado exclusivamente para credenciales.

## 7. Estandarización Automática (Laravel Pint)
- Tener un autocorrector de estilos (como Laravel Pint o Flake8).
- **Ubicación de Ejecución:** El comando formateador **siempre se debe ejecutar desde la raíz del proyecto**.
- **Flujo Obligatorio:** Antes de confirmar cambios (git commit), ejecutar en la terminal ./vendor/bin/pint (o php artisan pint).
- **Revisión en Pull Requests:** Si un PR contiene problemas de formato que Pint podría haber corregido, será rechazado.