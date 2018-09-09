<?php
/**
 * @author d.ivaschenko
 */

namespace PrototypApp;

/**
 * Class Response
 * @package PrototypApp
 *
 */
class Response
{
    /**
     * @param string $message
     * @param int $code
     * @return array
     */
    public function sendString(string $message, int $code = 200): array
    {
        http_response_code($code);
        return [
            'message' => $message
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendJson(array $data): array
    {
        http_response_code(200);
        return [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'message' => json_encode($data)
        ];
    }


}