@extends('layouts.app')

@section('page-title',__('main.general.home'))

@section('content')
<div class="row justify-content-center">

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-4">
                <div class="box-shadow-01 d-flex p-2 align-items-center">
                    <div>
                        <i class="fa-regular fa-user fa-4x"></i>
                    </div>
                    <div class="ms-3">
                        <div class="fs-5 text-muted">
                            {{__('main.home.total_producers')}}
                        </div>
                        <div class="fs-3">
                            {{\App\Services\ProducerServices::build()->getTotalCount()}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box-shadow-01 d-flex p-2 align-items-center">
                    <div>
                        <i class="fa-regular fa-map fa-4x"></i>
                    </div>
                    <div class="ms-3">
                        <div class="fs-5 text-muted">
                            {{__('main.home.total_farms')}}
                        </div>
                        <div class="fs-3">
                            {{\App\Services\FarmServices::build()->getTotalFarmCount()}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box-shadow-01 d-flex p-2 align-items-center">
                    <div>
                        <i class="fa-solid fa-map-pin fa-4x"></i>
                    </div>
                    <div class="ms-3">
                        <div class="fs-5 text-muted">
                            {{__('main.home.total_plots')}}
                        </div>
                        <div class="fs-3">
                            {{\App\Services\FarmServices::build()->getTotalPlotCount()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-body">

                        <b>Sobre o sitema para o Teste Técnico:</b>

                        <hr/>

                        <p>
                            Optei por desenvolver um CRUD de produtores junto a um cadastro simples de fazendas e talhões.<br/>
                            Em detalhes dos produtores é possível criar/selecionar uma fazenda e adicionar talhões.<br/>
                            Os talhões podem ser adicionados usando arquivos <b>.shp</b> e suas dependências ou arquivos <b>.geo.json</b>.
                            Para enviar um .shp e necessário selecionar junto todas as dependências para o upload.
                        </p>

                        <p>
                            Como fiz monolítico, para Front End estou utilizando o Livewire que nos trás a possibilidade de usar componentes reativos direto em controladores no Laravel. <br/>
                            O padrão utilizado é MVC, como estamos componentizando com Livewire, os controllers passam a existir para cada componente separadamente, no namespace App\Http\Livewire,
                            enquanto o visual dos componetes são views do blade em views\livewire.
                        </p>

                        <p>
                            Usei Repository para fazer o gerenciamento de todas as transações Modelos <> Banco de Dados. <br/>
                            O uso de Services pode estar exagerado para o comum do padrão, mas optei usar Services para fazer o gerenciamento das entidades. <br/>
                            O ProducersServices segue base SOLID aonde o serviço atende apenas a uma unica entidade / sentido. <br/>
                            O FarmServices já faz o gerenciamento das fazendas e de seus plots. Apenas para termos variações das várias aplicações da Pattern. <br/>
                            Utilizei Builders nos Services para evitar inputs diretos em arrays, e para ficar mais verbosas as ações realizadas.
                        </p>

                        <p>
                            Por padrão o sistema esta em <b>Português do Brasil</b>, mas também esta disponível em <b>Inglês</b>
                        </p>

                        <p>
                            Traduções não esta usando padrões i18n apenas um dicionário simples mesmo do Laravel.
                        </p>

                        <p>
                            Espero que os requisitos tenham sido atendidos e qualquer dúvida estou a disposição!
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
