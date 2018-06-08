<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2018/6/8
 * Time: 上午10:35
 */

namespace xiaolin\Enum;


class Annotation implements AnnotationInterface
{
    protected $phalconEnable;

    /**
     * Annotation constructor.
     * @param $phalconExtEnable Phalcon扩展是否可用
     */
    public function __construct($phalconExtEnable)
    {

    }

    public function getAnnotationByName($name)
    {
    }
}