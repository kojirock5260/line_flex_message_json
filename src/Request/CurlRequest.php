<?php


namespace Kojirock5260\SimpleLineFlexMessage\Request;


class CurlRequest
{
    /**
     * @var resource
     */
    private $ch;

    /**
     * init.
     * @param string $url
     */
    public function init($url = null)
    {
        $this->ch = curl_init($url);
    }

    /**
     * execute.
     * @return bool|string
     */
    public function execute()
    {
        return curl_exec($this->ch);
    }

    /**
     * errorString.
     * @return string
     */
    public function errorString()
    {
        return curl_error($this->ch);
    }

    /**
     * errorNumber.
     * @return int
     */
    public function errorNumber()
    {
        return curl_errno($this->ch);
    }

    /**
     * close.
     */
    public function close()
    {
        curl_close($this->ch);
        $this->ch = null;
    }

    /**
     * setOption.
     * @param int $key
     * @param mixed $value
     */
    public function setOption($key, $value)
    {
        curl_setopt($this->ch, $key, $value);
    }

    /**
     * setOptionArray.
     * @param array $values
     */
    public function setOptionArray(array $values)
    {
        curl_setopt_array($this->ch, $values);
    }
}