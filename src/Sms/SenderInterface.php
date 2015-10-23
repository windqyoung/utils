<?php



namespace Windqyoung\Utils\Sms;


/**
 * 短信接口.
 * @author windq
 */
interface SenderInterface
{
    public function send($mobile, $message);
}