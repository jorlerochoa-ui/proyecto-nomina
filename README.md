# Sistema de Liquidación de Nómina

## Presentación

Cordial saludo.

De manera muy cordial, solicito la revisión del presente desarrollo teniendo en cuenta los siguientes aspectos considerados durante la implementación de la solución:

### 1. Uso de lenguajes de programación puros

Para la realización de la prueba se utilizó **PHP PURO** y **JavaScript PURO**, evitando el uso de frameworks tanto en backend como en frontend, con el propósito de resaltar la aplicación de los principios fundamentales de programación, la lógica implementada y la comprensión del funcionamiento interno de cada proceso.

### 2. Aplicación de fundamentos de programación

La solución fue desarrollada aplicando conceptos como programación orientada a objetos, validación de datos, manejo de estructuras de control, separación de responsabilidades y organización del código, permitiendo una implementación clara y mantenible.

### 3. Estructura y organización del desarrollo

Se realizó una separación de responsabilidades mediante una estructura basada en modelos, controladores y rutas, buscando mantener una organización similar a los patrones utilizados actualmente en el desarrollo de aplicaciones web.

### 4. Adaptación del lenguaje de implementación

Aunque la prueba fue inicialmente planteada para desarrollarse en Delphi, se realizó la implementación utilizando PHP y JavaScript, teniendo en cuenta la posibilidad de utilizar otros lenguajes de programación y aplicando los mismos principios lógicos requeridos para la solución del problema.

### 5. Análisis del requerimiento y control de liquidaciones duplicadas

Como parte del análisis del requerimiento, se realizó una ampliación en la gestión de los campos **semana** y **período**, permitiendo identificar de manera más precisa cada liquidación realizada.

Esta validación fue implementada con el objetivo de evitar que un mismo empleado pueda tener múltiples liquidaciones registradas para una misma semana dentro de un mismo período, garantizando la integridad de la información y evitando duplicidad de registros.

---

# Tecnologías utilizadas

## Backend

- **PHP PURO**
- Programación orientada a objetos (POO)
- Arquitectura basada en:
  - Modelos
  - Controladores
  - Rutas

## Frontend

- **JavaScript PURO**
- HTML5
- CSS
- Bootstrap para componentes visuales

## Base de datos

- **MySQL**

La aplicación utiliza MySQL para el almacenamiento de:

- Empleados
- Cargos
- Liquidaciones semanales

---

# Requisitos para ejecutar el proyecto

Para visualizar y ejecutar correctamente la aplicación se requiere un entorno con servidor web y base de datos.

## Opción recomendada

Instalar:

- **XAMPP**, el cual incluye:
  - Apache (Servidor web)
  - MySQL (Motor de base de datos)
  - PHP (Lenguaje backend)

También es posible utilizar cualquier servidor compatible con:

- Apache o Nginx
- PHP 8.x o superior
- MySQL 8.x o compatible

---

# Instalación y configuración

## 1. Ubicar el proyecto

Copiar la carpeta del proyecto dentro del directorio público del servidor Apache.

En XAMPP:
