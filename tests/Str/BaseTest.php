<?php

namespace Tests\Str;
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 xiaolin All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaolin <462441355@qq.com> <https://github.com/missxiaolin>
// +----------------------------------------------------------------------


use PHPUnit\Framework\TestCase;
use Tests\App\ErrorCode;
use Tests\App\ErrorCode2;
use Tests\App\ErrorCodeNoPhalcon;

class BaseTest extends TestCase
{
    public function testAscii()
    {
        $this->assertEquals(700, ErrorCode::$ENUM_INVALID_TOKEN);
    }

    public function testMessage()
    {
        $this->assertEquals('非法的TOKEN', ErrorCode::getMessage(ErrorCode::$ENUM_INVALID_TOKEN));
    }

    public function testDesc()
    {
        $this->assertEquals('需要重新登录', ErrorCode::getDesc(ErrorCode::$ENUM_INVALID_TOKEN));
    }

    public function testTwoEnum()
    {
        $code = ErrorCode::$ENUM_INVALID_TOKEN;
        $msg1 = ErrorCode2::getMessage($code);
        $msg2 = ErrorCode::getMessage($code);

        $this->assertEquals('非法的TOKEN', $msg2);
        $this->assertEquals('非法的TOKEN 2', $msg1);

    }

    public function testNoPhalconExt()
    {
        $code = ErrorCode::$ENUM_INVALID_TOKEN;
        $res = ErrorCodeNoPhalcon::getMessage($code);
        $res2 = ErrorCode::getMessage($code);
        $this->assertEquals($res, $res2);

        $res = ErrorCodeNoPhalcon::getDesc($code);
        $res2 = ErrorCode::getDesc($code);
        $this->assertEquals($res, $res2);
    }
}