<?php

namespace Pierstoval\Bundle\ApiBundle\Services;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OriginChecker {

    /**
     * @var array
     */
    private $allowedOrigins;

    /**
     * @var string
     */
    private $kernelEnvironment;

    public function __construct(array $allowedOrigins, $kernelEnvironment)
    {
        $this->allowedOrigins = $allowedOrigins;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    /**
     * @param Request $request
     * @throws AccessDeniedException
     */
    public function checkRequest(Request $request)
    {
        $allowedOrigins = $this->allowedOrigins;

        if (strpos($this->kernelEnvironment, 'dev') !== 0) {
            // Autorise depuis l'environnement local si on est en mode dev
            $allowedOrigins[] = '127.0.0.1';
            $allowedOrigins[] = 'localhost';
        }

        // Ajoute également le serveur courant et l'hôte courant aux autorisations (pour les requêtes internes)
        $allowedOrigins[] = $request->server->get('SERVER_ADDR');
        $host = $request->getHost();
        if (!in_array($host, $allowedOrigins)) {
            $allowedOrigins[] = $host;
        }

        // Définira si une url est matchée ou non
        $match = false;

        // Vérifie le header Origin
        if ($request->headers->has('Origin')) {
            $origin = $request->headers->get('Origin');
            $origin = preg_replace('~https?://~isUu', '', $origin);
            $origin = trim($origin, '/');
            // Vérifie si le header Origin est correct
            foreach ($allowedOrigins as $address) {
                if ($origin === $address) {
                    $match = true;
                }
            }
        }

        // Vérifie l'adresse IP de l'utilisateur
        $remoteAddr = $request->server->get('REMOTE_ADDR');
        foreach ($allowedOrigins as $address) {
            if ($remoteAddr === $address) {
                $match = true;
            }
        }

        if ($match === false) {
            throw new AccessDeniedException('Origin not allowed.');
        }

    }

} 