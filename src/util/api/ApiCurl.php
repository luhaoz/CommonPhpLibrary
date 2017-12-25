<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/11
 * Time: 9:33
 */

namespace luhaoz\cpl\util\api;

use luhaoz\cpl\prototype\traits\Prototype;
use luhaoz\cpl\util\Curl;

class ApiCurl
{
    use Prototype;

    protected $_parameters = [
        'action'  => [],
        'headers' => [],
    ];
    protected $_headers = [];
    public $host = null;

    protected function parameters($name, $value = null)
    {
        if ($value === null) {
            return $this->_parameters[$name];
        }
        $this->_parameters[$name] = $value;

        return $this;
    }

    public function apiUrl($url)
    {
        return implode('/', [$this->host, $url]);
    }

    public static function url($urlPathInfo)
    {
        $urlPath = [];
        foreach ($urlPathInfo as $pathName => $pathId) {
            if (is_numeric($pathName)) {
                $urlPath[] = $pathId;
            } else {
                $urlPath[] = $pathName . '/' . $pathId;
            }
        }

        return implode('/', $urlPath);
    }


    public function post($url, $data = [])
    {
        $parameters = func_get_args();
        $parameters[0] = $this->apiUrl($url);

        return $this->parameters('action', ['action' => 'post', 'parameters' => $parameters]);
    }

    public function get($url, $data = [])
    {
        $parameters = func_get_args();
        $parameters[0] = $this->apiUrl($url);

        return $this->parameters('action', ['action' => 'get', 'parameters' => $parameters]);
    }

    public function put($url, $data = [], $payload = false)
    {
        $parameters = func_get_args();
        $parameters[0] = $this->apiUrl($url);

        return $this->parameters('action', ['action' => 'put', 'parameters' => $parameters]);
    }

    public function patch($url, $data = [], $payload = false)
    {
        $parameters = func_get_args();
        $parameters[0] = $this->apiUrl($url);

        return $this->parameters('action', ['action' => 'patch', 'parameters' => $parameters]);
    }

    public function delete($url, $data = [], $payload = false)
    {
        $parameters = func_get_args();
        $parameters[0] = $this->apiUrl($url);

        return $this->parameters('action', ['action' => 'delete', 'parameters' => $parameters]);
    }

    public function setHeader($key, $value)
    {
        $this->_headers[$key] = $value;

        return $this->parameters('headers', $this->_headers);
    }


    public function exec()
    {
        $curl = new Curl();
        foreach ($this->parameters('headers') as $headerName => $header) {
            $curl->setHeader($headerName, $header);
        }
        $action = $this->parameters('action');
        call_user_func_array([$curl, $action['action']], $action['parameters']);
        $response = new ApiResponse();
        $response->http_status_code($curl->http_status_code);
        $response->body($curl->response);
        $response->headers($curl->response_headers);

        return $response;
    }
}