<?php

namespace CloudDix;

class AzureCommunicationEmail
{
    private string $endpoint;
    private string $accessKey;
    private string $apiVersion = '2023-03-31';

    public function __construct(string $connectionString)
    {
        $this->parseConnectionString($connectionString);
    }

    private function parseConnectionString(string $connectionString): void
    {
        $parts = [];
        foreach (explode(';', $connectionString) as $part) {
            $keyValue = explode('=', $part, 2);
            if (count($keyValue) === 2) {
                $parts[strtolower(trim($keyValue[0]))] = trim($keyValue[1]);
            }
        }

        if (!isset($parts['endpoint']) || !isset($parts['accesskey'])) {
            throw new \InvalidArgumentException('Connection string inválida');
        }

        $this->endpoint = rtrim($parts['endpoint'], '/');
        $this->accessKey = $parts['accesskey'];
    }

    public function sendEmail(array $message): array
    {
        $url = $this->endpoint . '/emails:send?api-version=' . $this->apiVersion;
        
        // Prepara o payload
        $payload = json_encode($message);
        
        // Gera timestamp e hash do conteúdo
        $utcNow = gmdate('D, d M Y H:i:s \G\M\T');
        $host = parse_url($this->endpoint, PHP_URL_HOST);
        $pathAndQuery = '/emails:send?api-version=' . $this->apiVersion;
        $contentHash = base64_encode(hash('sha256', $payload, true));
        
        // String para assinar (formato correto do Azure)
        $stringToSign = "POST\n{$pathAndQuery}\n{$utcNow};{$host};{$contentHash}";
        
        // Gera assinatura HMAC-SHA256
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode($this->accessKey), true));
        
        // Headers conforme documentação do Azure
        $headers = [
            'Content-Type: application/json',
            'Host: ' . $host,
            'x-ms-date: ' . $utcNow,
            'x-ms-content-sha256: ' . $contentHash,
            'Authorization: HMAC-SHA256 SignedHeaders=x-ms-date;host;x-ms-content-sha256&Signature=' . $signature
        ];

        // Faz a requisição
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("Erro cURL: {$error}");
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            $errorMessage = "Erro HTTP {$httpCode}";
            if ($response) {
                $errorData = json_decode($response, true);
                if (isset($errorData['error']['message'])) {
                    $errorMessage .= ": " . $errorData['error']['message'];
                } else {
                    $errorMessage .= ". Response: " . $response;
                }
            }
            throw new \RuntimeException($errorMessage);
        }

        // Retorna o ID da operação
        $result = json_decode($response, true);
        return $result ?? ['id' => 'unknown'];
    }

    public function checkStatus(string $operationId): array
    {
        $url = $this->endpoint . '/emails/operations/' . $operationId . '?api-version=' . $this->apiVersion;
        
        $utcNow = gmdate('D, d M Y H:i:s \G\M\T');
        $pathAndQuery = parse_url($url, PHP_URL_PATH) . '?' . parse_url($url, PHP_URL_QUERY);
        $contentHash = base64_encode(hash('sha256', '', true));
        
        $stringToSign = "GET\n{$pathAndQuery}\n{$utcNow};{$this->endpoint};{$contentHash}";
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode($this->accessKey), true));
        
        $headers = [
            'x-ms-date: ' . $utcNow,
            'x-ms-content-sha256: ' . $contentHash,
            'Authorization: HMAC-SHA256 SignedHeaders=x-ms-date;host;x-ms-content-sha256&Signature=' . $signature
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true) ?? [];
        }

        return ['status' => 'Unknown'];
    }
}
