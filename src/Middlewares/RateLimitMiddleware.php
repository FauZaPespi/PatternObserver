<?php

namespace Makosc\Observer\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

class RateLimitMiddleware
{
    private int $maxRequests;
    private int $timeWindow; // In seconds
    private string $storagePath;

    /**
     * @param int $maxRequests Maximum number of requests allowed.
     * @param int $timeWindow Time window in seconds.
     */
    public function __construct(int $maxRequests = 10, int $timeWindow = 60)
    {
        $this->maxRequests = $maxRequests;
        $this->timeWindow = $timeWindow;
        $this->storagePath = __DIR__ . '/../../rate-limit.json';
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown';

        $file = fopen($this->storagePath, 'c+');
        if (!$file) {
            // Log error or handle case where file cannot be opened.
            // For now, we'll let the request pass.
            return $handler->handle($request);
        }

        // Lock the file to prevent race conditions
        if (flock($file, LOCK_EX)) {
            $content = stream_get_contents($file);
            $data = json_decode($content, true) ?: [];
            
            $currentTime = time();

            // Prune old entries for all IPs
            foreach ($data as $key => &$timestamps) {
                $timestamps = array_filter($timestamps, function ($timestamp) use ($currentTime) {
                    return ($currentTime - $timestamp) < $this->timeWindow;
                });
                if (empty($timestamps)) {
                    unset($data[$key]);
                }
            }
            unset($timestamps); // Unset reference

            $userTimestamps = $data[$ip] ?? [];

            if (count($userTimestamps) >= $this->maxRequests) {
                flock($file, LOCK_UN);
                fclose($file);

                $response = new SlimResponse();
                $response->getBody()->write('Too Many Requests');
                return $response->withStatus(429, 'Too Many Requests');
            }

            // Add the current request's timestamp
            $data[$ip][] = $currentTime;

            // Write the updated data back to the file
            fseek($file, 0);
            fwrite($file, json_encode($data, JSON_PRETTY_PRINT));
            ftruncate($file, ftell($file));

            // Release the lock
            flock($file, LOCK_UN);
        }

        fclose($file);

        return $handler->handle($request);
    }
}