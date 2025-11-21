<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Installazione

- Creare database MySQL/MariaDB;
- Creare credenziali utente;
- Rinominare il file .env.example in .env;
- Impostare le credenziali nel file .env;
- Eseguire il comando `composer install`;
- Eseguire il comando `php artisan migrate`;
  - Se necessario, in ambiente di sviluppo, utilizzare il comando `php artisan db:seed --class=Products` per inserire prodotti di esempio;

## Attivazione crontab

> Funziona solo su sistemi Linux. È accessibile via CLI/SSH o, in genere, tramite pannello di controllo dell'hosting.

Per attivare il crontab su un sistema Linux, eseguire il comando `crontab -e` e inserisci il seguente comando:
```shell
* * * * * php /path/to/laravel/artisan schedule:run >> /dev/null 2>&1
```
dove "/path/to/laravel/" è il percorso assoluto del progetto.

Per maggiori informazioni sulla sintassi del comando, vedi https://crontab.guru/.

## Upload e installazione del progetto in produzione

Lato server vanno caricate solo le seguenti cartelle e files:
- app/
- bootstrap/
- config/
- database/
- public/
- resources/
- routes/
- .env
- artisan
- composer.json
- composer.lock

Vanno create le seguenti cartelle vuote:
- storage/
- storage/app
- storage/framework
- storage/logs

Una volta caricato tutto e verificata la configurazione del file `.env`, eseguire il comando:
```shell
composer install --no-dev
```

Per verificare il corretto funzionamento del framework, eseguire il comando:
```shell
php artisan
```

Per verificare il corretto interfacciamento con il database, eseguire il comando:
```shell
php artisan db:monitor
```

Se è OK, esegui il comando:
```shell
php artisan migrate
```
