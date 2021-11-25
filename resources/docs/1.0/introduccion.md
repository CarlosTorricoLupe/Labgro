# Introducción

---

- [Introducción](#section-1)
- [Objetivo General del proyecto](#section-2)
- [Fundamentos Teoricos](#section-3)
- [Requerimientos de funcionamiento](#section-4)
- [Requerimientos del sistema](#section-5)
- [Requerimientos del servidor](#section-6)
- [Estructura de directorios](#section-7)

<a name="section-1"></a>
## Introducción
Actualmente en la facultad de ciencias agrícolas, pecuarias y forestales para realizar el    control de almacenamiento y producción, hacen uso de medios tradicionales, llenando planillas excel manualmente, y al mismo tiempo desconocen de la cantidad de insumos exacta que existen en almacén en un momento dado que desean ver de la opción de desarrollar un producto.
Esto ocasiona a la facultad un tiempo excesivo en el llenado digital de planillas manuales, procesos repetitivos en el llenado de estas planillas, además de no tener precisión de insumos existentes requeridos para la producción.
Es por esta razón que se realizará una plataforma web donde se gestionará el almacenamiento y producción de las distintas áreas de producción de la facultad (frutas, lácteos y cárnicos).

<a name="section-2"></a>
## Objetivo General del proyecto
Desarrollar una plataforma web para gestionar los almacenes y productos elaborados en la facultad de ciencias agrícolas, pecuarias y forestales de la UMSS.

<a name="section-3"></a>
## Fundamentos Teoricos
<<Software libre>> es el software que respeta la libertad de los usuarios y la comunidad. A grandes rasgos, significa que los usuarios tienen la libertad de ejecutar, copiar, distribuir, estudiar, modificar y mejorar el software. Es decir, el <<software libre>> es una cuestion de libertad no de precio. Para entender el concepto, piense en <<libre>> como en <<libre expresión>>, no como en <<barra libre>>.


-Licencias GNU General Public Licence (GNU GPL): se utilizan para el software libre, la adopción de esta licencia garantiza a los usuarios finales la libertad de usar, estudiar, compartir y modificar el software. Su propósito es declarar que el software cubierto por esta licencia es software libre y protegerlo de intentos de apropiación que restrinjan esas libertades a los usuarios.

Licencias BSD (Berkeley Software Distribution): llamadas asi porque utilizan en gran cantidad de software distribuido junto a los sistemas operativos BSD. El autor, bajo tales licencias, mantiene la protección de copyright unicamente para la renuncia de garantía y para requerir la adecuada atribución de la autoría en trabajos derivados, pero Biblioteca Universitaria 2 permite la libre redistribución y modificación, incluso si dichos trabajos tienen propietario.


<a name="section-4"></a>
## Requerimientos de funcionamiento
<p>Los siguientes requerimientos de este sistema son para el correcto funcionamiento del sistema de información.</p>

<p>Sistemas Operativos</p>
<ul>
<li>Windows 8</li>
<li>Windows 10</li>
</ul>

<p>Lenguajes de programación</p>
<ul>
<li>PHP 7.4</li>
</ul>

<p>Frameworks</p>    
<ul>
<li>Laravel 8</li>
</ul>

<p>Herramientas</p>
<ul>
<li>Sistema de gestión de bases de datos: Xampp v3.3.0</li>
<li>Administrador de base de datos: phpmyadmin</li>
<li>Autentificación con JWT.</li>
</ul>

<a name="section-5"></a>
## Requerimientos del sistema
<ul>
<li>
<p>Servidor</p>
    <ul>
        <li>
            <p>Versión PHP: requiere php ^ 5.6 || ^ 7.0 -> su versión de php (8.0.0) no satisface ese requisito. (jwt)</p>
        </li>
    </ul>
</li>
<li>
<p>Cliente</p>
    <ul>
        <li>
            <p>Minimo</p>
            <ul>
                <li>
                    <p>OS: Windows 8</p>
                </li>
                <li>
                    <p>Procesador: Procesador Intel® Celeron® 847, 1,10 GHz o superior</p>
                </li>
                <li>
                    <p>Memoria: 1 GB (32 - bit) o 2GB (64 - bit).</p>
                </li>
                <li>
                    <p>Red: Conexión a Internet de banda ancha.</p>
                </li>
                <li><p>Disco Duro: 16GB (32 bits) o 20GB (64 bits).</p></li> 
            </ul>   
        </li>
        <li>
            <p>Recomendado</p>
            <ul>
                <li>
                <p>OS: Windows 8. Windows 10.</p>
                <li><p>Procesador: 2.8 GHz Intel Core I5.</p></li>
                <li><p>Memoria: 4 GB RAM.</p></li>
                <li><p>Red: Conexión a Internet de banda ancha.</p></li>
                <li><p>Disco Duro: 100 GB espacio disponible.</p></li>
                </li>
            </ul>
        </li>
    </ul>
</li>
</ul>

<a name="section-6"></a>
## Requerimientos del servidor
<p>
El marco de Laravel tiene algunos requisitos del sistema. Debe asegurarse de que su servidor web tenga las siguientes versiones y extensiones mínimas de PHP:
</p>
<ul>
    <li><p>PHP> = 7.3</p></li>
    <li><p>Extensión PHP BCMath</p></li>
    <li><p>Extensión PHP Ctype</p></li>
    <li><p>Extensión PHP Fileinfo</p></li>
    <li><p>Extensión PHP JSON</p></li>
    <li><p>Extensión PHP Mbstring</p></li>
    <li><p>Extensión PHP OpenSSL</p></li>
    <li><p>Extensión PHP PDO</p></li>
    <li><p>Extensión PHP Tokenizer</p></li>
    <li><p>Extensión PHP XML</p></li>
</ul>

<a name="section-7"></a>
## Estructura de directorios
<p>El directorio raíz</p>
<ul>
    <li><p>El app directorio</p></li>
    <li><p>El bootstrap directorio</p></li>
    <li><p>El config directorio</p></li>
    <li><p>El database directorio</p></li>
    <li><p>El public directorio</p></li>
    <li><p>El resources directorio</p></li>
    <li><p>El routes directorio</p></li>
    <li><p>El storage directorio</p></li>
    <li><p>El tests directorio</p></li>
    <li><p>El vendor directorio</p></li>
    <li><p></p></li>
</ul>

<p>El directorio de aplicaciones</p>
<ul>
    <li><p>El Broadcasting directorio</p></li>
    <li><p>El Console directorio</p></li>
    <li><p>El Events directorio</p></li>
    <li><p>El Exceptions directorio</p></li>
    <li><p>El Http directorio</p></li>
    <li><p>El Jobs directorio</p></li>
    <li><p>El Listeners directorio</p></li>
    <li><p>El Mail directorio</p></li>
    <li><p>El Models directorio</p></li>
    <li><p>El Notifications directorio</p></li>
    <li><p>El Policies directorio</p></li>
    <li><p>El Providers directorio</p></li>
    <li><p>El <code>Rules</code>  directorio</p></li>
</ul>


![image](https://picsum.photos/200/300)
