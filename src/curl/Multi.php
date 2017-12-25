<?php
/**
 * Created by PhpStorm.
 * User: luhaoz
 * Date: 2017/12/22
 * Time: 10:47
 */

namespace luhaoz\cpl\curl;

class Multi
{
    public $multi;
    /**
     * @var Curl[]
     */
    protected $_multiPool = [];

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->multi = curl_multi_init();
        $this->_multiPool = [];
    }

    public function setOpt($option, $value)
    {
        return curl_multi_setopt($this->multi, $option, $value);
    }

    /**
     * @param Curl $curl
     * @return Curl
     */
    public function add(Curl $curl)
    {
        $curl->multi = true;
        array_push($this->_multiPool, $curl);
        curl_multi_add_handle($this->multi, $curl->curl);
        return $curl;
    }

    /**
     * @return Curl
     */
    public function curl()
    {
        return $this->add(new Curl());
    }

    protected function exec()
    {
        $running = null;
        do {
            curl_multi_exec($this->multi, $running);
            curl_multi_select($this->multi);
        } while ($running > 0);

        foreach ($this->_multiPool as $curl) {
            curl_multi_remove_handle($this->multi, $curl->curl);
            $curl->exec(['response' => curl_multi_getcontent($curl->curl)]);
        }

        return $running;
    }

    public function run()
    {
        return $this->exec();
    }

    public function infoRead()
    {
        return curl_multi_info_read($this->multi);
    }


    public function reset()
    {
        $this->close();

        $this->init();
        return $this;
    }

    public function close()
    {
        if (is_resource($this->multi)) {
            curl_multi_close($this->multi);
        }
        return $this;
    }

    public function __destruct()
    {
        $this->close();
    }
}