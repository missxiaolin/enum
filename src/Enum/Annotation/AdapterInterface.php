<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/6/8
 * Time: 上午11:04
 */

namespace xiaolin\Enum\Annotation;

interface AdapterInterface
{
    public function __construct($class);

    public function getAnnotationsByName($name, $properties);
}