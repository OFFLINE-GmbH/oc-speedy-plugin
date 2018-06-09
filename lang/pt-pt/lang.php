<?php return [
    'plugin'   => [
        'name'                       => 'Speedy',
        'description'                => 'Melhora a preformance do teu website',
        'author'                     => 'OFFLINE LLC',
        'manage_settings'            => 'Gerenciar configurações do Speedy ',
        'manage_settings_permission' => 'Pode gerir as configurações do Speedy',
    ],
    'settings' => [
        'quick_hacks'         => 'Correções simples',
        'quick_hacks_comment' => 'Estas correções simples podem ser ativadas sem nenhuma configuração no servidor.',

        'enable_http2'         => 'Ativar HTTP/2 preloading',
        'enable_http2_comment' => 'Link headers para pré-carregar imagens, arquivos CSS e JS são gerados para cada solicitação. Requer um servidor habilitado para HTTP/2.',

        'enable_caching'         => 'Ativar caching',
        'enable_caching_comment' => 'Adiciona data de validade em imagens, fontes, CSS e arquivos JS. (Cuidado: ative esta configuração somente em ambiente de produção para evitar problemas de cache durante o desenvolvimento)',

        'enable_domain_sharding'         => 'Ativar sharding de domínio',
        'enable_domain_sharding_comment' => 'O URL base de todos os links para a pasta do teu tema serão reescrito com outro URL.',

        'enable_domain_sharding_in_debug'         => 'Ativar sharding enquanto modo debug está ativo',
        'enable_domain_sharding_in_debug_comment' => 'Por defeito sharding de domínio só estará ativo quando debug mode estiver desactivo.',

        'domain_sharding_cdn_domain'         => 'Domínio alternativo',
        'domain_sharding_cdn_domain_comment' => 'Todos os ficheiros serão carregados apartir deste URL. Para mais informação lê a caixa à direita.',

        'enable_gzip'         => 'Ativar Gzip',
        'enable_gzip_comment' => 'Os ficheiros são comprimidos usando Gzip. Tem que ter instalado apache mod_gzip no seu servidor.',

        'domain_sharding_section'         => 'Sharding de domínio',
        'domain_sharding_section_comment' => 'Carrega os teus ficheiros de um domínio alternativo. Esta opção é redundante se estiveres a usar HTTP/2.',
    ],
    'sharding' => [
        'info_heading'    => 'Passo necessário para configurar sharding de domínio',
        'info_subheading' => 'Certifica-te que leste isto antes de ativar a configuração!',
        'info_text'       => 'Certifica-te que teu website está acessível por um domínio alternativo. Podes fazer isso criando um registro CNAME para cdn.example.com que aponte para www.example.com. Como alternativa, podes criar um subdomínio que aponte para a mesma pasta raiz do seu domínio principal.',
    ],
];
