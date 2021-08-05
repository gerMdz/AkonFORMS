## Welcome to AkonFORMS
## Le doy la bienvenida a AkonFORMS

### ¿Que soluciona AkonFORM?

Los datos son suyos y puede cambiar las cosas según lo necesite, modificando reportes, visualizaciones, y demás detalles que le parezcan importantes.
Alternativa simple a Google Docs y Microsoft Docs.

### Etapa

Aún estamos en desarrollo, y nada es funcional aún, pero las pruebas son prometedoras y se pueden ir agregando más cosas.


### Idea
    
    Poder crear formularios a partir de tipos simples de campos
    
    
#### Tipos de campos
    
    Date
    DateTIme
    Checkboxs
    Radiobutton
    Text
    Textarea
    Numeric
  
#### Jerarquías
    
    Cuestionario > Sección > Pregunta > ValorRespuesta
 
#### Manejo de usuarios 
  
    Los roles de los usuarios estarán divididos en
    ROLE_SITE -> Manger del site,
    ROLE_ADMIN -> Manager de la aplicación,
    ROLE_PROPERTY -> Manager de los Cuestionarios
    ROLE_USER -> Editor de los cuestionarios
    
##### ¿Cómo lo obtengo?

Para usar AkonFORMS debes bajarlo de [github][8], y luego bajar sus dependencias de paquetes. 

```
git clone https://github.com/gerMdz/AkonFORMS.git
cd project
composer install
yarn install 
```
Requerimientos
------------

* PHP 7.2.9 o superior;
* PDO-SQLite PHP extension enabled (o el PDO para tu base de datos);
* y los [usuales requerimientos de una aplicación Symfony][2].

Uso
-----

Las configuraciones básicas son 
* la URL de su base de datos ej.:
   * DATABASE_URL=mysql://user:pass@host:port/db_name 
* el DSN de su servidor smtp de correos
  * MAILER_DSN=smtp://localhost
     
Luego con el binario de [Symfony][4], ejecute los siguientes comandos que crearan los datos básicos de usuarios y un contenido de inicio:

```bash
$ php bin/console doctrine:fixtures:load
$ symfony serve -d
```

Luego acceda a la aplicación en su navegador con la URL dada (<https://127.0.0.1:8000> generalmente).

Si no tiene instalado el binario de Symfony, ejecute `php -S localhost:8000 -t public/`
para utilizar el servidor web PHP incorporado o [configure un servidor web][3] como Nginx o
Apache para ejecutar la aplicación.

 

##### Contacto

Si tienes problemas con AkonFOMRS? puedes enviarme un mail a [gerardo.montivero@gmai.com](mailto:gerardo.montivero@gmail.com) o crear una [issue](https://github.com/gerMdz/AkonFORMS/issues)

Mi perfil [gerMdz](https://github.com/gerMdz)

#### AkonFORMS se base en
- [Symfony][1] framework PHP.
- [Bootstrap](https://getbootstrap.com/) plantillas.
- [FontAwesome](https://fortawesome.github.io/Font-Awesome/) icons.

Con licencia [MIT](https://github.com/gerMdz/AkonFORMS/blob/main/LICENSE)

Uso [PhpStorm][5] 


[1]: https://symfony.com
[2]: https://symfony.com/doc/current/reference/requirements.html
[3]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://jb.gg/OpenSource.
[6]: https://github.com/gerMdz/payunpile
[7]: https://germdz.github.io/incalinks/
[8]: https://github.com/gerMdz/AkonFORMS.git
    
