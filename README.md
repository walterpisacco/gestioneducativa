## Gestión Educativa

<p align="center">
Software para administración de institutos educativos
</p>

[![Build Status](https://travis-ci.org/changeweb/Unifiedtransform.svg?branch=master)](https://travis-ci.org/changeweb/Unifiedtransform)
[![Linux](https://img.shields.io/travis/changeweb/Unifiedtransform/master.svg?label=linux)](https://travis-ci.org/changeweb/Unifiedtransform)
[![Code Climate](https://codeclimate.com/github/changeweb/Unifiedtransform/badges/gpa.svg)](https://codeclimate.com/github/changeweb/Unifiedtransform)
[![Latest release](https://img.shields.io/github/release/changeweb/Unifiedtransform/all.svg)](https://github.com/changeweb/Unifiedtransform/releases)
[![MadeWithLaravel.com shield](https://madewithlaravel.com/storage/repo-shields/1362-shield.svg)](https://madewithlaravel.com/p/unifiedtransform/shield-link)
[![Discord](https://img.shields.io/discord/917848091107946556)](https://discord.gg/8sz6kpup99)

We like to challenge the quality of what we build to make it better. To do so, we try to make the product intuitive, beautiful, and user friendly. Innovation and hard work help to fulfill these requirements. I believe in order to innovate we need to think differently. A few months ago I discovered there was no open source free school management software that met my quality standards. I happen to know a bit of programming so I decided to make one. I also believe that working with more people can push the standard higher than working alone. So I decided to make it open source and free.

## Framework used

- Laravel 8.X
- Bootstrap 5.X


## Server Requirements

- PHP >= 7.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

    ```

## License

GNU General Public License v3.0

## Contribute

100% open source!!

When you contribute to a Github project you agree with this terms of [Github Terms of Service(Contributions Under Repository License)](https://help.github.com/en/articles/github-terms-of-service#6-contributions-under-repository-license).

Since this project is under **GNU General Public License v3.0**, according to Github's Terms of Service all your contributions are also under the same license terms.
Thus you permit the user of this software to use your contribution under the terms of **GNU General Public License v3.0**.



### Pasos paa instalar:
1. Clonar o Bajar e repositorio
3. Renombrar .ev.example a .env Run `cp .env.example .env`.
4. Instalar Librerias composer: composer install
5. Instalar Librerias Node: npm install


7. Corra en el sheel los siguentes comandos:

    ```sh
    :/# composer install
    :/# php artisan key:generate
    :/# php artisan config:cache
    :/# php artisan migrate:fresh --seed
    ```

8. Visite **http://localhost:8080**. con las credenciales de Admin:


