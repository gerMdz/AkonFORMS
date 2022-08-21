Akonforms Forms for you ministry
========================



Requirements
------------

  * PHP 7.4 or higher;
  * PDO-Mysql PHP extension enabled;
  * In addition to the [usual requirements of a Symfony application][2].

Installation
------------



```bash
git clone https://github.com/gerMdz/akonforms.git
```

#### TODO List
- [ ] Generando entities
  - [X] Address
  - [ ] Trait_article - Pendiente [https://github.com/niallkennedy/open-graph-protocol-tools](https://github.com/niallkennedy/open-graph-protocol-tools)
- [ ] Empezar crud Site
  - [ ] Relación con Address 
- [ ] Empezar crud Ministry
  - [ ] Relación con Address
- [ ] Empezar register y asociación Users- Ministerio
- [ ] Empezar crud Cuestionario
- [ ] Empezar crud Secciones
- [ ] Empezar crud Tipo Preguntas
- [ ] Empezar crud Preguntas
- [ ] Empezar register usuarios distintos de operadores

  




Usage
-----

```bash
$ cd akonforms/
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][3] like Nginx or
Apache to run the application.

Tests
-----

Execute this command to run tests:

```bash
$ cd my_project/
$ ./bin/phpunit
```

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/reference/requirements.html
[3]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[4]: https://symfony.com/download
