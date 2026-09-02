# Urbanvibe-wear 👕👟

**Urbanvibe-wear** es una plataforma moderna de comercio electrónico enfocada en la venta de ropa y calzado urbano. Nuestro objetivo es ofrecer una experiencia de compra ágil, segura y con una interfaz de usuario atractiva para los amantes del estilo urbano.

### 👥 Integrantes del Equipo:
- Yan Frank Rios Lopez
- Esteban Alvarez Garcia
- Juan Manuel Hernandez Martelo
---

## 🌿 Flujo de Desarrollo y Ramas (Git Workflow)

El proyecto utiliza un flujo de trabajo basado en Historias de Usuario (Feature Branches). Las ramas principales son:

- `main`: Rama de Producción (GCP). Contiene el código estable y aprobado.
- `develop`: Rama principal de integración donde se unirán los avances de todos los desarrolladores.
- `HU-#-Nombre`: Ramas específicas para el desarrollo de cada Historia de Usuario (Ej: `HU-1-Tabla-users`, `HU-2-Tabla-categories`).

> **Importante:** El desarrollo **no** se hace en ramas personales con el nombre del desarrollador, sino que por cada tarea asignada se debe crear una rama `HU-#-Nombre` partiendo desde `develop` (o encadenando ramas mediante *Stacked PRs* si dependen del código de otra HU no fusionada).
> 
> Al finalizar una HU, se hace un `git push` a esa rama y se levanta una **Pull Request (PR)** hacia `develop` (o hacia la rama anterior correspondiente) para revisión del equipo.

## ⚙️ Configuración del Entorno Local

Estamos utilizando **Laragon / MAMP** como entorno de desarrollo local. Los servicios por defecto como MySQL funcionan por el puerto estándar (3306). 

### Pasos para levantar el proyecto

**Ruta principal del proyecto:** Una vez que levantes el servidor, la ruta principal a invocar en tu navegador es `http://localhost:8000/` (o la ruta raíz establecida para el Home).

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Nandez117/Urbanvibe-wear.git
   cd Urbanvibe-wear
   ```

2. **Instalar dependencias de PHP y Node:**
   ```bash
   composer install
   npm install
   ```

3. **Configurar las variables de entorno:**
   - Copiar el archivo de ejemplo:
     ```bash
     cp .env.example .env
     ```
   - Las variables globales para base de datos ya vienen preconfiguradas para Laragon/MAMP en el `.env.example`. Asegúrate de que en tu archivo `.env` tengas esta configuración:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=urbanvibe_wear
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   - Generar la clave de la aplicación:
     ```bash
     php artisan key:generate
     ```

4. **Crear la base de datos en tu entorno local:**
   Abre tu gestor de base de datos (HeidiSQL, phpMyAdmin) y crea una base de datos vacía llamada `urbanvibe_wear`.
   ```sql
   CREATE DATABASE urbanvibe_wear;
   ```

5. **Correr las migraciones:**
   ```bash
   php artisan migrate
   ```

6. **Levantar los servidores locales:**
   En terminales separadas, ejecuta:
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

## 🚀 Despliegue en GCP (Google Cloud Platform)

Más adelante, el proyecto se desplegará en la infraestructura de GCP. Para ese momento:
- Se usarán las variables de entorno de producción de GCP.
- La base de datos se migrará a un servicio como Cloud SQL (MySQL).
- El código que se subirá será exclusivamente el que provenga de la rama `main` tras pasar por integración en `develop`.