<?php

namespace Shappy\Http;

class Request
{

  public function __construct(
    protected array $input = [],
    protected array $files = [],
    protected array $headers = []
  ) {
  }

  public static function capture()
  {
    $input = $_REQUEST;
    $files = $_FILES;
    $headers = getallheaders();

    return new self($input, $files, $headers);
  }

  public function input($key, $default = null)
  {
    $_SESSION['_old_input'][$key] = $this->input[$key];
    return $this->sanitize($this->input[$key]) ?? $default;
  }

  public function file($key)
  {
    return $this->files[$key] ?? null;
  }

  public function header($key)
  {
    return $this->headers[$key] ?? null;
  }

  public function all()
  {
    return [
      'input' => $this->input,
      'files' => $this->files,
      'headers' => $this->headers,
    ];
  }

  public function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function getPathInfo()
  {
    $pathInfo = $_SERVER['REQUEST_URI'];
    $scriptName = $_SERVER['SCRIPT_NAME'];

    if (strpos($pathInfo, $scriptName) === 0) {
      $pathInfo = substr($pathInfo, strlen($scriptName));
    }

    return $pathInfo;
  }


  private function sanitize($input)
  {
    if(is_string($input))
      return trim($input);
    
    return $input;
  }

}
