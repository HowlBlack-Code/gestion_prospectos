# 📞 Aplicación ABMC - Gestión de Prospectos

## 📌 Temática

La temática elegida es la **Gestión de Prospectos Contactados** para un centro de atención telefónica o contact center. Esta aplicación permite realizar operaciones básicas sobre los registros de prospectos que han sido contactados por agentes.

---

## 🧩 Descripción general

La aplicación permite:

- **A**lta: Agregar nuevos prospectos.
- **B**aja: Eliminar prospectos con confirmación.
- **M**odificación: Editar datos existentes.
- **C**onsulta: Listar prospectos ordenados por fecha de contacto.

Está desarrollada en PHP con conexión a una base de datos MySQL, utilizando Bootstrap para los estilos y validaciones básicas con JavaScript.

---

## ⚙️ Instrucciones de instalación y configuración

### ✅ Requisitos

- PHP >= 7.4
- MySQL o MariaDB
- Servidor web local (XAMPP, Laragon, etc.)
- Composer (opcional)

---

### 🛠️ Crear la base de datos y tabla

1. Iniciar phpMyAdmin o consola MySQL.
2. Ejecutar el siguiente script para crear la base y la tabla:

```sql
CREATE DATABASE gestion_prospectos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE gestion_prospectos;

CREATE TABLE prospectos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  telefono VARCHAR(20),
  email VARCHAR(100),
  producto_interes VARCHAR(100),
  estado_contacto VARCHAR(50),
  fecha_contacto DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

### ⚙️ Configurar el archivo `.env`

1. Renombrar el archivo `.env.example` a `.env`.
2. Completar los datos de conexión a la base de datos:

```env
DB_HOST=localhost
DB_NAME=gestion_prospectos
DB_USER=tu_usuario
DB_PASS=tu_contraseña
```

---

### 🚀 Ejecutar la aplicación

Podés correr la app de dos formas:

#### Opción 1: Usando el servidor embebido de PHP

```bash
php -S localhost:8000
```

Luego, accedé desde tu navegador a: [http://localhost:8000](http://localhost:8000)

#### Opción 2: Usando Laragon o XAMPP

1. Colocar el proyecto en la carpeta `www` o `htdocs`.
2. Configurar un host virtual (opcional).
3. Iniciar Apache y MySQL desde el panel.
4. Acceder vía navegador a [http://localhost/gestion-prospectos](http://localhost/gestion-prospectos)

---

## 📎 Archivos importantes

- `index.php`: Lista de prospectos
- `agregar.php`: Formulario de alta
- `editar.php`: Formulario de edición
- `eliminar.php`: Baja con confirmación
- `.env.example`: Plantilla para configuración
- `composer.json`: Dependencias (si las agregás)

---

¡Listo! Ya tenés todo para arrancar con tu propio sistema ABMC 🎯
