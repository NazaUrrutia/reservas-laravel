# Sistema de Reservas · Laravel + Angular

Proyecto de gestión de reservas desarrollado con **Laravel 12 (API REST)** y **Angular (frontend)**.  
Incluye endpoints API, validaciones con *Form Requests*, controladores web con vistas Blade y migraciones automáticas de base de datos.


- **Backend:** Laravel 12 (PHP 8.2+, Composer)
- **Frontend:** Angular (interfaz de usuario)
- **Base de datos:** MySQL (a través de XAMPP)
- **Servidor local:** php artisan serve o Apache (XAMPP)


-Instalación paso a paso

### Clonar el repositorio

cd c:\xampp\htdocs
git clone https://github.com/NazaUrrutia/reservas-laravel.git
cd reservas-laravel

### Instalar dependencias de Laravel
--composer install

### Configurar el entorno local 
copy .env.example .env

Edita el archivo .env con los datos locales

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=reservas_laravel
DB_USERNAME=root
DB_PASSWORD=

### Instalar el paquete API
En Laravel 12 el archivo routes/api.php no existe por defecto, por lo que debe instalarse el paquete API.
php artisan install:api


### Crear la base de datos y migrar
php artisan migrate


### Ejecutar el servidor
php artisan serve


### Abrí en el navegador:
http://localhost:8000/reservations


Autor: Nazarena Urrutia
Desarrolladora Full Stack 
=======
# reservas-laravel
>>>>>>> 55c08182908a0cdf5a02e3698c0d7bdd3572cd00
