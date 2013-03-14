Bluegrass/blues
===============

Plataforma de desarrollo para aplicaciones Symfony2.

Dependencias
============
Jquery.1.8.0 o superior
Symfony2:
 - AsseticBundle


Instalación y configuración
===========================
- Asegurarse de ejecutar en consola el comando: 'php app/console assetic:dump'
- Dentro del layout principal, es necesario incluir las dependencias de javascript y hojas de estilos:
  {% block stylesheets %}
    <link rel="stylesheet" src="{{ asset('assetic/bluegrassbluesbundle_stylesheets.css') }}" type="text/css" />
  {% endblock %}
  {% block javascripts %}            
    <script src="{{ asset('assetic/bluegrassbluesbundle_javascripts.js') }}" type="text/javascript"></script>
  {% endblock %}
