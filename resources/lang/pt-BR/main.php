<?php

return [

    'general' => [
        'loading' => 'carregando',
        'home' => 'Início',
        'logout' => 'Sair',
        'actions' => [
            'details' => 'Detalhes',
            'edit' => 'Editar',
            'delete' => 'Remover',
            'save' => 'Salvar',
            'cancel' => 'Cancelar',
            'close' => 'Fechar',
            'confirm' => 'Confirmar'
        ],
        'validation' => [
            'type_something' => 'Você precisa informar algo.'
        ]
    ],
    'auth' => [
        'email' => "E-mail",
        'password' => "Senha",
        'confirm_password' => "Confirmar Senha",
        'reset_password_action' => "Alterar Senha",
        'login' => "Login",
        'forgot_password' => "Esqueceu sua senha?",
        'messages' => [
            'required_mail' => "O campo e-mail é obrigatório.",
            'required_password' => "Você precisa informar sua senha.",
            'invalid_mail' => "E-mail inválido.",
            'min_password' => "Senhas possuem mais de 8 caracteres."
        ],
        'invalid_credentials' => "E-mail ou senha inválidos",
        'reset_password' => [
            'title' => 'Alterar senha',
            'instructions' => "Informe seu endereço de e-mail e enviaremos um link para a alteração de sua senha.",
            'reset_instructions' => "Confirme seu endereço de e-mail e informe sua nova senha.",
            'default_email_error' => "Por favor, verifique se o e-mail pertence a um usuário ativo.",
            'default_password_error' => "Senhas precisam ter ao menos 8 caracteres e ser confirmada.",
            'send_password_link' => "Enviar link de alteração de senha",
        ]
    ],
    'localization' => [
        'switcher_error' => "Erro ao alterar o idioma, tente novamente mais tarde."
    ],
    'producers' => [
        'title' => 'Gerenciar Produtores',
        'detail_title' => 'Detalhes do Produtor',
        'filters' => [
            'search' => 'Procurar',
            'producer_type'=> 'Tipo do Produtor',
            'any' => 'Qualquer',
            'individual' => 'Pessoa Física',
            'collective' => 'Pessoa Jurídica'
        ],
        'actions' => [
            'new_producer' => 'Novo Produtor',
            'edit_producer' => 'Editar Produtor'
        ],
        'table' => [
            'company_name' => 'Razão Social',
            'trade_name' => 'Nome Fantasia',
            'social_number' => 'CPF/CNPJ',
            'phone' => 'Telefone',
            'localization' => 'Localização',
            'state' => 'Estado',
            'city' => 'Cidade',
            'state_registration' => 'Inscrição Estadual'
        ],
        'created' => 'Produtor criado com sucesso',
        'updated' => 'Produtor atualizado com sucesso',
        'to_remove' => 'Você tem certeza que deseja remover :producer ?',
        'removed' => 'Produtor removido com sucesso'
    ],
    'farms' => [
        'title' => 'Fazendas',
        'creating_alert' => 'Você pode adicionar contornos e talhões na fazenda após a criação.',
        'select_alert' => 'Selecione uma fazenda no menu a esquerda',
        'filters' => [
            'search' => 'Filtrar'
        ],
        'actions' => [
            'new_farm' => 'Nova Fazenda',
            'edit_farm' => 'Editar Fazenda',
            'remove_farm' => 'Remover Fazenda'
        ],
        'table' => [
            'name' => 'Nome da fazenda',
        ],
        'created' => 'Fazenda criada com sucesso',
        'updated' => 'Fazenda criada com sucesso',
        'to_remove' => 'Tem certeza que deseja remover :farm ?',
        'removed' => 'Fazenda removida com sucesso'
    ],
    'plot' => [
        'actions' => [
            'new_plot' => 'Adicionar Talhão',
            'remove_plot' => 'Remover Talhão',
            'select_plot' => 'Selecione um Talhão'
        ],
        'form' => [
            'identification' => 'Nome ou Referência',
            'file' => 'Carregue um arquivo .geo.json ou .shp com suas dependências .shx .prj e .dbf',
            'file_field' => 'Arquivo Referência',
            'invalid_file' => 'Arquivo de talhão inválido, verifique se é .geo.json válido ou se o .shp foi carregado com suas dependências'
        ],
        'created' => 'Talhão adicionado com sucesso',
        'to_remove' => 'Tem certeza que deseja remover :plot ?',
        'removed' => 'Talhão removido com sucesso',
        'no_loaded' => 'Selecione um talhão para ser exibido no mapa',
        'invalid_map_load' => "Parece que não conseguimos renderizar o arquivo geojson, tente remover o talhão e adicionar outro."
    ],

];
