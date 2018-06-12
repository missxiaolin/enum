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

    public function getAnnotationsByName($name, $properties)
    {
        $adapter = new MemoryAdapter();
        $reflection = $adapter->get($this->class);
        $annotations = $reflection->getPropertiesAnnotations();

        $result = [];
        foreach ($properties as $key => $val) {
            $isValid = Text::startsWith($key, 'ENUM_') // 必须以ENUM_开头
                && isset($annotations[$key]) // 当前字段存在注释
                && $annotations[$key]->has(Text::camelize($name)); // 当前字段存在此注解的注释

            if ($isValid) {
                // 获取对应注释
                $ret = $annotations[$key]->get(Text::camelize($name));
                $result[$val] = $ret->getArgument(0);

            }
        }

        return $result;
    }
}