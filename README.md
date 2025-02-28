<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Estado de compilación"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Descargas totales"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Versión estable más reciente"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licencia"></a>
</p>

## Acerca de CRUD Laravel

Este es un sistema CRUD desarrollado en Laravel, que permite la gestión de:

- Clientes
- Facturas
- Proveedores
- Direcciones
- Cartilla
- Apuntes
- Recibos

https://github.com/user-attachments/assets/46702b94-b505-45e4-82d4-f70b8db42891

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/AimedCh/crudlaravel.git
   cd crudlaravel
   ```

2. Instalar dependencias de PHP y Node.js:
   ```bash
   composer install
   npm install
   ```

3. Configurar el archivo de entorno `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=crud_laravel
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Ejecutar migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```

5. Iniciar el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

6. Compilar los assets con Vite:
   ```bash
   npm run dev
   ```

## Documentación y Aprendizaje

Para aprender más sobre Laravel, consulta la [documentación oficial](https://laravel.com/docs) o el [Laravel Bootcamp](https://bootcamp.laravel.com).

## Contribuir

Gracias por considerar contribuir a este proyecto. Revisa la [guía de contribución](https://laravel.com/docs/contributions) para más detalles.

## Seguridad

Si encuentras alguna vulnerabilidad de seguridad, por favor repórtala enviando un correo a [Taylor Otwell](mailto:taylor@laravel.com).

## Licencia

Este proyecto está licenciado bajo la [Licencia MIT](https://opensource.org/licenses/MIT).

