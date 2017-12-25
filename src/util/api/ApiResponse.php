<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/9/11
 * Time: 9:33
 */

namespace luhaoz\cpl\util\api;

use luhaoz\cpl\prototype\traits\Prototype;

class ApiResponse
{
    use Prototype;

    protected $_http_status_code;
    protected $_headers = [];
    protected $_body;


    public function headers($headers = null)
    {
        if ($headers != null) {
            $this->_headers = $headers;
        }

        return $this->_headers;
    }

    public function http_status_code($code = null)
    {
        if ($code != null) {
            $this->_http_status_code = $code;
        }

        return $this->_http_status_code;
    }

    public function body($body = null)
    {
        if ($body != null) {
            $this->_body = $body;
        }

        return $this->_body;
    }


    /**
     * Was an 'info' header returned.
     * @return bool
     */
    public function isInfo()
    {
        return $this->http_status_code >= 100 && $this->http_status_code < 200;
    }

    /**
     * Was an 'OK' response returned.
     * @return bool
     */
    public function isSuccess()
    {
        return $this->http_status_code >= 200 && $this->http_status_code < 300;
    }

    /**
     * Was a 'redirect' returned.
     * @return bool
     */
    public function isRedirect()
    {
        return $this->http_status_code >= 300 && $this->http_status_code < 400;
    }

    /**
     * Was an 'error' returned (client error or server error).
     * @return bool
     */
    public function isError()
    {
        return $this->http_status_code >= 400 && $this->http_status_code < 600;
    }

    /**
     * Was a 'client error' returned.
     * @return bool
     */
    public function isClientError()
    {
        return $this->http_status_code >= 400 && $this->http_status_code < 500;
    }

    /**
     * Was a 'server error' returned.
     * @return bool
     */
    public function isServerError()
    {
        return $this->http_status_code >= 500 && $this->http_status_code < 600;
    }
}