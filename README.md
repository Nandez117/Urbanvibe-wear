# Urbanvibe-wear 👕👟

**Urbanvibe-wear** es una plataforma moderna de comercio electrónico enfocada en la venta de ropa y calzado urbano. Nuestro objetivo es ofrecer una experiencia de compra ágil, segura y con una interfaz de usuario atractiva para los amantes del estilo urbano.

### 👥 Integrantes del Equipo:
- YanF
- JuanM
- EstebanA

---

## 🌿 Ramas del Repositorio

El flujo de trabajo se manejará en base a las siguientes ramas principales:
- `main`: Producción (GCP).
- `develop`: Rama principal de integración donde se unirán los avances de todos.
- `YanF`: Rama de desarrollo de YanF.
- `JuanM`: Rama de desarrollo de JuanM.
- `EstebanA`: Rama de desarrollo de EstebanA.

> **Importante:** Cada desarrollador debe trabajar siempre en su rama (ej. `git checkout YanF`), hacer sus commits ahí y luego crear un Pull Request hacia `develop` para revisión y pruebas conjuntas.

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

7. **Estandarización de Código:**
   El proyecto utiliza **[Laravel Pint](https://laravel.com/docs/pint)** (un formateador de código estricto para PHP). 
   Debes ejecutarlo **siempre desde la ruta raíz del proyecto** antes de hacer un commit:
   ```bash
   ./vendor/bin/pint
   ```

## 🚀 Despliegue en GCP (Google Cloud Platform)

Más adelante, el proyecto se desplegará en la infraestructura de GCP. Para ese momento:
- Se usarán las variables de entorno de producción de GCP.
- La base de datos se migrará a un servicio como Cloud SQL (MySQL).
- El código que se subirá será exclusivamente el que provenga de la rama `main` tras pasar por integración en `develop`.