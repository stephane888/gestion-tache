<?php
use Stephane888\Authen\Request;
// header('Content-Type: application/json');
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * config commandes
 */
$results = [];
$data = json_decode(file_get_contents('php://input'), true);
$_Request = new Request($_SERVER['HTTP_X_CSRF_TOKEN'], $data);
$results['return'] = $_Request->result;
$results['configs'] = $data;

$results = json_encode($results);

/**
 *
 * @var \Symfony\Component\HttpFoundation\JsonResponse $response
 */
$response = new JsonResponse();
$response->setContent($results);
$response->headers->set('Content-Type', 'application/json; charset=UTF-8');
if ($code = $_Request->getCodeAjax()) {
  if ($title = $_Request->getStatusText()) {
    $response->setStatusCode($code, rawurlencode($title));
  } else {
    $response->setStatusCode($code);
  }
}

// $response->setCharset('UTF-8');
$response->send();
