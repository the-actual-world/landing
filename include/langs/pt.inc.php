<?php

global $arrLangs;

include $arrConfig['dir_site'] . '/include/constants.inc.php';

$arrLangs = [
  // Errors
  "ErrorFillAllFields" => "Por favor preencha todos os campos.",
  "ErrorPasswordsDontMatch" => "As palavras-passe não coincidem.",
  "ErrorEmailAlreadyExists" => "O email já existe.",
  "ErrorInvalidCredentials" => "Credenciais inválidas.",
  "ErrorSendingMessage" => "Ocorreu um erro ao enviar a mensagem. Por favor tenta novamente.",

  // Success
  "SuccessMessageSent" => "A mensagem foi enviada com sucesso. Obrigado!",

  // Pages
  "Home" => "Início",
  "About" => "Sobre",

  // Header
  "Help" => "Ajuda",
  "Language" => "Idioma",
  "Download" => "Instalar", // Mudar para "Instalar"
  "LearnMore" => "Saber Mais",

  // Footer
  "Navigation" => "Navegação",
  "Start" => "Começar",

  // Waitlist
  "JoinWaitlist" => "Junta-te à Lista de Espera",
  "JoinWaitlistSubtitle" => "Inscreve-te para seres notificado quando a plataforma estiver disponível.",
  "EmailPlaceholder" => "Email",
  "ReceiveEmailUpdates" => "Receber atualizações por email",
  "Join" => "Inscrever",
  "WaitlistSuccess" => "Obrigado por te inscreveres! Serás notificado quando a plataforma te estiver disponível.",

  // Home Page
  "HeroSlogan" => "Rede Social<br>Realmente Social",
  "HeroSubtitle" => "Não vendemos os teus dados. Não te seguimos.<br>Não tentamos manter-te na plataforma por mais tempo <em>(na verdade, pelo contrário)</em>.<br>Diverte-te com os teus amigos, compartilha fotos e cria memórias. <strong>Só isso.</strong>",
  "BroughtBy" => "Trazido por",

  // About Page
  "AboutUs" => "Sobre Nós",
  "AboutUsSubtitle" => "Conhece a nossa equipa e a nossa missão.",
  "WelcomeTitle" => "Quem Somos",
  "WelcomeSubtitle1" => "Bem-vindos ao The Actual World – O Mundo Real, a vossa nova rede social dedicada a reforçar laços autênticos num ambiente seguro e privado. Nascemos no Porto, Portugal, com a visão de transformar a forma como interagimos online.",
  "WelcomeSubtitle2" => "Numa era digital onde a privacidade é rara e o tempo online pode afetar a nossa saúde mental, decidimos contra-atacar. A nossa missão é proporcionar uma plataforma onde possam controlar com quem partilham as vossas memórias e momentos, num ambiente livre de anúncios e algoritmos invasivos.",
  "OurMission" => "A Nossa Missão",
  "OurMissionSubtitle" => "Reconectar o mundo digital ao real, promovendo interações significativas, privacidade intransigente e um equilíbrio saudável entre a vida online e offline.",
  "OurTeam" => "A Nossa Equipa",

  // Help Page
  "HelpTitle" => "Precisas de Ajuda?",
  "HelpSubtitle" => "Encontra respostas para as tuas dúvidas",
  "HelpSubtitle2" => "sobre ",
  "HelpSubtitle3" => ", assim como o resto da plataforma!",

  // Pricing Page
  "Pricing" => "Preço",
  "OurPrices" => "Os nossos preços",
  "OurPricesSubtitle" => "Acreditamos que os utilizadores de qualquer rede social devem permanecer os clientes, e não o produto.",
  "PricingPageHTML" => "
    <p>No The Actual World, acreditamos que os utilizadores de qualquer rede social devem permanecer os clientes, e não o produto. Por isso, não vendemos os teus dados a terceiros.</p>
    <p>Em vez disso, a nossa fonte de rendimento provém da subscrição dos utilizadores, e é com isso que a plataforma se financia.</p>
    <p>Créditos são aquilo que paga pela rede social! A única forma de obter créditos é comprando-os, ou recebendo-os de amigos (como presentes), no entanto, todos os utilizadores começam com a quantia de {$CONSTANTS['InitialCredits']} créditos.</p>
    <p>A nossa equipa acredita que os créditos são a forma mais transparente de pagar pela rede social.</p>
    <p>Os créditos são descontados da tua conta com base naquilo que usas, neste caso:</p>
    <ul>
      <li><strong>{$CONSTANTS['CreditsPerDayNormal']} créditos por dia</strong>, ou seja, ~<{$CONSTANTS['EurosPerMonthNormal']}€ por mês ({$CONSTANTS['EurosPerYearNormal']}€ por ano) visto que, ainda que não uses a rede social, a tua conta continua a ser mantida, assim como fotos e conversas.</li>
      <li><strong>{$CONSTANTS['CreditsPerGBPerDay']} créditos por dia por GB de fotos e vídeos guardados</strong>, ou seja, ~{$CONSTANTS['EurosPerExampleGBPerMonth']}€ por mês ({$CONSTANTS['EurosPerExampleGBPerYear']}€ por ano) caso tenhas {$CONSTANTS['ExampleGB']} GB de fotos e vídeos guardados.</li>
      <li><strong>{$CONSTANTS['CreditsPerSummary']} créditos por cada resumo diário que gerares </strong> ({$CONSTANTS['EurosPerSummary']}€ por resumo).</li>
    </ul>
  ",

  // Catalog Page
  "Catalog" => "Catálogo",
  "CatalogSubtitle" => "Pretendes-te vestir à maneira e suportar a privacidade online? Aqui encontras as melhores opções.",
  "ViewProduct" => "Ver Produto",

  // Product Page
  "Product" => "Produto",
  "Images" => "Imagens",
  "Attributes" => "Características",
  "Description" => "Descrição",
  "Buy" => "Comprar",
  "AddToCart" => "Adicionar ao Carrinho",

  // Updates Page
  "UpdatesSubtitle" => "Fica a par das últimas novidades e melhorias na plataforma.",
  "UpdatesKeywords" => "atualizações, novidades, melhorias, correções",
  "Previous" => "Anterior",
  "Next" => "Seguinte",
  "ReadMore" => "Ler Mais",
  "NewFeature" => "Nova Funcionalidade",
  "Improvement" => "Melhoria",
  "BugFix" => "Correção",

  // Update Page
  "Update" => "Atualização",
  "WhatWasUpdated" => "O que foi atualizado?",

  // Contact Page
  "Contact" => "Contacto",
  "Message" => "Mensagem",
  "Email" => "Email",
  "Name" => "Nome",
  "Title" => "Título",
  "Send" => "Enviar",
  "ContactUs" => "Contacta-nos",
  "ContactUsSubtitle" => "Se tens alguma dúvida, sugestão ou recomendação, entra em contacto connosco. Estamos disponíveis para te ajudar.",
  "StartContact" => "Entra em contacto",
  "StartContactSubtitle" => "Tens recomendações, sugestões ou dúvidas? Entra em contacto connosco.",

  // CTA Section
  "CTATitle" => "Começa já a partilhar as tuas memórias com quem realmente importa.",

  // Months
  "January" => "Janeiro",
  "February" => "Fevereiro",
  "March" => "Março",
  "April" => "Abril",
  "May" => "Maio",
  "June" => "Junho",
  "July" => "Julho",
  "August" => "Agosto",
  "September" => "Setembro",
  "October" => "Outubro",
  "November" => "Novembro",
  "December" => "Dezembro",

  // Tables
  "Pages" => "Páginas",
  "Content" => "Conteúdo",
  "Menu" => "Menu",
  "Updates" => "Atualizações",
  "FAQ" => "Ajuda",
  "FAQCategories" => "Categorias de Ajuda",
  "Logs" => "Logs",
  "Sponsors" => "Patrocinadores",
  "Products" => "Produtos",
  "ProductAttributes" => "Características dos Produtos",
  "ProductImages" => "Imagens dos Produtos",
  "Testimonials" => "Testemunhos",
  "Features" => "Funcionalidades",
  "Steps" => "Passos",
  "Team" => "Equipa",
  "OurMissionSections" => "Secções de A Nossa Missão",
  "Messages" => "Mensagens",
  "Users" => "Utilizadores",

  // Configuration
  "_Timezone" => "Europe/Lisbon",
  "_Locale" => "pt_PT",
  "_LocaleFallback" => "pt_PT.utf-8",
  "_LocaleNextFallback" => "portuguese",

  // Others
  "GlobalPageTitle" => "The Actual World",
  "GlobalPageTitleSuffix" => " - TAW",
  "GlobalPageDescription" => "Rede Social Transparente, Realmente Social",
  "GlobalPageKeywords" => "rede social, privacidade, segurança, transparência, amigos, partilha, fotos, memórias",
  "GlobalPageDescriptionSuffix" => " - A rede social que te respeita: The Actual World",
];