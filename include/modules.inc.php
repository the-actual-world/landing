<?php

$formats = [
  'date' => 'd/m/Y',
  'datetime' => 'd/m/Y H:i:s',
  'time' => 'H:i:s'
];

// o meu esquema para os módulos é o seguinte:
$example_modules_structure = [
  'table_name' => [
    'name' => 'Nome da Tabela',
    'icon' => 'fa fa-icon',
    'supports_lang' => false, // optional, default is false
    'db_pagination' => false, // optional, default is false
    'columns' => [
      'column_name' => [
        'name' => 'Nome da Coluna', // required
        'type' => 'text', // text, number, date, datetime, time, textarea, checkbox, hidden, image, decimal, html, code, radio, select, password
        'required' => true, // optional, default is false
        'editable' => true, // optional, default is true
        'primary' => true, // optional, default is false
        'foreign' => [
          'module' => 'table_name',
          'column' => 'column_name',
          'highlighted_columns' => ['column_name', 'column_name'] // optional
        ], // optional
        'options' => [
          'option1' => 'Option 1',
          'option2' => 'Option 2'
        ] // optional
      ]
    ]
  ]
];

$modules = [
  'paginas' => [
    'name' => t('Pages'),
    'icon' => 'fa fa-file',
    'supports_lang' => false,
    'columns' => [
      'url' => [
        'name' => 'URL',
        'primary' => true,
        'type' => 'text',
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
      ],
      'conteudo' => [
        'name' => 'Conteúdo',
        'type' => 'code',
      ],
      'modificado_em' => [
        'name' => 'Modificado em',
        'type' => 'datetime',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'conteudo' => [
    'name' => t('Content'),
    'icon' => 'fa fa-scroll',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'type' => 'hidden',
      ],
      'slug' => [
        'name' => 'Slug',
        'type' => 'text',
      ],
      'imagem' => [
        'name' => 'Imagem',
        'type' => 'image',
        'folder' => 'conteudo',
        'required' => false
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'conteudo' => [
        'name' => 'Conteúdo',
        'type' => 'html',
        'lang_dependent' => true
      ],
      'modificado_em' => [
        'name' => 'Modificado em',
        'type' => 'datetime',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'menu' => [
    'name' => t('Menu'),
    'icon' => 'fa fa-bars',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'type' => 'hidden',
      ],
      'url' => [
        'name' => 'URL',
        'type' => 'text',
        'required' => false
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'id_pai' => [
        'name' => 'ID do Menu Pai',
        'type' => 'number',
        'foreign' => [
          'module' => 'menu',
          'column' => 'id',
          'highlighted_columns' => ['titulo'],
        ]
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ],
    ]
  ],
  'atualizacoes' => [
    'name' => t('Updates'),
    'icon' => 'fa fa-newspaper',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'imagem' => [
        'name' => 'Imagem',
        'type' => 'image',
        'folder' => 'atualizacoes',
        'required' => false
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'conteudo' => [
        'name' => 'Conteúdo',
        'type' => 'html',
        'lang_dependent' => true
      ],
      'tipo' => [
        'name' => 'Tipo',
        'type' => 'radio',
        'options' => [
          'correcao' => 'Correção',
          'melhoria' => 'Melhoria',
          'nova-funcionalidade' => 'Nova Funcionalidade'
        ]
      ],
      'data' => [
        'name' => 'Data',
        'type' => 'date',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'faq' => [
    'name' => t('FAQ'),
    'icon' => 'fa fa-question-circle',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'id_categoria' => [
        'name' => 'ID da Categoria',
        'type' => 'number',
        'foreign' => [
          'module' => 'faq_categorias',
          'column' => 'id',
          'highlighted_columns' => ['nome'],
        ]
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'conteudo' => [
        'name' => 'Conteúdo',
        'type' => 'html',
        'lang_dependent' => true
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'faq_categorias' => [
    'name' => t('FAQCategories'),
    'icon' => 'fa fa-list',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'icone' => [
        'name' => 'Ícone',
        'type' => 'text',
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'id_pai' => [
        'name' => 'ID da Categoria Pai',
        'type' => 'number',
        'foreign' => [
          'module' => 'faq_categorias',
          'column' => 'id',
          'highlighted_columns' => ['nome'],
        ]
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'logs' => [
    'name' => t('Logs'),
    'icon' => 'fa fa-history',
    'supports_lang' => false,
    'db_pagination' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'pagina' => [
        'name' => 'Página',
        'type' => 'text',
      ],
      'modulo' => [
        'name' => 'Módulo',
        'type' => 'text',
      ],
      'acao' => [
        'name' => 'Ação',
        'type' => 'text',
      ],
      // 'id_utilizador' => [
      //   'name' => 'ID do Utilizador',
      //   'type' => 'number',
      //   'foreign' => [
      //     'module' => 'utilizadores',
      //     'column' => 'id',
      //     'highlighted_columns' => ['primeiro_nome', 'ultimo_nome', 'email'] // optional
      //   ]
      // ],
      'id_utilizador' => [
        'name' => 'ID do Utilizador',
        'type' => 'number',
      ],
      'endereco_ip' => [
        'name' => 'Endereço de IP',
        'type' => 'text',
      ],
      'id_sessao' => [
        'name' => 'ID da Sessão',
        'type' => 'text',
      ],
      'de_onde' => [
        'name' => 'De Onde',
        'type' => 'text',
      ],
      'data' => [
        'name' => 'Data',
        'type' => 'datetime',
      ]
    ]
  ],
  'patrocinadores' => [
    'name' => t('Sponsors'),
    'icon' => 'fa fa-handshake',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'type' => 'hidden',
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'imagem' => [
        'name' => 'Imagem',
        'type' => 'image',
        'folder' => 'patrocinadores',
        'required' => false
      ],
      'url' => [
        'name' => 'URL',
        'type' => 'text',
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'produtos' => [
    'name' => t('Products'),
    'icon' => 'fa fa-box',
    'supports_lang' => false,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
      ],
      'descricao' => [
        'name' => 'Descrição',
        'type' => 'textarea',
      ],
      'preco' => [
        'name' => 'Preço',
        'type' => 'decimal',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'produtos_caracteristicas' => [
    'name' => t('ProductAttributes'),
    'icon' => 'fa fa-list',
    'supports_lang' => false,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'id_produto' => [
        'name' => 'ID do Produto',
        'type' => 'number',
        'foreign' => [
          'module' => 'produtos',
          'column' => 'id',
          'highlighted_columns' => ['nome', 'preco'],
        ]
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
      ],
      'valor' => [
        'name' => 'Valor',
        'type' => 'text',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'produtos_imagens' => [
    'name' => t('ProductImages'),
    'icon' => 'fa fa-image',
    'supports_lang' => false,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'id_produto' => [
        'name' => 'ID do Produto',
        'type' => 'number',
        'foreign' => [
          'module' => 'produtos',
          'column' => 'id',
          'highlighted_columns' => ['nome', 'preco'],
        ]
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'imagem' => [
        'name' => 'Imagem',
        'type' => 'image',
        'folder' => 'produtos',
        'required' => false
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'testemunhos' => [
    'name' => t('Testimonials'),
    'icon' => 'fa fa-quote-left',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'nome_pessoa' => [
        'name' => 'Nome da Pessoa',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'imagem_pessoa' => [
        'name' => 'Imagem da Pessoa',
        'type' => 'image',
        'folder' => 'testemunhos',
        'required' => false
      ],
      'cargo_pessoa' => [
        'name' => 'Cargo da Pessoa',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'conteudo' => [
        'name' => 'Conteúdo',
        'type' => 'textarea',
        'lang_dependent' => true
      ],
      'estrelas' => [
        'name' => 'Estrelas',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'funcionalidades' => [
    'name' => t("Features"),
    'icon' => 'fa fa-cogs',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'icone' => [
        'name' => 'Ícone',
        'type' => 'text',
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'descricao' => [
        'name' => 'Conteúdo',
        'type' => 'textarea',
        'lang_dependent' => true
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'passos' => [
    'name' => t('Steps'),
    'icon' => 'fa fa-list-ol',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'descricao' => [
        'name' => 'Descrição',
        'type' => 'html',
        'lang_dependent' => true
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'equipa' => [
    'name' => t('Team'),
    'icon' => 'fa fa-users',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'type' => 'hidden',
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
      ],
      'imagem' => [
        'name' => 'Imagem',
        'type' => 'image',
        'folder' => 'equipa',
        'required' => false
      ],
      'cargo' => [
        'name' => 'Cargo',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'seccoes_missao' => [
    'name' => t('OurMissionSections'),
    'icon' => 'fa fa-bullseye',
    'supports_lang' => true,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'type' => 'hidden',
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
        'lang_dependent' => true
      ],
      'descricao' => [
        'name' => 'Descrição',
        'type' => 'textarea',
        'lang_dependent' => true
      ],
      'ordem' => [
        'name' => 'Ordem',
        'type' => 'number',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ],
    ]
  ],
  'mensagens' => [
    'name' => t('Messages'),
    'icon' => 'fa fa-envelope',
    'supports_lang' => false,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'nome' => [
        'name' => 'Nome',
        'type' => 'text',
      ],
      'email' => [
        'name' => 'Email',
        'type' => 'text',
      ],
      'titulo' => [
        'name' => 'Título',
        'type' => 'text',
      ],
      'mensagem' => [
        'name' => 'Mensagem',
        'type' => 'textarea',
      ],
      'data' => [
        'name' => 'Data',
        'type' => 'datetime',
      ],
      'ativo' => [
        'name' => 'Ativo',
        'type' => 'checkbox',
        'required' => false
      ]
    ]
  ],
  'waitlist' => [
    'name' => t('Waitlist'),
    'icon' => 'fa fa-clock',
    'supports_lang' => false,
    'columns' => [
      'id' => [
        'name' => 'ID',
        'primary' => true,
        'editable' => false,
        'type' => 'hidden',
        'required' => false
      ],
      'email' => [
        'name' => 'Email',
        'type' => 'text',
      ],
      'receber_atualizacoes' => [
        'name' => 'Receber Atualizações',
        'type' => 'checkbox',
        'required' => false
      ],
      'data' => [
        'name' => 'Data',
        'type' => 'datetime',
      ]
    ]
  ],
  // 'utilizadores' => [
  //   'name' => t('Users'),
  //   'icon' => 'fa fa-user',
  //   'supports_lang' => false,
  //   'columns' => [
  //     'id' => [
  //       'name' => 'ID',
  //       'primary' => true,
  //       'editable' => false,
  //       'type' => 'hidden',
  //       'required' => false
  //     ],
  //     'email' => [
  //       'name' => 'Email',
  //       'type' => 'text',
  //     ],
  //     'primeiro_nome' => [
  //       'name' => 'Primeiro Nome',
  //       'type' => 'text',
  //     ],
  //     'ultimo_nome' => [
  //       'name' => 'Último Nome',
  //       'type' => 'text',
  //     ],
  //     'password' => [
  //       'name' => 'Senha',
  //       'type' => 'password',
  //     ],
  //     'ativo' => [
  //       'name' => 'Ativo',
  //       'type' => 'checkbox',
  //       'required' => false
  //     ]
  //   ]
  // ],
];
