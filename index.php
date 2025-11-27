<?php
// Define base URL para assets funcionarem em localhost e produção
$is_localhost = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);
$assets_path = $is_localhost ? '/xampp/Site-Institucional-Clouddix' : '';

$ano_atual = date('Y');
$servicos = [
    [
        'icone' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>',
        'titulo' => 'FinOps Azure',
        'descricao' => 'Redução de custos Azure com análises precisas, identificação de desperdícios e otimizações técnicas que geram economia real. Identificamos e implementamos melhorias, criamos visibilidade do consumo e estruturamos governança para evitar surpresas na fatura.',
        'tags' => ['FinOps', 'Otimização', 'Economia']
    ],
    [
        'icone' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
        'titulo' => 'Segurança Cloud',
        'descricao' => 'Auditoria de segurança, implementação de políticas de acesso, backup e disaster recovery. Conformidade com LGPD e normas internacionais.',
        'tags' => ['Security', 'Compliance', 'LGPD']
    ],
    [
        'icone' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
        'titulo' => 'Consultoria em TI',
        'descricao' => 'Avaliação de infraestrutura atual, análise de custos cloud e elaboração de roadmap técnico. Te ajudamos a tomar decisões estratégicas baseadas em dados.',
        'tags' => ['Consultoria', 'Arquitetura', 'FinOps']
    ],
    [
        'icone' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'titulo' => 'Suporte Gerenciado',
        'descricao' => 'Monitoramento 24x7, gestão de incidentes e suporte técnico especializado. Garantimos a disponibilidade da sua infraestrutura cloud.',
        'tags' => ['Suporte', 'Monitoramento', 'SLA']
    ]
];

$cases = [
    [
        'empresa' => 'E-commerce Regional',
        'logo' => 'assets/img/case-ecommerce.png',
        'descricao' => 'Migramos toda infraestrutura de um datacenter local para Azure. O projeto levou 4 meses e incluiu migração de banco SQL Server, refatoração de aplicações .NET e treinamento da equipe interna.',
        'tags' => ['Azure', 'SQL Server', 'App Service'],
        'resultado' => 'Economia de R$ 8k/mês'
    ],
    [
        'empresa' => 'Software House SP',
        'logo' => 'assets/img/case-software.png',
        'descricao' => 'Implementamos pipelines automatizados para 12 projetos diferentes. O time passou a fazer deploys diários com rollback automático em caso de falha, ganhando agilidade e confiança.',
        'tags' => ['Azure DevOps', 'CI/CD', 'Docker'],
        'resultado' => 'Deploy em 15 minutos'
    ],
    [
        'empresa' => 'Indústria Manufatura',
        'logo' => 'assets/img/case-industria.png',
        'descricao' => 'Sistema ERP rodando há 15 anos recebeu modernização gradual. Criamos APIs para integração com novos módulos web, mantendo o core funcionando. Processo levou 8 meses.',
        'tags' => ['Legacy', 'API REST', 'Integração'],
        'resultado' => 'Sistema 100% operacional'
    ]
];

$stats = [
    ['numero' => '5+', 'label' => 'Anos no Mercado'],
    ['numero' => '120+', 'label' => 'Projetos Entregues'],
    ['numero' => '20+', 'label' => 'Clientes Atendidos']
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CloudDix - Soluções inovadoras em Cloud Computing, DevOps e Transformação Digital">
    <meta name="keywords" content="cloud computing, azure, devops, consultoria, transformação digital">
    <title>Clouddix</title>
    <link rel="stylesheet" href="<?php echo $assets_path; ?>/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo">
                <img src="<?php echo $assets_path; ?>/assets/img/logo-clouddix.png" alt="CloudDix" class="logo-img">
            </a>
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="#home">Início</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#services">Serviços</a></li>
                <li><a href="#contact">Contato</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="gradient-orb orb-3"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title animate-slide-up">
                    Sua jornada para a nuvem <span class="gradient-text">começa aqui</span>
                </h1>
                <p class="hero-description animate-slide-up delay-1">
                    Somos especialistas em Modern Work e Cloud, parceiros Microsoft e referência em soluções Azure e ambientes híbridos. Ajudamos empresas a acelerar sua transformação digital com resultados reais, alto desempenho e tecnologia de ponta.
                </p>
                
                <!-- Stats -->
                <div class="hero-stats animate-fade-in delay-3">
                    <?php foreach($stats as $stat): ?>
                    <div class="stat-item">
                        <h3 class="stat-number"><?= $stat['numero'] ?></h3>
                        <p class="stat-label"><?= $stat['label'] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="hero-visual animate-fade-in delay-2">
                <div class="floating-card card-1">
                    <div class="float-card-icon">
                        <img src="<?php echo $assets_path; ?>/assets/img/microsoft-azure.png" alt="Azure" style="width: 38px; height: 38px; object-fit: contain;">
                    </div>
                    <div class="card-content">
                        <h4>Cloud Azure</h4>
                        <div class="progress-bar">
                            <div class="progress" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
                <div class="floating-card card-2">
                    <div class="float-card-icon">
                        <img src="<?php echo $assets_path; ?>/assets/img/microsoft-defender.png" alt="Microsoft Defender" style="width: 38px; height: 38px; object-fit: contain;">
                    </div>
                    <div class="card-content">
                        <h4>Segurança</h4>
                        <div class="progress-bar">
                            <div class="progress" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div class="floating-card card-3">
                    <div class="float-card-icon">
                        <img src="<?php echo $assets_path; ?>/assets/img/microsoft-m365.png" alt="Modern Work" style="width: 38px; height: 38px; object-fit: contain;">
                    </div>
                    <div class="card-content">
                        <h4>Modern Work</h4>
                        <div class="progress-bar">
                            <div class="progress" style="width: 98%"></div>
                        </div>
                    </div>
                </div>
                <div class="hero-circle"></div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <span class="section-label">Quem Somos</span>
                <h2 class="section-title">
                    Especialistas em Cloud <span class="gradient-text">de verdade</span>
                </h2>
                <p class="section-description">
                    Somos uma empresa especializada em Cloud, atuando desde 2020 na transformação digital de empresas. Nosso propósito é claro: entender cada desafio e entregar a solução ideal, com eficiência, segurança e alto valor agregado.
                </p>
                <p class="about-text">
                    Nossa equipe é formada por profissionais certificados em Azure, unindo expertise em infraestrutura e desenvolvimento para criar soluções completas e modernas. Nascemos remotos e atendemos clientes em todo o Brasil, sempre com agilidade, proximidade e excelência técnica.
                </p>
            </div>
            
            <div class="about-features">
                <div class="feature-box">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <h3>FinOps e Otimização</h3>
                    <p>Analisamos suas assinaturas Azure, identificamos desperdícios e implementamos ações de otimização que geram economia real. Já ajudamos clientes a reduzir mais de 35% dos custos em Azure — com eficiência, transparência e impacto imediato no orçamento.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </div>
                    <h3>Mão na Massa</h3>
                    <p>Não somos apenas uma "consultoria de PowerPoint". Atuamos de ponta a ponta: Trabalhamos lado a lado com sua equipe para fazer acontecer de verdade.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h3>Pragmatismo</h3>
                    <p>Priorizamos soluções simples e que funcionam. Não tem over-engineering aqui. Se dá pra resolver com menos, a gente faz com menos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Microsoft Partner Section -->
    <section class="microsoft-partner">
        <div class="container">
            <div class="partner-content">
                <div class="partner-badge">
                    <svg width="80" height="80" viewBox="0 0 23 23" fill="none">
                        <rect width="11" height="11" fill="#F25022"/>
                        <rect x="12" width="11" height="11" fill="#7FBA00"/>
                        <rect y="12" width="11" height="11" fill="#00A4EF"/>
                        <rect x="12" y="12" width="11" height="11" fill="#FFB900"/>
                    </svg>
                </div>
                <div class="partner-text">
                    <h2 class="partner-title">Parceiro de Soluções <span class="gradient-text">Microsoft</span></h2>
                    <p class="partner-description">
                        Somos parceiros CSP oficiais Microsoft, especializados em licenciamento e entrega de serviço. 
                        Nossa expertise certificada garante que sua empresa receba o melhor das soluções Microsoft.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <span class="section-label">O que fazemos</span>
            <h2 class="section-title">
                Nossos <span class="gradient-text">Serviços</span>
            </h2>
            
            <div class="services-grid">
                <?php foreach($servicos as $index => $servico): ?>
                <div class="service-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="service-header">
                        <div class="service-icon"><?= $servico['icone'] ?></div>
                        <h3 class="service-title"><?= $servico['titulo'] ?></h3>
                    </div>
                    <p class="service-description"><?= $servico['descricao'] ?></p>
                    <div class="service-tags">
                        <?php foreach($servico['tags'] as $tag): ?>
                        <span class="tag"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                    <a href="#contact" class="service-link">
                        Saiba mais
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8H13M13 8L8 3M13 8L8 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="carousel-dots" id="servicesDots"></div>
        </div>
    </section>

    <!-- Microsoft Partner Logo Section -->
    <section class="partner-logo-section" id="partner">
        <div class="container">
            <span class="section-label">Parceiro</span>
            <h2 class="section-title">
                Nossa <span class="gradient-text">parceria</span>
            </h2>
            <div class="partner-logo-container">
                <img src="<?php echo $assets_path; ?>/assets/img/microsoft-logo.png" alt="Microsoft Partner" class="microsoft-partner-logo">
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-content">
                <span class="section-label">Contato</span>
                <h2 class="section-title">
                    Bora <span class="gradient-text">conversar?</span>
                </h2>
                <p class="section-description">
                    Nos envie um email. 
                    Se preferir agilizar, nos mande uma mensagem pelo WhatsApp.
                </p>
                
                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Email Comercial</h4>
                            <p>contato@clouddix.com.br</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Telefone</h4>
                            <p><a href="tel:+5511941731330" style="color: inherit; text-decoration: none;">+55 11 94173-1330</a></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>WhatsApp (mais rápido)</h4>
                            <p><a href="https://wa.me/5511941731330?text=Ol%C3%A1%20Olá!%20Vim%20pelo%20site%20e%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es." target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">+55 11 94173-1330</a></p>
                            <a href="https://wa.me/5511941731330?text=Ol%C3%A1%20Olá!%20Vim%20pelo%20site%20e%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es." target="_blank" rel="noopener noreferrer" style="color: #10b981; font-size: 0.875rem; margin-top: 4px; display: inline-block; text-decoration: none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                </svg>
                                Chamar agora
                            </a>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="info-content">
                            <h4>Atendimento</h4>
                            <p>Seg-Sex: 9h às 18h</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-wrapper">
                <form class="contact-form" id="contactForm" method="POST" action="send-email.php">
                    <div class="form-group">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" required placeholder="Seu nome completo">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="seu@email.com">
                    </div>
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input type="text" id="empresa" name="empresa" placeholder="Nome da sua empresa">
                    </div>
                    <div class="form-group">
                        <label for="assunto">Assunto</label>
                        <input type="text" id="assunto" name="assunto" required placeholder="Como podemos ajudar?">
                    </div>
                    <div class="form-group form-group-full">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Conte-nos mais sobre seu projeto..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">
                        <span>Enviar Mensagem</span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M18 2L9 11M18 2L12 18L9 11M18 2L2 8L9 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <a href="#home" class="footer-logo">
                        <img src="<?php echo $assets_path; ?>/assets/img/logo-clouddix.png" alt="CloudDix" class="footer-logo-img">
                    </a>
                    <p class="footer-description">
                        Somos uma empresa especializada em Cloud, atuando desde 2020 na transformação digital de empresas. Nosso propósito é claro: entender cada desafio e entregar a solução ideal, com eficiência, segurança e alto valor agregado.
                    </p>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/company/clouddix/" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.04 17.043h-2.962v-4.64c0-1.106-.023-2.53-1.544-2.53-1.544 0-1.78 1.204-1.78 2.449v4.722H7.793V7.5h2.844v1.3h.039c.397-.75 1.364-1.54 2.808-1.54 3.004 0 3.556 1.974 3.556 4.545v5.238zM4.447 6.194c-.954 0-1.72-.776-1.72-1.729 0-.953.766-1.729 1.72-1.729.95 0 1.72.776 1.72 1.729 0 .953-.77 1.729-1.72 1.729zm1.484 10.85h-2.97V7.5h2.97v9.543zM18.522 0H1.476C.66 0 0 .645 0 1.44v17.12C0 19.355.66 20 1.476 20h17.042c.815 0 1.482-.645 1.482-1.44V1.44C20 .645 19.333 0 18.518 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 0C7.284 0 6.944.012 5.878.06 4.813.11 4.086.278 3.45.525a4.902 4.902 0 00-1.772 1.153A4.902 4.902 0 00.525 3.45C.278 4.086.109 4.813.06 5.877.012 6.944 0 7.284 0 10s.012 3.056.06 4.122c.05 1.065.218 1.792.465 2.428a4.902 4.902 0 001.153 1.772 4.902 4.902 0 001.772 1.153c.636.247 1.363.416 2.427.465 1.067.048 1.407.06 4.123.06s3.056-.012 4.122-.06c1.065-.05 1.792-.218 2.428-.465a4.902 4.902 0 001.772-1.153 4.902 4.902 0 001.153-1.772c.247-.636.416-1.363.465-2.428.048-1.066.06-1.406.06-4.122s-.012-3.056-.06-4.122c-.05-1.065-.218-1.792-.465-2.428A4.902 4.902 0 0016.55 1.678 4.902 4.902 0 0014.778.525C14.142.278 13.415.109 12.35.06 11.284.012 10.944 0 10 0zm0 1.802c2.67 0 2.987.01 4.04.058.976.045 1.505.207 1.858.344.466.182.8.398 1.15.748.35.35.566.684.748 1.15.137.353.3.882.344 1.857.048 1.054.058 1.37.058 4.04 0 2.672-.01 2.988-.058 4.042-.045.975-.207 1.504-.344 1.857a3.097 3.097 0 01-.748 1.15c-.35.35-.684.566-1.15.748-.353.137-.882.3-1.857.344-1.054.048-1.37.058-4.042.058-2.67 0-2.987-.01-4.04-.058-.976-.045-1.505-.207-1.858-.344a3.098 3.098 0 01-1.15-.748 3.098 3.098 0 01-.748-1.15c-.137-.353-.3-.882-.344-1.857-.048-1.054-.058-1.37-.058-4.041 0-2.67.01-2.986.058-4.04.045-.976.207-1.505.344-1.858.182-.466.399-.8.748-1.15.35-.35.684-.566 1.15-.748.353-.137.882-.3 1.857-.344 1.054-.048 1.37-.058 4.041-.058z"/>
                                <path d="M10 13.333A3.333 3.333 0 1110 6.667a3.333 3.333 0 010 6.666zm0-8.468a5.135 5.135 0 100 10.27 5.135 5.135 0 000-10.27zm6.538-.203a1.2 1.2 0 11-2.4 0 1.2 1.2 0 012.4 0z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="WhatsApp">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.002 0C4.477 0 0 4.477 0 10a9.96 9.96 0 001.333 4.99L.05 19.95l5.087-1.334A9.96 9.96 0 0010.002 20c5.525 0 10.002-4.477 10.002-10S15.527 0 10.002 0zm5.85 14.146c-.245.69-1.215 1.266-1.988 1.432-.525.112-1.211.203-3.516-.754-2.95-1.224-4.848-4.223-4.996-4.416-.145-.193-1.193-1.588-1.193-3.03 0-1.443.755-2.15 1.023-2.443.268-.292.584-.365.779-.365.195 0 .39.002.56.01.18.01.42-.067.657.502.244.585.83 2.027.903 2.174.072.147.12.318.024.512-.097.193-.145.314-.29.484-.144.17-.303.38-.433.51-.145.146-.296.305-.127.598.17.292.753 1.243 1.617 2.014 1.112 1.001 2.05 1.312 2.34 1.46.292.146.462.122.633-.073.17-.195.73-.852.925-1.145.194-.292.39-.243.658-.146.268.098 1.705.804 1.997.95.292.147.487.22.56.342.072.122.072.706-.172 1.387z"/>
                            </svg>
                        </a>
                        <a href="mailto:suporteclouddix@gmail.com" class="social-link" aria-label="Email">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.5 5A2.5 2.5 0 000 7.5v7A2.5 2.5 0 002.5 17h15a2.5 2.5 0 002.5-2.5v-7A2.5 2.5 0 0017.5 5h-15zM18 7.5v.384l-8 5-8-5V7.5a.5.5 0 01.5-.5h15a.5.5 0 01.5.5zm0 2.117v4.883a.5.5 0 01-.5.5h-15a.5.5 0 01-.5-.5V9.617l7.548 4.717a.5.5 0 00.53 0L18 9.617z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-title">Serviços</h4>
                    <ul class="footer-links">
                        <li><a href="#services">Cloud Computing</a></li>
                        <li><a href="#services">FinOps Azure</a></li>
                        <li><a href="#services">Consultoria em TI</a></li>
                        <li><a href="#services">Segurança</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-title">Empresa</h4>
                    <ul class="footer-links">
                        <li><a href="#about">Sobre Nós</a></li>
                        <li><a href="#cases">Portfolio</a></li>
                        <li><a href="#contact">Contato</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 class="footer-title">Contato</h4>
                    <ul class="footer-links">
                        <li><a href="mailto:contato@clouddix.com.br">contato@clouddix.com.br</a></li>
                        <li><a href="https://wa.me/5511941731330" target="_blank" rel="noopener noreferrer">+55 11 94173-1330</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= $ano_atual ?> CloudDix. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo $assets_path; ?>/assets/js/script.js"></script>
</body>
</html>
