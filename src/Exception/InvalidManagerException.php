<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Exception;


/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 22:25
 **/
class InvalidManagerException extends Exception
{

    public function __construct($message = "")
    {
        parent::__construct("InvalidManager : " . $message, self::INVALID_MANAGER_CODE, null);
    }

}