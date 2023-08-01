<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## O sistema deste repositório foi desenvolvido usando Laravel

## Instalação

Estamos usando Laravel 10 (+ Vite) com PHP 8.1.

após o clone, instalar dependência com composer

(Algumas libs usadas tem o marcador de versão do PHP de uma interpretação antiga do composer, fazendo com que considerem o php 8.1 inválido para ^7.4, o que é bizarro hehe)

> composer install --ignore-platform-reqs

> npm install

> npm run build

O sistema possui migrations conforme solicitado, e também adicionei seeders para pré cadastrar 50 protudores e o usuário admin padrão.

> php artisan migrate

> php artisan db:seed

## Acesso

O e-mail inicial é: demo@admin.com
Senha inicial é: 123456

O fluxo de esqueci a senha / alteração de senha esta funcional, basta configurar o .env com um servidor de e-mail válido.

## Sobre o sistema

Optei por desenvolver um CRUD de produtores junto a um cadastro simples de fazendas e talhões.
Em detalhes dos produtores é possível criar/selecionar uma fazenda e adicionar talhões.
Os talhões podem ser adicionados usando arquivos .shp e suas dependências ou arquivos .geo.json. Para enviar um .shp e necessário selecionar junto todas as dependências para o upload.

Como fiz monolítico, para Front End estou utilizando o Livewire que nos trás a possibilidade de usar componentes reativos direto em controladores no Laravel.
O padrão utilizado é MVC, como estamos componentizando com Livewire, os controllers passam a existir para cada componente separadamente, no namespace App\Http\Livewire, enquanto o visual dos componetes são views do blade em views\livewire.

Usei Repository para fazer o gerenciamento de todas as transações Modelos <> Banco de Dados.
O uso de Services pode estar exagerado para o comum do padrão, mas optei usar Services para fazer o gerenciamento das entidades.
O ProducersServices segue base SOLID aonde o serviço atende apenas a uma unica entidade / sentido.
O FarmServices já faz o gerenciamento das fazendas e de seus plots. Apenas para termos variações das várias aplicações da Pattern.
Utilizei Builders nos Services para evitar inputs diretos em arrays, e para ficar mais verbosas as ações realizadas.

Por padrão o sistema esta em Português do Brasil, mas também esta disponível em Inglês

Traduções não esta usando padrões i18n apenas um dicionário simples mesmo do Laravel.

Espero que os requisitos tenham sido atendidos e qualquer dúvida estou a disposição!
