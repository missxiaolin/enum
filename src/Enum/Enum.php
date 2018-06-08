<?php

namespace xiaolin\Enum;
// +----------------------------------------------------------------------
// | EnumException.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 xiaolin All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <462441355@qq.com> <https://github.com/missxiaolin>
// +----------------------------------------------------------------------

use ReflectionClass;
use xiaolin\Enum\Annotation\AdapterInterface;
use xiaolin\Enum\Annotation\PhalconAdapter;
use xiaolin\Enum\Annotation\ReflectionAdapter;
use xiaolin\Enum\Common\InstanceTrait;
use xiaolin\Enum\Common\Str;
use xiaolin\Enum\Exception\EnumException;

abstract class Enum
{
    use InstanceTrait;

    public static $_instance;

    /** @var AdapterInterface */
    public $_adapter;

    protected $phalconExtEnable = true;

    private function __construct()
    {
        if ($this->phalconExtEnable && extension_loaded('phalcon')) {
            $this->_adapter = new PhalconAdapter(static::class);
        } else {
            $this->_adapter = new ReflectionAdapter(static::class);
        }
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws EnumException
     * @throws \ReflectionException
     */
    public static function __callStatic($method, $arguments)
    {
        return static::getInstance()->$method(...$arguments);
    }


    /**
     * @param $name
     * @param $arguments
     * @return string
     * @throws EnumException
     * @throws \ReflectionException
     */
    public function __call($name, $arguments)
    {
        $arr = [];

        if (!Str::startsWith($name, 'get')) {
            throw new EnumException('The function is not defined!');
        }
        if (!isset($arguments) || count($arguments) === 0) {
            throw new EnumException('The Code is required');
        }

        $code = $arguments[0];
        $name = strtolower(substr($name, 3));

        if (isset($this->$name)) {
            return isset($this->$name[$code]) ? $this->$name[$code] : '';
        }

        // 获取变量
        $ref = new ReflectionClass(static::class);
        $properties = $ref->getDefaultProperties();
        $arr = $this->_adapter->getAnnotationsByName($name, $properties);

        if (version_compare(PHP_VERSION, 7, '<')) {
            // 版本小于7
            return isset($arr[$code]) ? $arr[$code] : '';
        }

        $this->$name = $arr;

        return isset($this->$name[$code]) ? $this->$name[$code] : '';
    }
}