# 🌐 Portafolio Web — Edwin Yoner Flores Rupay

Portafolio profesional desarrollado con **Laravel 10**, diseño dark/gold personalizable desde panel de administración.

---

## 🚀 Tecnologías

- **Backend:** Laravel 10, PHP 8.1+
- **Frontend:** Blade, CSS, HTML, Canvas, AOS, Swiper, GSAP, Bootstrap 5
- **Base de datos:** MySQL
- **Autenticación:** Laravel Jetstream + Sanctum
- **Permisos:** Spatie Laravel Permission v6
- **Panel admin:** AdminLTE 3
- **Assets:** Vite

---

## ✨ Características

- Diseño Dark / Light con cambio en tiempo real
- Animación de partículas con nodos multicolor y repulsión al mouse
- Secciones: Inicio, Habilidades, Proyectos, Documentos, Contacto
- Panel de administración completo (CRUD de todas las secciones)
- Colores personalizables desde la BD (paleta dinámica vía CSS variables)
- Formulario de contacto con reCAPTCHA v3 y notificación por email
- Soporte multiidioma ES/EN (preparado, implementación futura)
- Protección con roles y permisos (Admin, Editor, Viewer)

---

## ⚙️ Requisitos

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js >= 18 (solo para compilar assets)
- Extension: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## 🛠️ Instalación Local

```bash
# 1. Clonar el repositorio
git clone https://github.com/edwinyoner/edwin-yoner.git
cd edwin-yoner

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar la BD en .env y migrar
php artisan migrate --seed

# 6. Crear symlink de storage
php artisan storage:link

# 7. Compilar assets
npm run build

# 8. Servidor de desarrollo
php artisan serve
```

---

## 🚀 Despliegue en Producción (cPanel)

```bash
# 1. Subir archivos al servidor (ZIP o Git)

# 2. Instalar dependencias PHP (sin dev)
composer install --no-dev --optimize-autoloader

# 3. Configurar .env de producción
# - APP_ENV=production
# - APP_DEBUG=false
# - Credenciales de BD y mail

# 4. Ejecutar migraciones
php artisan migrate --force

# 5. Crear symlink de storage
php artisan storage:link

# 6. Crear usuario administrador
php artisan db:seed --class=UserSeeder

# 7. Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Permisos de carpetas
chmod -R 755 storage bootstrap/cache
```

---

## 📁 Estructura de Directorios Clave

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Backend/        # Controladores del panel admin
│   │   └── Frontend/       # Controladores del portafolio público
│   ├── Requests/           # Form Requests con validación
│   └── View/Composers/     # BackendDataComposer, PortfolioDataComposer
├── Models/                 # Modelos Eloquent
├── Mail/                   # Mailables (ContactFormSubmitted, NewUserCredentials)
└── Helpers/
    └── PortfolioHelper.php # Helpers globales: portfolio(), profile(), color(), etc.

resources/views/
├── backend/                # Vistas del panel admin (AdminLTE)
└── frontend/               # Vistas del portafolio público
    ├── layouts/app.blade.php
    ├── partials/
    │   ├── header.blade.php
    │   ├── footer.blade.php
    │   └── particles.blade.php
    └── pages/
        ├── home.blade.php
        ├── skills.blade.php
        ├── projects.blade.php
        ├── documents.blade.php
        └── contact.blade.php
```

---

## 🔐 Roles y Permisos

| Rol    | Acceso                              |
|--------|-------------------------------------|
| Admin  | Acceso completo a todo el panel     |
| Editor | CRUD de contenido, sin configuración|
| Viewer | Solo lectura del panel              |

---

## 📧 Variables de Entorno Clave

```env
APP_URL=https://edwin-yoner.com
DB_DATABASE=winnersy_edwin-yoner
MAIL_HOST=mail.edwin-yoner.com
MAIL_FROM_ADDRESS=edwinyoner@edwin-yoner.com
RECAPTCHA_SITE_KEY=tu_site_key
RECAPTCHA_SECRET_KEY=tu_secret_key
```

---

## 👤 Autor

**Edwin Yoner Flores Rupay**
- 🌐 [edwin-yoner.com](https://edwin-yoner.com)
- 📧 edwinyoner@edwin-yoner.com
- 💼 Bach. Ingeniería de Sistemas e Informática

---

## 📄 Licencia

Este proyecto es de uso personal y profesional de Edwin Yoner Flores Rupay.
Todos los derechos reservados © 2025.