<?php

use App\Constants\GeneralConstant;

function loadMessages($filePath): array
{
    if (! file_exists($filePath)) {
        throw new Exception('Messages file not found.');
    }

    $jsonContent = file_get_contents($filePath);
    $messages = json_decode($jsonContent, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error decoding JSON: '.json_last_error_msg());
    }

    return $messages;
}

function getMessage(string $key, array $params = []): string
{
    static $messages = null;

    if ($messages === null) {
        $messages = loadMessages(GeneralConstant::MESSAGE_SOURCE);
    }

    $message = $messages[$key] ?? 'Message not found';

    foreach ($params as $paramKey => $paramValue) {
        $message = str_replace('{'.$paramKey.'}', $paramValue, $message);
    }

    return $message;
}

function env(string $key,string $default = null)
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../..');
    $dotenv->load();
    return $_ENV[$key] ?? $default;
}