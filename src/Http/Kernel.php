<?php

namespace Shappy\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        require_once './src/Utils/Globals.php';
        require_once './routes.php';

        $response = $router->handleRequest($request);
        
        return new Response($response);
    }
}
