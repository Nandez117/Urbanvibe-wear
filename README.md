# Urbanvibe-wear

Bienvenido al repositorio oficial del proyecto **Urbanvibe-wear**.

## Ramas del Repositorio

El flujo de trabajo se manejará en base a las siguientes ramas principales:
- main: Producción (GCP).
- develop: Rama principal de integración donde se unirán los avances de todos.
- YanF: Rama de desarrollo de YanF.
- JuanM: Rama de desarrollo de JuanM.
- EstebanA: Rama de desarrollo de EstebanA.

> **Importante:** Cada desarrollador debe trabajar siempre en su rama (ej. git checkout YanF), hacer sus commits ahí y luego crear un Pull Request hacia develop para revisión y pruebas conjuntas.

## Configuración del Entorno Local

Estamos utilizando **Laragon / MAMP** como entorno de desarrollo local. Los servicios por defecto como MySQL funcionan por el puerto estándar (3306). 

### Pasos para levantar el proyecto

**Ruta principal del proyecto:** Una vez que levantes el servidor, la ruta principal a invocar en tu navegador es http://localhost:8000/ (o la ruta raíz establecida para el Home).

1. **Clonar el repositorio:**
   
   git clone https://github.com/Nandez117/Urbanvibe-wear.git
   cd Urbanvibe-wear
   

2. **Instalar dependencias de PHP y Node:**
   
   composer install
   npm install
   

3. **Configurar las variables de entorno:**
   - Copiar el archivo de ejemplo:
     
     cp .env.example .env
     
   - Las variables globales para base de datos ya vienen preconfiguradas para Laragon/MAMP en el .env.example. Asegúrate de que en tu archivo .env tengas esta configuración:
     
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=urbanvibe_wear
     DB_USERNAME=root
     DB_PASSWORD=
     
   - Generar la clave de la aplicación (si no se hizo automáticamente):
     
     php artisan key:generate
     

4. **Crear la base de datos en tu entorno local:**
   Abre phpMyAdmin y crea una base de datos vacía llamada urbanvibe_wear.
   
   CREATE DATABASE urbanvibe_wear;
   

5. **Correr las migraciones:**
   
   php artisan migrate
   

6. **Levantar los servidores locales:**
   En terminales separadas, ejecuta:
   
   php artisan serve
   
   npm run dev
   

## Despliegue en GCP (Google Cloud Platform)

Más adelante, el proyecto se desplegará en la infraestructura de GCP.

