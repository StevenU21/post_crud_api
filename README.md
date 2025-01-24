# 📚 Laravel API CRUD - Posts

Este proyecto es una API desarrollada con **Laravel 11** que implementa un CRUD (Crear, Leer, Actualizar, Eliminar) para manejar publicaciones (**Posts**). A continuación, se describe el funcionamiento, configuración e instrucciones para trabajar con esta API.

## 🚀 Características principales

- **CRUD completo:** Operaciones para crear, leer, actualizar y eliminar publicaciones.
- **Validación robusta:** Regla personalizada para validar datos en el request.
- **Respuestas JSON estructuradas:** Uso de `PostResource` para formatear las respuestas.
- **Paginación integrada:** Los resultados están paginados con un límite de 10 publicaciones por página.
- **Rutas organizadas:** Agrupadas bajo el prefijo `/posts`.

## 📂 Estructura del controlador

El controlador principal es `PostController`, que incluye las siguientes acciones:

### 1. Listar publicaciones
```php
public function index(): AnonymousResourceCollection
```
- **Descripción:** Recupera una lista paginada de publicaciones.
- **Endpoint:** `GET /posts`
- **Respuesta:**
  ```json
  {
    "data": [...],
    "links": {...},
    "meta": {...}
  }
  ```

### 2. Mostrar una publicación específica
```php
public function show(int $id): PostResource
```
- **Descripción:** Recupera los detalles de una publicación específica por su ID.
- **Endpoint:** `GET /posts/{id}/show`
- **Respuesta:**
  ```json
  {
    "id": 1,
    "title": "Sample Title",
    "content": "Sample Content",
    ...
  }
  ```

### 3. Crear una publicación
```php
public function store(PostRequest $request): PostResource
```
- **Descripción:** Crea una nueva publicación.
- **Endpoint:** `POST /posts`
- **Cuerpo requerido:**
  ```json
  {
    "title": "Required String (6-40 chars)",
    "content": "Required String (6-255 chars)"
  }
  ```
- **Respuesta:** La publicación recién creada en formato JSON.

### 4. Actualizar una publicación
```php
public function update(PostRequest $request, int $id): PostResource
```
- **Descripción:** Actualiza una publicación existente por su ID.
- **Endpoint:** `PUT /posts/{id}/update`
- **Cuerpo requerido:** Igual que el método `store`.
- **Respuesta:** La publicación actualizada en formato JSON.

### 5. Eliminar una publicación
```php
public function destroy(int $id): JsonResponse
```
- **Descripción:** Elimina una publicación existente por su ID.
- **Endpoint:** `DELETE /posts/{id}/destroy`
- **Respuesta:** Código de estado 204 sin contenido.

## ✅ Validación

La validación de las solicitudes está gestionada por `PostRequest`. Las reglas son:

- **`title`:** Requerido, cadena de texto, mínimo 6 caracteres, máximo 40 caracteres, único.
- **`content`:** Requerido, cadena de texto, mínimo 6 caracteres, máximo 255 caracteres.

Código de las reglas:
```php
public function rules(): array
{
    return [
        'title' => ['required', 'string', 'min:6', 'max:40', Rule::unique('posts')->ignore($this->post)],
        'content' => ['required', 'string', 'min:6', 'max:255'],
    ];
}
```

## 🌐 Rutas

Las rutas de esta API están definidas en `routes/api.php`:

```php
Route::prefix('/posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/{post}/show', [PostController::class, 'show'])->name('posts.show');
    Route::post('/', [PostController::class, 'store'])->name('posts.store');
    Route::put('/{post}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');
});
```

## 🔧 Instalación y configuración

Sigue estos pasos para configurar el proyecto localmente:

1. Clona el repositorio:
   ```bash
   git clone https://github.com/StevenU21/post_crud_api.git
   ```

2. Instala las dependencias:
   ```bash
   composer install
   ```

3. Copia el archivo `.env.example` y configúralo:
   ```bash
   cp .env.example .env
   ```

4. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

5. Ejecuta las migraciones:
   ```bash
   php artisan migrate 
   ```

6. Ejecuta las seeds:
   ```bash
   php artisan db:seed
   ```

## 🧪 Pruebas

Ejecuta las pruebas para verificar el funcionamiento del proyecto:

```bash
php artisan test
```
