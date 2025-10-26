# Proyecto Backend - API REST Laravel
## Descripción General

Este proyecto es una API RESTful desarrollada en Laravel, diseñada para gestionar datos mediante endpoints seguros con autenticación JWT (JSON Web Token).
Incluye validaciones, control de acceso mediante middleware, manejo de errores personalizados y respuestas estandarizadas en formato JSON.

El objetivo es ofrecer una base sólida para cualquier aplicación que requiera autenticación, control de usuarios y administración de recursos desde un backend moderno.

## Tecnologias Utilizadas
- Laravel  12.35.1
- PHP 8.2.12
- MySQL
- Composer
- JWT Auth
- Postman
- XAMPP V3.3.0
- Visual Code

## Instalación y Configuración
Clona el repositorio
`https://github.com/fsiliezar/PointsApi.git`

Instala dependencias
`composer install`

Genera la clave de aplicación y el secreto JWT
`php artisan key:generate`
`php artisan jwt:secret`

Ejecuta las migraciones
`php artisan migrate`

Inicia el servidor
`php artisan serve`

Enlace al iniciar el servidor
`http://localhost:8000`

---
## Endpoints Principales

| Método | Endpoint| Descripción|Protección|
| :------------ |:---------------:| -----:|-----:|
| POST | /api/registro | Registra nuevo usuario | Pública
| POST | /api/login |Iniciar sesión y obtener token |Pública
| POST | /api/points | Crea un nuevo punto georeferencia |JWT
| GET | /api/points?tipo=accidente| Lista todos los puntos, con filtros por tipo o ubicación |JWT
| GET | /api/points/{id} | Obtener datos de un punto georeferencia|JWT
| PUT |/api/points/{id} | Actualiza un punto georeferencia existente |JWT
| DELETE |/api/points/{id} | Elimina un punto georeferencia |JWT
---
## Ejemplo de Flujo de Autenticación

Registro de usuario: POST /api/registro

    {
	   "username": "fsiliezar",
	   "email": "fsiliezar@gmail.com",
	   "password": "pruebas123"
	}

Inicio de sesión: POST /api/login

    {
	   "username": "fsiliezar",
	   "password": "pruebas123"
	}

Registro de points: POST /api/points

    {
	   "latitud": 89.58256,
	   "longitud": -89.2182,
	   "tipo": "congestion",
	   "descripcion": "Atasco en carretera"
	}
Actualización de points: PUT /api/points/{id}

    {
	   "latitud": 83.58256,
	   "longitud": -49.2182,
	   "tipo": "otro",
	   "descripcion": "Atasco en carretera"
	}
Obtener  points: GET /api/points/

    {
        "id": 3,
		"latitud": "89.5826",
		"longitud": "-89.2182",
        "tipo": "congestion",
        "descripcion": "Atasco en carretera",
        "user_id": 1,
        "created_at": "2025-10-26T07:17:34.000000Z",
        "updated_at": "2025-10-26T07:17:34.000000Z",
		            "user": {
                					"id": 1,
                					"username": "fsiliezar",
                					"email": "fsiliezar@gmail.com",
                					"created_at": "2025-10-26T07:12:24.000000Z",
                					"updated_at": "2025-10-26T07:12:24.000000Z"
								}
	}
Eliminar de points: DELETE /api/points/{id}

    {
	       "message": "Point eliminado"
	}
---
## Autor
Francisco Siliezar
Desarrollador Backend
