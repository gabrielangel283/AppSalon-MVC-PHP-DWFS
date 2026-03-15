# AppSalon - PHP - MVC
Este repositorio es para el deployment del proyecto de AppSalon del curso de Udemy: "Desarrollo Web Completo con HTML5, CSS3, JS AJAX PHP y MySQL".
Se trata de una aplicacion web desarrollada en PHP utilizando el patrón MVC, que permite gestionar [usuarios, servicios, citas, etc.].
Utiliza MySQL como base de datos, Composer para dependencias de PHP y npm para gestionar recursos del frontend.


## 🛠️Tecnologias utilizadas
- PHP (Backend)
- MySQL (Administrador de BD)
- Composer (Administrador de libreria de PHP)
- Node.js / npm (Gestionar librerias de Frontend)
- HTML / CSS / JavaScript
- SASS (Extension de CSS para facilitar el diseño)


## 🚀 Instalación

Para utilizar probar el proyecto y ver la funcionalidad, se necesita realizar lo siguiente:

#### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/gabrielangel283/appsalon-mvc-php-DWFS.git
cd appsalon-mvc-php-DWFS
```
#### 2️⃣ Instalar dependencias de PHP
```bash
# esto intalara el phpmailer y el vlucas/phpdotenv del compose.json
composer install
```
#### 3️⃣ Instalar dependencias de frontend
```bash
# esto instalara el gulp, sharp y sass del package.json
composer install
```
#### 4️⃣ Configurar la base de datos
El codigo SQL de la bd esta en el mismo repositorio, solo bastaria con ejecutarlo de forma local en el MySQL

#### 5️⃣ Ejecutar el proyecto
En la maquina con PHP 8.4:
```bash
php -S localhost:3000
```

## Variables de entorno

Este proyecto funciona con variables de entorno para diferentes datos y funcionalidades de la aplicacion web.

#### Para la bd

`DB_HOST`
`DB_USER`
`DB_PASS`
`DB_NAME`

#### Para el phpmailer

`EMAIL_HOST`
`EMAIL_PORT`
`EMAIL_USER`
`EMAIL_PASS`

Para obtener estas variables, se debe crear una cuenta en [Mailtrap](https://mailtrap.io/), hacer uso del Samdboxes, crear un entorno de pruebas SMTP y elegir el codigo de phpMailer.

#### URL del server

`PROJECT_URL`


## Despliegue

Este proyecto fue subido a internet en la plataforma de DOMCloud en el siguiente link: https://appsalon-phpmvc-dwfs.sao.dom.my.id/.

Ya que las variables de entorno fueron cambiadas por seguridad, la funcionalidad de envio de correo a mailtrap, la confirmación y cambio de constraseña de la cuenta, no funcionaran (esto solo se podria probar de forma local).