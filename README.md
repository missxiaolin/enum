# enum

## 安装

~~~
composer require xiaolin/enum
~~~

## 使用

### 定义枚举类

~~~
use xiaolin\Enum\Enum;
class ErrorCode extends Enum
{
    /**
     * @Message('非法的TOKEN')
     */
    public static $ENUM_INVALID_TOKEN = 700;
}
~~~

~~~
$code = ErrorCode::$ENUM_INVALID_TOKEN;
$message = ErrorCode::getMessage($code);
~~~

