<?php
require_once __DIR__ . '/vendor/autoload.php';

use CloudDix\AzureCommunicationEmail;

// Carrega variáveis do .env se existir (para desenvolvimento local)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            putenv($line);
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

header('Content-Type: application/json');

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

// Recebe os dados do formulário
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
$assunto = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING);
$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

// Validação básica
if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos obrigatórios.']);
    exit;
}

// Valida email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email inválido.']);
    exit;
}

try {
    // Configurações do Azure Communication Services
    $connectionString = getenv('AZURE_COMMUNICATION_CONNECTION_STRING') ?: $_ENV['AZURE_COMMUNICATION_CONNECTION_STRING'] ?? null;
    
    if (!$connectionString) {
        throw new Exception('Connection string do Azure Communication Services não configurada');
    }

    // Email de origem (precisa ser configurado no Azure Communication Services)
    $senderAddress = getenv('SENDER_EMAIL') ?: 'DoNotReply@clouddix.com';
    $recipientAddress = 'comercial@clouddix.com';

    // Monta o corpo do email em HTML
    $htmlBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 0 auto; }
            .header { background: linear-gradient(135deg, #8855f5 0%, #6b41b8 100%); color: white; padding: 30px 20px; text-align: center; }
            .header h1 { margin: 0; font-size: 24px; }
            .content { background: #ffffff; padding: 30px; }
            .field { margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #8855f5; }
            .label { font-weight: bold; color: #6b41b8; font-size: 14px; text-transform: uppercase; margin-bottom: 5px; }
            .value { margin-top: 8px; font-size: 16px; color: #333; }
            .footer { background: #333; color: #fff; padding: 20px; text-align: center; font-size: 12px; }
            .footer a { color: #8855f5; text-decoration: none; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>📧 Nova Mensagem do Site</h1>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Nome</div>
                    <div class='value'>" . htmlspecialchars($nome) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Email de Contato</div>
                    <div class='value'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></div>
                </div>
                <div class='field'>
                    <div class='label'>Empresa</div>
                    <div class='value'>" . htmlspecialchars($empresa ?: 'Não informada') . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Assunto</div>
                    <div class='value'>" . htmlspecialchars($assunto) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Mensagem</div>
                    <div class='value'>" . nl2br(htmlspecialchars($mensagem)) . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>Mensagem enviada via formulário de contato CloudDix</p>
                <p>Data/Hora: " . date('d/m/Y H:i:s') . "</p>
                <p><a href='https://clouddix.com.br'>clouddix.com.br</a></p>
            </div>
        </div>
    </body>
    </html>
    ";

    // Corpo em texto plano (fallback)
    $plainTextBody = "Nova mensagem recebida do site CloudDix\n\n";
    $plainTextBody .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $plainTextBody .= "NOME: " . $nome . "\n\n";
    $plainTextBody .= "EMAIL: " . $email . "\n\n";
    $plainTextBody .= "EMPRESA: " . ($empresa ?: 'Não informada') . "\n\n";
    $plainTextBody .= "ASSUNTO: " . $assunto . "\n\n";
    $plainTextBody .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $plainTextBody .= "MENSAGEM:\n\n" . $mensagem . "\n\n";
    $plainTextBody .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $plainTextBody .= "Enviado em: " . date('d/m/Y H:i:s') . "\n";
    $plainTextBody .= "Site: https://clouddix.com.br\n";

    // Inicializa o cliente do Azure Communication Services
    $emailClient = new AzureCommunicationEmail($connectionString);

    // Prepara a mensagem
    $emailMessage = [
        'senderAddress' => $senderAddress,
        'content' => [
            'subject' => 'Contato Site Clouddix: ' . $assunto,
            'plainText' => $plainTextBody,
            'html' => $htmlBody
        ],
        'recipients' => [
            'to' => [
                ['address' => $recipientAddress, 'displayName' => 'Equipe Clouddix']
            ]
        ],
        'replyTo' => [
            ['address' => $email, 'displayName' => $nome]
        ]
    ];

    // Envia o email
    $result = $emailClient->sendEmail($emailMessage);

    // Retorna sucesso
    echo json_encode([
        'success' => true, 
        'message' => 'Mensagem enviada com sucesso! Entraremos em contato em breve.',
        'messageId' => $result['id'] ?? 'sent'
    ]);

} catch (Exception $e) {
    // Log do erro para debug (em produção, usar um sistema de logs adequado)
    error_log("Erro ao enviar email via Azure Communication Services: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Erro ao enviar mensagem. Tente novamente ou entre em contato via WhatsApp.',
        'error' => $e->getMessage() // Remover em produção
    ]);
}
