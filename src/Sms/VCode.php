<?php



namespace Windqyoung\Utils\Sms;

/**
 * 负责管理短信验证码
 * @author windq
 */
class VCode
{
    /**
     * 保存验证码的对象, 实现下面几个方法即可
     * @var \Illuminate\Cache\Repository
     */
    private $store;

    /**
     * 短信发送的对象, 需要发送验证码时设置
     * @var SenderInterface
     */
    private $sender;

    /**
     * 验证码多长时间失效
     * @var int 单位分种
     */
    private $cacheMinutes = 5;

    /**
     * 用于根据验证码来生成发送的验证码消息字符串
     * @var callback
     */
    private $codeMessageBuilder;


    /**
     * 生成一个新的验证码
     * @var callable
     */
    private $codeGenerator;

    /**
     * 在缓存中保存验证码的前缀
     * @var string
     */
    private $cacheKeyPrefix = 'vcode';


    /**
     * @param callable $codeGenerator
     */
    public function setCodeGenerator($codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * @param string $cacheKeyPrefix
     */
    public function setCacheKeyPrefix($cacheKeyPrefix)
    {
        $this->cacheKeyPrefix = $cacheKeyPrefix;
    }

    /**
     * 一个函数, 用来构造验证码短信内容
     * @param callback $codeMessageBuilder
     */
    public function setCodeMessageBuilder($codeMessageBuilder)
    {
        $this->codeMessageBuilder = $codeMessageBuilder;
    }

    /**
     * 验证码如何过期, 本类是使用缓存来过期
     * @param int $cacheMinutes
     */
    public function setCacheMinutes($cacheMinutes)
    {
        $this->cacheMinutes = $cacheMinutes;
    }

    /**
     * 验证码保存在何处
     * @param \Illuminate\Session\Store $store
     */
    public function setStore($store)
    {
        $this->store = $store;
    }

    /**
     * @param SenderInterface $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * 发送验证码
     * @param string $mobile
     * @param string $bag
     */
    public function send($mobile, $bag = 'default')
    {
        // 取缓存
        $code = $this->getCodeFromCache($mobile, $bag, function () use ($mobile, $bag) {
            $code = $this->generateCode();
            // 保存缓存, 在这儿缓存, 有效期按第一次发送时开始计时
            $this->putCodeToCache($mobile, $code, $bag);

            return $code;
        });

        return $this->sender->send($mobile, $this->buildCodeMessage($code));
    }

    /**
     * 生成一个验证码
     */
    public function generateCode()
    {
        if (is_callable($this->codeGenerator))
        {
            return call_user_func($this->codeGenerator);
        }

        return mt_rand(100000, 999999);
    }

    public function value($value)
    {
        if (is_callable($value))
        {
            return call_user_func($value);
        }

        return $value;
    }

    /**
     * 生成短信内容
     * @param string $code
     * @return string
     */
    public function buildCodeMessage($code)
    {
        return is_callable($this->codeMessageBuilder)
            ? call_user_func($this->codeMessageBuilder, $code)
            : '您的验证码为: ' . $code;
    }

    /**
     * 检查验证码正确么?
     *
     * @param string $mobile
     * @param string $vcode
     * @param string $bag
     * @return boolean
     */
    public function check($mobile, $vcode, $bag = 'default', $forgetWhenOk = true)
    {
        // 空?
        if (empty($mobile) || empty($vcode))
        {
            return false;
        }

        $cacheCode = $this->getCodeFromCache($mobile, $bag);

        // 无缓存?
        if (empty($cacheCode))
        {
            return false;
        }

        // 不相等?
        if ($cacheCode != $vcode)
        {
            return false;
        }

        // 成功时清除旧的?
        if ($forgetWhenOk)
        {
            $this->forgetCodeFromCache($mobile, $bag);
        }

        return true;
    }

    /**
     * 删除验证码
     * @param string $mobile
     * @param string $bag
     */
    public function forgetCodeFromCache($mobile, $bag)
    {
        $key = $this->getCacheKey($mobile, $bag);

        return $this->store->forget($key);
    }

    /**
     * 获取
     * @param string $mobile
     * @param string $bag
     */
    public function getCodeFromCache($mobile, $bag, $default = null)
    {
        $key = $this->getCacheKey($mobile, $bag);

        $cache = $this->store->get($key);

        return $cache ?: $this->value($default);
    }

    /**
     * 保存验证码到缓存中
     * @param string $mobile
     * @param string $code
     * @param string $bag
     * @return \Illuminate\Cache\void
     */
    public function putCodeToCache($mobile, $code, $bag)
    {
        $key = $this->getCacheKey($mobile, $bag);

        return $this->store->put($key, $code, $this->cacheMinutes);
    }

    /**
     * 拼接缓存键
     */
    public function getCacheKey($mobile, $bag)
    {
        // 缓存键
        return sprintf('%s_%s_%s_%s',
            $this->cacheKeyPrefix,
            md5(__METHOD__),
            $bag,
            $mobile
        );
    }

}