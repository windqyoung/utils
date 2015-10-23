<?php


namespace Windqyoung\Utils\Sms;


/**
 * 发送短信
 * @author windq
 */
class Sender implements SenderInterface
{
    /**
     * 发送返回的结果
     * @var string
     */
    private $sendResult;

    /**
     * 生成发送数据的函数
     * @var callable
     */
    private $sendDataBuilder;

    /**
     * 执行发送, 如果此变量不是callable, 那使用file_get_contents来访问url
     * @var callable
     */
    private $doSend;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @return the $sendResult
     */
    public function getSendResult()
    {
        return $this->sendResult;
    }

    /**
     * @param callable $sendDataBuilder
     */
    public function setSendDataBuilder($sendDataBuilder)
    {
        $this->sendDataBuilder = $sendDataBuilder;
    }

    /**
     * @param \Monolog\Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param callable $doSend
     */
    public function setDoSend($doSend)
    {
        $this->doSend = $doSend;
    }

    /**
     * 构造要发送的内容
     * @param string $mobile
     * @param string $message
     * @throws \InvalidArgumentException
     * @return mixed
     */
    protected function buildSendData($mobile, $message)
    {
        if (! is_callable($this->sendDataBuilder))
        {
            throw new \InvalidArgumentException('错误的数据生成函数');
        }

        return call_user_func($this->sendDataBuilder, $mobile, $message);
    }

    public function send($mobile, $message)
    {
        $data = $this->buildSendData($mobile, $message);

        $this->sendResult = $this->doSend($data);

        if ($this->logger)
        {
            $this->logger->debug('发送短信', [
                'mobile' => $mobile,
                'message' => $message,
                'result' => $this->sendResult,
                'method' => __METHOD__,
            ]);
        }
    }

    /**
     * 执行发送功能
     * @param mixed|string $data
     * @return mixed
     */
    protected function doSend($data)
    {
        if (is_callable($this->doSend))
        {
            return call_user_func($this->doSend, $data);
        }

        return file_get_contents($data);
    }



}



