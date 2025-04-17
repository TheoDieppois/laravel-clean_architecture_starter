# Clean Architecture Laravel – Test Project

## 🔍 Description

Ce projet est une **implémentation de test** de la Clean Architecture dans un contexte **Laravel**.  
L’objectif est de démontrer une séparation claire entre :

-   Le **domaine métier** (entités, value objects, contrats)
-   La **logique applicative** (cas d’usage, DTO, mappers)
-   L’**infrastructure** (persistence, Eloquent, stockage fichier)
-   L’**interface HTTP** (controllers, FormRequests)

---

## 📂 Structure du projet

```text
app/
├── Application/
│   └── Todo/
│       ├── DTO/
│       │   ├── CreateTodoInput.php
│       │   └── TodoOutput.php
│       ├── Mappers/
│       │   ├── TodoInputMapper.php
│       │   └── TodoOutputMapper.php
│       └── UseCases/
│           ├── CreateTodo.php
│           ├── FindTodo.php
│           ├── ListTodos.php
│           ├── CompleteTodo.php
│           └── DeleteTodo.php
│
├── Domain/
│   └── Todo/
│       ├── Entity/
│       │   └── Todo.php
│       ├── ValueObject/
│       │   └── TodoId.php
│       └── Repository/
│           └── TodoRepository.php
│
├── Http/
│   ├── Controllers/
│   │   └── TodoController.php
│   └── Requests/
│       └── CreateTodoRequest.php
│
├── Infrastructure/
│   └── Persistence/
│       └── Todo/
│           ├── Eloquent/
│           │   ├── Mappers/
│           │   │   ├── EntityToTodoModel.php
│           │   │   └── TodoModelToEntity.php
│           │   ├── Models/
│           │   │   └── TodoModel.php
│           │   └── EloquentTodoRepository.php
│           └── File/
│               └── FileTodoRepository.php
│
└── Providers/
    └── AppServiceProvider.php

tests/
├── Unit/
│   └── Todo/
│       ├── Domain/
│       │   ├── TodoIdTest.php
│       │   └── TodoTest.php
│       ├── Mappers/
│       │   ├── EntityToTodoModelTest.php
│       │   ├── TodoInputMapperTest.php
│       │   ├── TodoModelToEntityTest.php
│       │   └── TodoOutputMapperTest.php
│       └── UseCases/
│           ├── CompleteTodoTest.php
│           ├── CreateTodoTest.php
│           ├── DeleteTodoTest.php
│           ├── FindTodoTest.php
│           └── ListTodosTest.php
└── Integration/
    └── Todo/
        └── EloquentTodoRepositoryTest.php
        └── FileTodoRepositoryTest.php
```

## 🛠️ Points centraux

### 1. DTO (Data Transfer Object)

-   **Rôle** : transport de données entre les couches sans exposer vos entités.
-   **Exemple** : `CreateTodoInput` reçoit les champs validés de la requête HTTP.
-   **Avantage** : découplage fort, validation et mapping explicites.

### 2. Mappers

-   **Rôle** : convertir un DTO en Entity (ou vice versa), ou Entity ↔ Model Eloquent.
-   **Exemple** : `TodoInputMapper::toEntity(CreateTodoInput $dto): Todo`.
-   **Avantage** : centralisation de la logique de transformation.

### 3. Use Cases (Cas d’usage)

-   **Rôle** : encapsuler chaque opération métier (« créer un todo », « lister les todos », …).
-   **Entrée** : un DTO (input), sortie : un DTO (output) ou void.
-   **Avantage** : tests unitaires ultra‑simples en mockant le repository.

### 4. Domain — Entities & Value Objects

-   **Entity** : objet métier (ici `Todo`) avec son identité et ses comportements.
-   **Value Object** : objet immutable pour des concepts (e.g. `TodoId`).
-   **Contract** : interface `TodoRepository` dans le domaine, sans dépendance à Laravel.

### 5. Infrastructure — Persistence

-   Pattern Repository + Data Mapper :
    -   EloquentTodoRepository : implémentation via Eloquent ORM.
    -   FileTodoRepository : stockage simple dans un fichier.
-   Organisation par agrégat : tout le code persistence de “Todo” dans `Infrastructure/Persistence/Todo`.

### 6. HTTP — Controllers & Requests

-   Controller (`TodoController`) : orchestration des Use Cases.
-   FormRequest (`CreateTodoRequest`) : encapsule la validation HTTP.

### 7. ServiceProvider

Dans `AppServiceProvider`, on bind l’interface du repository à son implémentation :

```php
$this->app->bind(
  App\Domain\Todo\Repository\TodoRepository::class,
  App\Infrastructure\Persistence\Todo\Eloquent\EloquentTodoRepository::class
);
```

## ✅ Politique de tests

1. Unitaires (domaine & use cases)

-   Mock du repository pour tester la logique métier pure.

2. Intégration (infrastructure)

-   Vérifier que `EloquentTodoRepository` persiste vraiment en base (ou que `FileTodoRepository` écrit bien).

## 🚀 Démarrage

1. `composer install`

2. Configurer `.env`

3. `php artisan migrate`

4. Lancer les tests :

```bash
vendor/bin/phpunit
```
