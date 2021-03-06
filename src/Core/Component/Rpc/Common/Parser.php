<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/22
 * Time: 下午2:00
 */

namespace EasySwoole\Core\Component\Rpc\Common;


use EasySwoole\Core\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Core\Socket\Common\CommandBean;
use Rpc\A;

class Parser implements ParserInterface
{
    protected $services = [];
    function __construct(array $services)
    {
        $this->services = $services;
    }

    public function decode($raw, $client)
    {
        // TODO: Implement decode() method.
        $raw = $this->decodeRawData($raw);
        $json = json_decode($raw,true);
        if(is_array($json)){
            $bean = new CommandBean($json);
            if(isset($this->services[$bean->getControllerClass()])){
                $bean->setControllerClass($this->services[$bean->getControllerClass()]);
                return $bean;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function decodeRawData($raw)
    {
        return substr($raw, 4);
    }

    public function encodeRawData($sendStr)
    {
        return pack('N', strlen($sendStr)).$sendStr;
    }

    public function encode(string $sendStr, $client):?string
    {
        // TODO: Implement encode() method.
        return pack('N', strlen($sendStr)).$sendStr;
    }
}