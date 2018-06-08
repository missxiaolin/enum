<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/6/8
 * Time: 上午10:38
 */

namespace xiaolin\Enum\Annotation;

use Phalcon\Text;
use ReflectionProperty;

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
     * @throws \ReflectionException
     */
    public function getAnnotationsByName($name, $properties)
    {
        $result = [];
        foreach ($properties as $key => $val) {
            if (Text::startsWith($key, 'ENUM_')) {
                // 获取对应注释
                $ret = new ReflectionProperty($this->class, $key);
                $result[$val] = $this->getCommentByName($ret->getDocComment(), $name);
            }
        }

        return $result;
    }

    /**
     * 根据name解析doc获取对应注释
     * @param $doc
     * @param $name
     * @return null
     */
    protected function getCommentByName($doc, $name)
    {
        $name = Text::camelize($name);
        $pattern = "/\@{$name}\(\'(.*)\'\)/U";
        if (preg_match($pattern, $doc, $result)) {
            if (isset($result[1])) {
                return $result[1];
            }
        }
        return null;
    }
}