<?php
include('./JWT/JWT.php');

$json = file_get_contents('route.config.json');
$routes = json_decode($json);

$resource = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// réception des routes
$result = array_filter($routes, function ($route) use ($resource, $method) {
    return preg_match('#^' . $route->path . '$#', $resource) && $route->method == $method;
});

if (count($result) == 0 || count($result) > 1) {
    throw new Exception("Route not found");
}

$currentRoute = array_shift($result);

// middleware
// Vérification de l'authentification
if (!empty($currentRoute->auth) && $currentRoute->auth == true) { // route nécessite un token ("auth": true dans route.config.json)
    $headers = apache_request_headers();
    if (!isset($headers['authorization'])) {
        // Si pas de header Authorization envoyé → client pas connecté du tout
        $error = "User must be login for this action";
        include('./view/error.json.php');
        exit;
    }
    $authorization = explode(" ", $headers['authorization']);
    // // $authorization[0] = "Bearer", $authorization[1] = le token réel
    try {
        // Vérifie signature + expiration avec la même clé que login()
        JWT::decode($authorization[1], JWT_SECRET, array("HS256"));
        // Si valide le code continue vers le controller
    } catch (Exception $e) {
        // Token invalide ou expiré → erreur lors de decode()
        $error = $e->getMessage();
        include('./view/error.json.php');
        exit;
    }
}

preg_match('#^' . $currentRoute->path . '$#', $resource, $match);

include_once('./controller/' . $currentRoute->controller . '.controller.php');

$controllerName = strtoupper($currentRoute->controller[0]) . substr($currentRoute->controller, 1) . 'Controller';
try {
    $controller = new $controllerName();

    if (!empty($match[1])) {
        $controller->{$currentRoute->action}($match[1]);
    } else {
        $controller->{$currentRoute->action}();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    include('./view/error.json.php');
}