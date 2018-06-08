<?php
namespace xiaolin\Enum;
// +----------------------------------------------------------------------
// | EnumException.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 xiaolin All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <462441355@qq.com> <https://github.com/missxiaolin>
// +----------------------------------------------------------------------

use Phalcon\Text;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use ReflectionClass;
use xiaolin\Enum\Exception\EnumException;

abstract class Enum
{
    public static $_instance;

    public $_adapter = 'memory';

    public $_expire = 3600;

    protected $_annotation;

    protected $phalconExtEnable = true;

    /**
     * Enum constructor.
     */
    public function __construct()
    {
        $this->_annotation = new Annotation($this->phalconExtEnable);
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (isset(static::$_instance) && static::$_instance instanceof Enum) {
            return static::$_instance;
        }

        return static::$_instance = new static();
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
        if (!Text::startsWith($name, 'get')) {
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

        // 获取注释
        $adapter = new MemoryAdapter();
        $reflection = $adapter->get(static::class);
        $annotations = $reflection->getPropertiesAnnotations();

        // 获取变量
        $ref = new ReflectionClass(static::class);
        $properties = $ref->getDefaultProperties();
        $arr = [];
        foreach ($properties as $key => $val) {
            if (Text::startsWith($key, 'ENUM_') && isset($annotations[$key])) {
                // 获取对应注释
                $ret = $annotations[$key]->get(Text::camelize($name));
                $arr[$val] = $ret->getArgument(0);
            }
        }

        if (version_compare(PHP_VERSION, 7, '<')) {
            // 版本小于7
            return isset($arr[$code]) ? $arr[$code] : '';
        }

        $this->$name = $arr;

        return isset($this->$name[$code]) ? $this->$name[$code] : '';
    }
}