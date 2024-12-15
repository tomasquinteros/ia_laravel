IA CON PRINCIPIOS SOLID
<br><br><br><br>
<strong>Estructura de carpetas</strong>

<pre>
    app/
    ├── Controllers/
    │   └── ImagenController.php   # Controlador para recibir solicitudes HTTP
    ├── Services/
    │   └── MultipleImageProcessorService.php  # Servicio para procesar múltiples imágenes
    ├── Interfaces/
    │   └── IAProcessorInterface.php  # Interfaz para definir el contrato de las IAs
    ├── Exceptions/
    │   └── ImageValidationException.php  # Excepción personalizada para imágenes corruptas
    ├── Processors/
    │   ├── IAChainProcessor.php  # Clase que maneja la cadena de IAs
    │   ├── OpenAIProcessor.php   # Procesador específico para OpenAI
    │   └── GeminiProcessor.php   # Procesador específico para Gemini
</pre>

Usamos esta estructura ya que convinamos Pricipios SOLID y Clean Architecture.

SRP => Cada clase tiene su propia responsabilidad:

* Controlador => Recibe una solicitud,envia al servicio y devuelve una respuesta
* Servicio => Se encarga de organizar el procesamiento de las imagenes.
* Procesadores => Cada IA tiene su logica propia de como manejar los request a la API.

OCP => Podemos agregar nuevas IAs en los Procesadores que implementen nuestra Interfaz
<br>
<br><br><br><br><br><br><br>
<strong>Interfaz IA</strong>

Creamos la interfaz IAProcessorInterface => <br>

* Define metodos obligatorios que todas las ia deben usar.
* Facilita la intercambiabilidad de IAs (Principio LSP) y la inversión de dependencias (DIP).
* Gracias a la interfaz el sistema no sabrá si estamos usando Open AI o Gemini o cualquier otra IA.

La interfaz tiene 3 metodos que todos los servicios de ia tiene que tener:

* isAvaible() => En el cual hacemos un checkeo rapido si la IA se encuentra en funcionamiento.
* processImage($image) donde le pasamos una imagen base64 y la procesa.
* callAPI($message) aca hacemos la llamada a la API de la IA que luego la usamos en el metodo processImage

<strong>OpenAI clase</strong>

Creamos la clase de OpenAI donde implementamos la interfaz de la IA

Aplicando el SRP (Single Responsibility Principies) => Su unica responsabilidad es iteracturar con la API IA.

<strong>Gemini clase</strong>

Creamos la clase de Gemini donde implementamos la interfaz de la IA.

Aplicando el SRP (Single Responsibility Principies) => Su unica responsabilidad es iteracturar con la API IA.

<strong>IAChainProcessor clase</strong>

Creamos la clase IAChainProcessor el cual se encargara de utilizar las ias en forma de cadena, si falla una, utiliza
la otra. De esta manera podemos implemetar más ias a futuro.

OCP: Podemos agregar una nueva IA sin cambiar el procesador.
LSP (Sustitución de Liskov): OpenAI y Gemini son intercambiables porque implementan la misma interfaz.

<strong>Imagen Controller</strong>

En este controlador recibe un request por http. Se encarga de mandarselo al MultipleImageProcessorService donde el mismo
le devuelve los resultados que debe mandar por json.

Aplicando: SRP porque tiene una unica resposabilidad:  acatar la solicitud, enviarla al servicio y luego responder.
DIP (Dependencies Inversion Pricipies) No depende de una clase concreta, sino más bien de una Interfaz.

<strong>MultipleImageProcessorService</strong>

Recibe una lista de imagenes desde algun controlador. Itera las imagenes y por cada una utiliza la cade de
procesamientos de ias.

Principios aplicados en el servicio

SRP: Se encarga de la lógica de procesamiento de imágenes, nada más.
DIP: Depende de la IAProcessorInterface, no de clases concretas.
OCP: Podemos agregar nuevas validaciones de imagen (por ejemplo, verificar resolución) sin modificar el flujo general.


<strong>
EXCEPTIONS
</strong>

SRP: Las excepciones están centralizadas.
Transparencia: El cliente (API) recibe una respuesta clara de por qué falló el proceso.


