<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    respond(405, ['error' => 'Método não permitido. Utilize GET.']);
}

$input = $_GET['cep'] ?? '';
if (!is_string($input) || !preg_match('/^[0-9]{5}-?[0-9]{3}$/D', trim($input))) {
    respond(400, ['error' => 'Informe um CEP válido com 8 números.']);
}
$cep = str_replace('-', '', trim($input));
$url = 'https://viacep.com.br/ws/' . $cep . '/json/';

try {
    if (function_exists('curl_init')) {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 12,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);
        $json = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($json === false || $status !== 200) {
            throw new RuntimeException('Falha na consulta HTTP.');
        }
    } else {
        $context = stream_context_create([
            'http' => ['method' => 'GET', 'timeout' => 12, 'header' => "Accept: application/json\r\n", 'follow_location' => 0],
            'ssl' => ['verify_peer' => true, 'verify_peer_name' => true],
        ]);
        $json = @file_get_contents($url, false, $context);
        if ($json === false) {
            throw new RuntimeException('Falha na consulta HTTP.');
        }
    }
    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($data)) {
        throw new RuntimeException('Resposta inesperada.');
    }
    if (!empty($data['erro'])) {
        respond(404, ['error' => 'CEP não encontrado. Confira os números e tente novamente.']);
    }
    foreach (['cep', 'localidade', 'uf'] as $required) {
        if (empty($data[$required]) || !is_string($data[$required])) {
            throw new RuntimeException('Resposta incompleta.');
        }
    }
    $address = [];
    foreach (['cep', 'logradouro', 'bairro', 'localidade', 'uf', 'complemento'] as $field) {
        $address[$field] = isset($data[$field]) && is_string($data[$field]) ? $data[$field] : '';
    }
    respond(200, ['data' => $address]);
} catch (Throwable $exception) {
    respond(502, ['error' => 'Não foi possível consultar o ViaCEP agora. Tente novamente em instantes.']);
}
