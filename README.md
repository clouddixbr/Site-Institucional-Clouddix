# CloudDix - Site Institucional

Site institucional da CloudDix desenvolvido em PHP 8.2 com deploy no Azure App Service.

## Stack

- **Frontend**: HTML5, CSS3 (Vanilla), JavaScript (ES6+)
- **Backend**: PHP 8.2
- **Deploy**: Azure App Service (Linux)
- **CI/CD**: Azure Pipelines

## Estrutura do Projeto

```
Site-Institucional-Clouddix/
├── index.php              # Página principal
├── assets/
│   ├── css/
│   │   └── style.css      # Estilos globais
│   ├── js/
│   │   └── script.js      # Scripts interativos
│   └── img/               # Imagens e assets
├── azure-pipelines.yml    # Pipeline de CI/CD
└── README.md
```

## Desenvolvimento Local

### Requisitos

- PHP 8.2+
- XAMPP ou servidor similar
- Navegador moderno

### Como rodar

1. Clone o repositório no diretório do XAMPP:
   ```bash
   cd c:\xampp\htdocs\
   git clone [repo-url] Site-Institucional-Clouddix
   ```

2. Inicie o Apache no XAMPP

3. Acesse no navegador:
   ```
   http://localhost/Site-Institucional-Clouddix/
   ```

## Deploy

O deploy é feito automaticamente via Azure Pipelines quando há merge na branch `main`.

### Fluxo do Pipeline:

1. **Build**: Instala PHP 8.2, roda composer install, gera artefato
2. **Deploy Staging**: Sobe no slot de staging do App Service
3. **Approval**: Aguarda aprovação manual do gestor
4. **Deploy Production**: Promove para produção após aprovação

### Configurações do Azure

- **Service Connection**: AzureServiceConnection-site
- **App Service**: siteclouddix
- **Resource Group**: rg-hml-site-clouddix-brs
- **Runtime Stack**: PHP|8.2

## Funcionalidades

- ✅ Design responsivo (mobile, tablet, desktop)
- ✅ Smooth scroll entre seções
- ✅ Formulário de contato com validação
- ✅ Menu mobile funcional
- ✅ Botão flutuante do WhatsApp
- ✅ Animações on-scroll
- ✅ Contador animado nas estatísticas

## Contato

- **Email**: contato@clouddix.com.br
- **WhatsApp**: (11) 97542-7080
- **Website**: [em breve]

## Notas

- O formulário de contato atualmente simula o envio (linha 80 do script.js). Precisa integrar com API real.
- Imagens dos cases são placeholders. Substituir quando tiver as logos reais dos clientes.
- Validar LGPD antes de ativar tracking analytics.

## TODO

- [ ] Integrar formulário com backend real
- [ ] Adicionar Google Analytics
- [ ] Otimizar imagens (WebP)
- [ ] Adicionar sitemap.xml
- [ ] Configurar SSL no Azure
- [ ] Adicionar página de política de privacidade
