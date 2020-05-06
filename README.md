# Form and Table Creator @alessandrodesign
[![Maintainer](http://img.shields.io/badge/maintainer-@alessandrodesign-blue.svg?style=flat-square)](https://facebook.com/alessandrodesig.dev)
[![Source Code](http://img.shields.io/badge/source-alessandrodesign/formandtablecreator-blue.svg?style=flat-square)](https://github.com/alessandrodesign/formandtablecreator)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/alessandrodesign/formandtablecreator.svg?style=flat-square)](https://packagist.org/packages/alessandrodesign/formandtablecreator)
[![Latest Version](https://img.shields.io/github/release/alessandrodesign/formandtablecreator.svg?style=flat-square)](https://github.com/alessandrodesign/formandtablecreator/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/alessandrodesign/formandtablecreator.svg?style=flat-square)](https://scrutinizer-ci.com/g/alessandrodesign/formandtablecreator)
[![Quality Score](https://img.shields.io/scrutinizer/g/alessandrodesign/formandtablecreator.svg?style=flat-square)](https://scrutinizer-ci.com/g/alessandrodesign/formandtablecreator)
[![Total Downloads](https://img.shields.io/packagist/dt/alessandrodesign/formandtablecreator.svg?style=flat-square)](https://packagist.org/packages/alessandrodesign/formandtablecreator)

###### Form and table creator

Criador de formulários e tabelas

## About AlessandroDESIGN

###### Developer looking to create tools to maximize web application development time

Desenvolvedor que busca criar ferramentas para maximizar o tempo de desenvolvimento de aplicações web

## Installation

Form and Table Creator is available via Composer:

```bash
"alessandrodesign/formandtablecreator": "dev-master"
```

or run

```bash
composer require alessandrodesign/formandtablecreator
```

## Documentation

###### For details on how to use the Form and Table, see the sample folder with details in the component directory

Para mais detalhes sobre como usar o Form and Table, veja a pasta de exemplo com detalhes no diretório do componente


#### connection

###### To start using Form and Table we need to instantiate the object by defining adding an array with the settings

Para começar a usar o Form and Table precisamos instanciar o objeto definindo adicionando um array com as configurações

##### Creating a form
Criando um formulário

```php
$configForm = [
        'id' => 'save',
        'name' => 'save',
        'method' => 'POST',
        'class' => 'row'
    ];
    
    $form = new CreateForm($configForm);
```

##### Creating a table
Criando uma tabela

```php
$table = new CreateTable(
        [
            'id' => 'table',
            'class' => 'table table-hover'
        ],
        'div',
        ['class' => 'table-responsive']
    );
```
