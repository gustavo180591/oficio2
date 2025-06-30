# Sistema de Gestión de Oficios

[![Symfony](https://img.shields.io/badge/Symfony-6.x-000000.svg?style=flat&logo=symfony)](https://symfony.com/)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4.svg?style=flat&logo=php&logoColor=white)](https://php.net/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg?style=flat&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)

Sistema web para la gestión de oficios, registros y seguimiento de documentación institucional.

## 🚀 Características Principales

- **Gestión de Oficios**: Publicación y seguimiento de oficios institucionales.
- **Registros Públicos**: Los usuarios pueden publicar sus oficios sin necesidad de credenciales.
- **Delegaciones**: Administración de diferentes delegaciones o departamentos.
- **Comentarios**: Sistema de comentarios para seguimiento de documentos.
- **Diseño Responsive**: Interfaz adaptada para dispositivos móviles y de escritorio.
- **Panel de Administración**: Acceso exclusivo para administradores con credenciales.
- **Sistema Simple**: Solo un rol de administrador para la gestión del sistema.

## 🛠️ Requisitos Técnicos

- PHP 8.1 o superior
- Composer
- MySQL 8.0 o superior
- Node.js y NPM (para assets)
- Symfony CLI

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/gustavo180591/oficio2.git
   cd oficio2
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno**
   ```bash
   cp .env .env.local
   # Editar .env.local con tus credenciales
   ```

4. **Crear base de datos**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
   ```

5. **Instalar assets**
   ```bash
   npm install
   npm run build
   ```

6. **Iniciar el servidor**
   ```bash
   symfony server:start
   ```

## 🐳 Docker (Opcional)

El proyecto incluye configuración para Docker:

```bash
docker-compose up -d
```

## 📦 Estructura del Proyecto

```
oficio2/
├── assets/             # Assets (JS, CSS, imágenes)
├── config/             # Configuración de la aplicación
├── migrations/         # Migraciones de base de datos
├── public/             # Archivos públicos
├── src/                # Código fuente PHP
│   ├── Controller/     # Controladores
│   ├── Entity/         # Entidades de Doctrine
│   ├── Form/           # Formularios
│   └── Repository/     # Repositorios de datos
├── templates/          # Plantillas Twig
└── tests/              # Pruebas automatizadas
```

## 🔒 Variables de Entorno

Crea un archivo `.env.local` con las siguientes variables:

```env
APP_ENV=dev
APP_SECRET=tu_secreto_aqui
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/oficio2?serverVersion=8.0&charset=utf8mb4"
MAILER_DSN=smtp://localhost:1025
```

## 📝 Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor, lee nuestras [pautas de contribución](CONTRIBUTING.md) antes de enviar un pull request.

## 📧 Contacto

- **Email**: [tu@email.com](mailto:tu@email.com)
- **Sitio Web**: [https://tusitio.com](https://tusitio.com)

---

<p align="center">
  Hecho con ❤️ por Gustavo
</p>
