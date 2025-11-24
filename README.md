# CloudDix - Site Institucional

Site institucional da CloudDix desenvolvido em PHP 8.2 com integração Azure Communication Services e deploy no Azure App Service.

## Stack

- **Frontend**: HTML5, CSS3 (Vanilla), JavaScript (ES6+)
- **Backend**: PHP 8.2 com Composer
- **Email**: Azure Communication Services (REST API)
- **Deploy**: Azure App Service (Linux)
- **CI/CD**: Azure Pipelines

## Estrutura do Projeto

```
Site-Institucional-Clouddix/
├── index.php              # Página principal com todas as seções
├── send-email.php         # Handler do formulário com Azure Communication Services
├── composer.json          # Dependências PHP (autoloader)
├── .env                   # Variáveis de ambiente (não commitar!)
├── .env.example           # Template do .env
├── assets/
│   ├── css/
│   │   └── style.css      # Estilos globais (1500+ linhas)
│   ├── js/
│   │   └── script.js      # Scripts interativos (carousel, menu mobile, validações)
│   └── img/               # Imagens otimizadas
│       ├── logo-clouddix.png      # Logo CloudDix
│       ├── microsoft-logo.png     # Logo Microsoft Partner
│       ├── microsoft-azure.png    # Ícone Azure
│       ├── microsoft-defender.png # Ícone Defender
│       └── microsoft-m365.png     # Ícone M365
├── src/
│   └── AzureCommunicationEmail.php  # Cliente API Azure Communication Services
├── vendor/                # Dependências Composer (gerado)
├── azure-pipelines.yml    # Pipeline de CI/CD
└── README.md
```

## Desenvolvimento Local

### Requisitos

- PHP 8.2+
- Composer
- Extensões PHP: cURL, JSON, mbstring
- XAMPP ou servidor similar
- Azure Communication Services (para envio de emails)
- Navegador moderno

### Como rodar

1. Clone o repositório no diretório do XAMPP:
   ```bash
   cd c:\xampp\htdocs\
   git clone [repo-url] Site-Institucional-Clouddix
   ```

2. Instale as dependências:
   ```bash
   cd Site-Institucional-Clouddix
   composer install
   ```

3. Configure o arquivo `.env`:
   ```bash
   copy .env.example .env
   ```
   
4. Edite o `.env` e adicione suas credenciais do Azure (veja seção de configuração abaixo)

5. Inicie o Apache no XAMPP

6. Acesse no navegador:
   ```
   http://localhost/Site-Institucional-Clouddix/
   ```

## Configuração do Azure Communication Services

### 1. Criar o Recurso no Azure

1. Acesse o [Portal do Azure](https://portal.azure.com)
2. Clique em **"Criar um recurso"**
3. Busque por **"Communication Services"** e clique em **"Criar"**
4. Preencha:
   - **Assinatura**: Sua assinatura Azure
   - **Grupo de Recursos**: `rg-hml-site-clouddix-brs` (ou crie um novo)
   - **Nome do Recurso**: `azure-communicationservice` (ou nome de sua preferência)
   - **Região**: United States (ou sua preferência)
   - **Data Location**: United States
5. Clique em **"Revisar + criar"** → **"Criar"**

### 2. Provisionar Domínio de Email

Após criar o recurso, você precisa vincular um domínio para enviar emails:

#### Opção A: Domínio Gratuito Azure (Rápido)

1. No recurso Communication Services, vá em **Email** → **Provision domains**
2. Clique em **"Add domain"** → **"Azure Managed Domain"**
3. Escolha um nome: `clouddix` (será criado como `clouddix.azurecomm.net`)
4. Clique em **"Add"**
5. Aguarde até o status ficar **"Verified"** (alguns segundos)

#### Opção B: Domínio Personalizado (Recomendado para Produção)

1. No recurso Communication Services, vá em **Email** → **Provision domains**
2. Clique em **"Connect domain"** → **"Custom domain"**
3. Digite seu domínio: `clouddix.com`
4. Siga as instruções para configurar registros DNS:
   - **TXT**: Verificação do domínio
   - **SPF**: Autorização de envio
   - **DKIM**: Autenticação de mensagens
5. Aguarde a verificação (pode levar até 48 horas)

### 3. Configurar Endereço de Email

1. Vá em **Email** → **MailFrom addresses**
2. Clique em **"Add MailFrom address"**
3. Selecione seu domínio provisionado
4. Configure:
   - **MailFrom Username**: `DoNotReply`
   - **Display Name**: `CloudDix`
5. O endereço será: `DoNotReply@clouddix.azurecomm.net` (ou seu domínio personalizado)

### 4. Obter Credenciais de Acesso

1. No recurso Communication Services, vá em **Settings** → **Keys**
2. Copie a **Primary connection string** completa
3. Formato: `endpoint=https://azure-communicationservice.unitedstates.communication.azure.com/;accesskey=sua-chave==`

### 5. Configurar Variáveis de Ambiente

#### Desenvolvimento Local (.env)

Edite o arquivo `.env`:

```env
AZURE_COMMUNICATION_CONNECTION_STRING=endpoint=https://azure-communicationservice.unitedstates.communication.azure.com/;accesskey=sua-chave-aqui==
SENDER_EMAIL=DoNotReply@clouddix.azurecomm.net
```

**⚠️ IMPORTANTE**: Adicione `.env` ao `.gitignore` para não versionar credenciais!

```bash
echo ".env" >> .gitignore
```

#### Produção (Azure App Service)

1. No Azure Portal, acesse seu App Service
2. Vá em **Configuration** → **Application Settings**
3. Adicione:
   - **Nome**: `AZURE_COMMUNICATION_CONNECTION_STRING`  
     **Valor**: `endpoint=https://...;accesskey=...`
   - **Nome**: `SENDER_EMAIL`  
     **Valor**: `DoNotReply@clouddix.azurecomm.net`
4. Clique em **"Save"** e reinicie o App Service

## Deploy

O deploy é feito automaticamente via Azure Pipelines quando há merge na branch `main`.

### Fluxo do Pipeline:

1. **Build**: Instala PHP 8.2, roda composer install, gera artefato
2. **Deploy Staging**: Sobe no slot de staging do App Service
3. **Approval**: Aguarda aprovação manual do gestor
4. **Deploy Production**: Promove para produção após aprovação

### Configurações do Azure App Service

- **Service Connection**: AzureServiceConnection-site
- **App Service**: siteclouddix
- **Resource Group**: rg-hml-site-clouddix-brs
- **Runtime Stack**: PHP|8.2

### Variáveis de Ambiente (Production)

Configure no Azure App Service → Configuration → Application Settings:

```
AZURE_COMMUNICATION_CONNECTION_STRING=endpoint=https://...;accesskey=...
SENDER_EMAIL=DoNotReply@seudominio.azurecomm.net
```

## Funcionalidades

### Frontend
- ✅ Design responsivo (mobile, tablet, desktop)
- ✅ Navegação fixa com efeito de scroll
- ✅ Menu mobile com hamburger animado
- ✅ Hero section com 3 floating cards animados (Azure, Defender, M365)
- ✅ Estatísticas animadas (5+ anos, 120+ projetos, 20+ clientes)
- ✅ Seção sobre com cards de features
- ✅ Seção Microsoft Partner com badge
- ✅ Carrossel automático de serviços com navigation dots
- ✅ 4 serviços principais: FinOps Azure, Segurança, Consultoria, Suporte
- ✅ Seção de parceria com logo Microsoft
- ✅ Formulário de contato com validação client-side
- ✅ Botão flutuante do WhatsApp
- ✅ Footer completo com links e redes sociais
- ✅ Smooth scroll entre seções
- ✅ Animações on-scroll com Intersection Observer

### Backend
- ✅ Envio de emails via Azure Communication Services
- ✅ Validação server-side dos dados do formulário
- ✅ Autenticação HMAC-SHA256 para API do Azure
- ✅ Templates HTML responsivos para emails
- ✅ Sistema de logs e tratamento de erros
- ✅ Rate limiting básico (1 email a cada 30 segundos por IP)
- ✅ Sanitização de inputs contra XSS

## Contato

- **Email**: contato@clouddix.com.br
- **WhatsApp**: +55 11 94173-1330
- **Website**: [em breve]

## Notas

- O site está focado em Modern Work e soluções Microsoft Azure
- Todas as imagens foram renomeadas para padrão sem espaços (kebab-case)
- O carrossel de serviços possui auto-scroll de 4 segundos e pausa ao hover
- Seção de cases foi removida e substituída por seção de parceria Microsoft
- Navegação simplificada: Início, Sobre, Serviços, Contato
- LinkedIn da empresa: https://www.linkedin.com/company/clouddix/

## Segurança

- ✅ Variáveis sensíveis em `.env` (não commitado)
- ✅ Sanitização de inputs com `htmlspecialchars()`
- ✅ Validação de email com `filter_var()`
- ✅ Rate limiting básico por IP
- ✅ Autenticação HMAC-SHA256 para Azure API
- ⚠️ **IMPORTANTE**: Adicione `.env` ao `.gitignore`

## Troubleshooting

### Erro 401: "Denied by the resource provider"

**Causa**: Autenticação falhou (access key incorreta ou expirada)

**Solução**:
1. Verifique se copiou a **Primary connection string** completa do Azure Portal
2. Vá em: Communication Services → Keys → Copie novamente
3. Certifique-se de que o formato está correto: `endpoint=https://...;accesskey=...`
4. Não deve ter espaços ou quebras de linha na connection string
5. Atualize o `.env` ou as configurações do App Service

### Erro 404: "The specified sender domain has not been linked"

**Causa**: O domínio de email não está provisionado ou vinculado ao recurso

**Solução**:
1. Acesse: Communication Services → Email → Domains
2. Verifique se há algum domínio na lista com status **"Verified"**
3. Se não houver, provisione um domínio (Azure gratuito ou personalizado)
4. Após provisionar, vá em: Email → MailFrom addresses
5. Copie o endereço **exato** que aparece (ex: `DoNotReply@clouddix.azurecomm.net`)
6. Atualize `SENDER_EMAIL` no `.env` com o endereço correto

### Erro: "Class 'CloudDix\AzureCommunicationEmail' not found"

**Causa**: Autoloader do Composer não foi gerado

**Solução**:
```bash
cd Site-Institucional-Clouddix
composer install
```

Certifique-se de que a pasta `vendor/` foi criada.

### Erro: "cURL error: Operation timed out"

**Causa**: Timeout na conexão com a API do Azure

**Solução**:
1. Verifique sua conexão com a internet
2. Confirme se o endpoint do Azure está acessível
3. Se estiver atrás de proxy, configure as variáveis de ambiente:
   ```env
   HTTP_PROXY=http://proxy:porta
   HTTPS_PROXY=http://proxy:porta
   ```

### Emails não chegam na caixa de entrada

**Possíveis causas**:
1. **Pasta de spam**: Verifique a pasta de spam/lixo eletrônico
2. **Domínio não verificado**: Domínios não verificados podem ter baixa reputação
3. **Email de destino incorreto**: Confirme o endereço em `send-email.php`

**Solução**:
1. Use domínio personalizado com SPF/DKIM configurados (melhora entregabilidade)
2. Adicione o remetente à lista de contatos confiáveis
3. Monitore logs no Azure Portal: Communication Services → Monitoring → Logs

### Erro: "Rate limit exceeded"

**Causa**: Muitos emails enviados em curto período (1 email a cada 30 segundos por IP)

**Solução**:
- Aguarde 30 segundos entre envios
- Para aumentar o limite, ajuste `$_SESSION['last_email_time']` em `send-email.php`

## Monitoramento e Logs

### Logs do Apache (Local)

```bash
# Windows (XAMPP)
Get-Content "C:\xampp\apache\logs\error.log" -Tail 50

# Linux
tail -f /var/log/apache2/error.log
```

### Logs no Azure Portal

1. Acesse: Communication Services → Monitoring → Logs
2. Execute query KQL:

```kusto
ACSEmailSendMailOperational
| where TimeGenerated > ago(24h)
| project TimeGenerated, MessageId, SenderAddress, RecipientAddress, Status
| order by TimeGenerated desc
```

### Application Insights (Recomendado para Produção)

1. Crie recurso Application Insights no Azure
2. Configure no App Service: Configuration → Application Settings
3. Adicione: `APPINSIGHTS_INSTRUMENTATIONKEY=sua-chave`

## Limites e Quotas

| Tipo | Limite |
|------|--------|
| **Domínio Azure Gratuito** | 500 emails/hora, 10.000/mês |
| **Domínio Personalizado** | Consulte documentação Azure |
| **Rate Limit (código)** | 1 email/30 segundos por IP |

## Custos Estimados

- **Communication Services**: ~$0.0025 USD por email
- **Primeiros 500 emails/mês**: Gratuito
- **App Service**: Conforme plano escolhido

💡 Use [Azure Pricing Calculator](https://azure.microsoft.com/pricing/calculator/) para estimativas detalhadas.

## TODO

- [x] ~~Integrar formulário com backend real~~ ✅ Implementado com Azure Communication Services
- [ ] Adicionar Google Analytics
- [ ] Otimizar imagens para WebP
- [ ] Adicionar sitemap.xml
- [ ] Configurar SSL no Azure
- [ ] Adicionar página de política de privacidade
- [ ] Adicionar testes automatizados (PHPUnit)
- [ ] Implementar cache de respostas
- [ ] Adicionar monitoramento com Application Insights
