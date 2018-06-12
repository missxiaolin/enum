<?php

namespace Tests\App;
// +----------------------------------------------------------------------
// | ErrorCode.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 xiaolin All rights reserved.
// +----------------------------------------------------------------------
// | Author: xl <462441355@qq.com> <https://github.com/missxiaolin>
// +----------------------------------------------------------------------

use xiaolin\Enum\Enum;

class ErrorCodeNoPhalcon extends Enum
{
    /**
     * @Message('非法的TOKEN')
     * @Desc('需要重新登录')
     */
    public static $ENUM_INVALID_TOKEN = 700;
}