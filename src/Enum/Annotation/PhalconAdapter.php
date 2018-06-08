<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/6/8
 * Time: 上午10:38
 */

namespace xiaolin\Enum\Annotation;

use Phalcon\Text;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

class PhalconAdapter implements AdapterInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param $name
     * @param $properties
     * @return array
     */
    public function getAnnotationsByName($name, $properties)
    {
        $adapter = new MemoryAdapter();
        $reflection = $adapter->get($this->class);
        $annotations = $reflection->getPropertiesAnnotations();

        $arr = [];
        foreach ($properties as $key => $val) {
            if (Text::startsWith($key, 'ENUM_') && isset($annotations[$key])) {
                // 获取对应注释
                $ret = $annotations[$key]->get(Text::camelize($name));
                $arr[$val] = $ret->getArgument(0);
            }
        }

        return $arr;
    }
}