# Cyclone - SaaS platform with CMS, Minecraft, ChatBot and more

## 🚀 Current features
- Authentication with [Tymon's JWT Auth](https://github.com/tymondesigns/jwt-auth)
- User's domain basic CRUD features with avatar from third-party API
- Company's domain basic CRUD features with persist/remove Addresses, Departments and Contacts
- Feature tests for User, Company and Auth
- Integration test for User's avatar third-party API

## 📘 Introduction
This is a Laravel project that I have been working on for a while. It is a SaaS platform that I am building for my own use, but I am also sharing it with the community in case someone wants to use it as a base for their own projects.

This project is based on Laravel 9 DDD interpretation by [@Orphail](https://github.com/Orphail). You can find the original repository [here](https://github.com/Orphail/laravel-ddd).

## 📁 Structure particularities

Inside the "src/" directory we will keep our Bounded Contexts, which are the delimitations of around a set of domains that share functionalities and the same ubiquitous language. There is a special Bounded Context that I have named “Common”, where I keep the resources that I will be sharing with many domains, and where I will keep our Laravel-specific logic as an infrastructure detail.

> <sub>By the way, the "src/" directory is somewhat the "app/" directory we are used to in Laravel. I changed its name because I do not feel comfortable working with a folder that shares the name of a conventional Laravel app when this is not.</sub>

Also, I prefer to group the directory structure by domain, contrary to many examples I saw where some authors prefer grouping by layer. For example, a typical structure would be:

```
...
├── Domain
│   ├── User
│   └── Post
├── Application
│   ├── UserRepository
│   ├── PostRepository
│   └── ...
├── Presentation
│   ├── UserController
│   ├── PostController
│   └── ...
├── Infrastructure
│   ├── UserEloquent
│   ├── PostEloquent
│   └── ...
```

While I prefer:

```
...
├── User
│   ├── Domain
│   ├── Application
│   ├── Presentation
│   └── Infrastructure
├── Company
│   ├── Domain
│   ├── Application
│   ├── Presentation
│   └── Infrastructure
...
```

I find it cleaner this way, although it may have repeated directories, I think it is more readable and is better for large applications.

Another aspect of this approach is that we have to break with the MVC pattern. Our controllers will be at the Presentation layer, directly attending to the requests and passing the data to an inner layer, receiving a response and giving it back to the client. The views can be rendered from the controller, as always, although I prefer using a separate frontend app (like Vue, React, Svelte, etc).

This approach also needs to define a specific ServiceProvider for each domain to bind out abstractions to the implementations. These providers will need to be registered in the "config/app.php" file to work.

Finally, what we consider a model in Laravel has been changed to what I called an EloquentModel, which will be an infrastructure detail. This is because Laravel uses an active record pattern for its models, and we want our models to be decoupled from the database, so we cannot put them in the domain. We can still benefit from Eloquent and other features using it inside the Application/Repository/Eloquent implementation while keeping it out of our domain.

## 🧐 What's inside each layer?

Here below will be a brief explanation of what each layer is for and what it should contain. Disclaimer: not every layer should contain all of these concepts, they should have just the ones that are needed.

### 🎯 Domain
This is where we will keep our entities, value objects, exceptions, interfaces, etc. This is the core of our application, and it should be independent of any other layer. It should not know anything about the [Application layer](#-application), the [Presentation layer](#-presentation) or the [Infrastructure layer](#-infrastructure). It should only know about itself and the business rules concerning itself.

- **Model**: These are the main objects of our Domain. Here is where our _**Aggregate Root**_ will be along with other _**Entities**_ and _**Value Objects**_. Any of these doesn't have to represent a database table or model in the MVC Laravel pattern, it should only be a representation of our Domain. They also have to be always in a valid state, so any validations should be done on the constructor (except those involving unique rules, or any other data stored, that should be done in the [Application layer](#-application)).
- **Exception**: Here we will keep our custom Domain exceptions.
- **Repositories**: In this directory, we will store our Repository interfaces, which should be implemented in the [Application layer](#-application).
- **Services**: Our Domain services are classes that will contain the complex business logic of our Domain. We must be careful not to put all logic in here and leave the Domain models with no logic because we would end up having Anemic Domain models (which is an anti-pattern).
- **Policies**: We should store here our restriction policies, regarding the author of the command or query. Our [Application layer](#-application) will use these to decide if the user is authorised to perform the command/query or not.
- **Factories**: These classes are used as a simple way to create our Domain models. They are not mandatory, but they can be useful for testing purposes.

### 📦 Application
In this layer will reside our use cases, our repository implementations and other adapters. Classes and methods on this layer will be called from the [Presentation layer](#-presentation), and they will be the ones that will interact with the [Domain layer](#-domain) and the [Infrastructure layer](#-infrastructure).

- **UseCases**: Here will reside our use cases, distinguishing between _**Commands**_ or actions (which will trigger changes on the Domain but rarely return any value) and _**Queries**_ (which should never perform changes on the Domain and should always return values). These use cases will be the ones that will call the Domain services and repositories.
- **Repositories**: Our repository implementations from the repository interfaces in the [Domain layer](#-domain). These are responsible to interact with the database implementation, and for these examples, I used Laravel Eloquent models (which reside in the [Infrastructure layer](#-infrastructure)) to perform each action.
- **Mappers**: These classes are responsible to map data between different inputs (like Requests, EloquentModels, etc) to/from our Domain models. They have no properties as a DTO would, they are only used to map data.
- **DTOs**: Data Transfer Objects are mainly used to transfer data between layers when our Domain models are not suitable to do it. For example, if we want to return a list of companies but only with the first of their addresses, we need to parse it to a DTO instead of using our Domain model (which would return all the addresses).
- **Exceptions**: Similarly as in our Domain, these are our custom exceptions that will be triggered by classes of the [Application layer](#-application).
- **Providers**: This is where we will keep our ServiceProviders for each Domain. These will be responsible to bind our abstractions to their implementations using Laravel's Service Container. **Any new Provider will need to be registered in the "config/app.php" file**.
- **Jobs**: _Pending_

### 🖥 Presentation
This layer is responsible to attend to the requests from any interface and return a response to the client, and therefore it is the entry point of the domain from an external point of view.

- **API**: We will manage here the requests coming from the external API (if any).
- **CLI**: It should contain any commands executable from the console. Keep in mind that **Laravel commands must be registered in "src/Common/Infrastructure/Laravel/Kernel/Console.php"**)
- **HTTP**: Here is where our controllers and routes will reside. **Laravel routes will have to be then registered in "src/Common/Infrastructure/Laravel/Providers/RouteServiceProvider.php"**).

### 🗄 Infrastructure
Lastly, our Infrastructure layer will contain all the details related to the database, the framework, and any other external service we may use.

- **EloquentModels**: Laravel's Eloquent, along with its QueryBuilder interface, will allow us to create easy and simple queries for our databases. If you are coming from a Laravel background, this should be familiar to you.

## Other considerations

As stated before, this repository has been created and made public for anyone who can find it practical and inspiring. It is a very early concept, so any contributions to improve it are more than welcome.
