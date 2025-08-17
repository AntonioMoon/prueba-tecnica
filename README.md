# Prueba Técnica - Laravel Countries
Este proyecto es una aplicación Laravel 11 que utiliza Filament para gestionar un recurso de países

## Requisitos
- [Docker] [Docker-compose] instalado
- [Git] instalado
- [PHP] 8.2/8.3

## Instalación

1. **Clona el repositorio**:
   git clone https://github.com/tu-usuario/prueba-tecnica.git

2. **Copia el .env**: copy .env.example .env

4. **Inicia el contendor**: docker-compose up -d

5. **Instala dependencias**: docker-compose exec app composer install

6. **Genera la clave**: docker-compose exec app php artisan key:generate

7. **docker-compose exec app php artisan migrate --seed**: Ejecuta las migraciones con los seeder que esta el usuario

**AccesoPanel de Administración de Filament**
**URL**: http://localhost:8000/admin/login
**Credenciale**s: test@gmail.com / password

**Endpoints de la API publica**:
**GET** /api/countries: Lista todos los países.
**GET** /api/countries/{cca3}: Detalles de un país por su código cca3 (ejemplo: /api/countries/ESP).


   
