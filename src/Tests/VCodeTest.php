<?php


namespace Windqyoung\Utils\Tests;


use Windqyoung\Utils\Sms\VCode;
use Windqyoung\Utils\Sms\SenderInterface;

class VCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VCode
     */
    private $vcode;

    public function setUp()
    {
        $this->vcode = new VCode();
    }


    public function testsetCodeGenerator_generateCode()
    {
        $code = 'my code';
        $this->vcode->setCodeGenerator(function () use ($code) {
            return $code;
        });
        $this->assertSame($code, $this->vcode->generateCode());
    }

    public function testsetCacheKeyPrefix_getCacheKey()
    {
        $prefix = 'hello';
        $this->vcode->setCacheKeyPrefix($prefix);
        $this->assertStringStartsWith($prefix, $this->vcode->getCacheKey(1, 1));

        $this->assertEquals(sprintf('%s_%s_%s_%s',
            $prefix,
            md5((Vcode::class) . '::getCacheKey'),
            $bag = 'bag_1',
            $mobile = 'mobile_1'
        ), $this->vcode->getCacheKey($mobile, $bag));
    }

    public function testsetCodeMessageBuilder_buildCodeMessage()
    {
        $msg = 'good body';
        $this->vcode->setCodeMessageBuilder(function ($code) use ($msg) {
            return $msg . $code;
        });

        $code = ' code';
        $this->assertSame($msg . $code, $this->vcode->buildCodeMessage($code));
    }

    public function testvalue()
    {
        $this->assertSame(null, $this->vcode->value(null));

        $this->assertSame(123, $this->vcode->value(function () {
            return 123;
        }));
    }

    public function testforgetCodeFromCache_putCodeToCache_getCodeFromCache_setCacheMinutes()
    {
        $this->vcode->setStore($st = new Store());
        $this->vcode->setCacheMinutes(13);

        $this->vcode->putCodeToCache($mobile = 'mo-hello', $code = 'c-code', $bag = 'bag-my');

        $this->assertNotEmpty($st);

        $this->assertSame($code, $this->vcode->getCodeFromCache($mobile, $bag));

        $this->assertSame(13, $st->store[$this->vcode->getCacheKey($mobile, $bag)]['min']);

        $this->vcode->forgetCodeFromCache($mobile, $bag);

        $this->assertEmpty($st->store);
    }

    public function testSend()
    {
        $v = $this->vcode;

        $v->setStore($st = new Store());
        $v->setSender($sd = new Sender());

        $mobile = 'my-mobile';
        $bag = 'my-bag';

        $v->send($mobile, $bag);

        $code = $v->getCodeFromCache($mobile, $bag);

        $this->assertSame($mobile, $sd->mobile);
        $this->assertSame($v->buildCodeMessage($code), $sd->msg);
    }


    public function testCheck()
    {
        $v = $this->vcode;
        $v->setStore($st = new Store());

        $mobile = 'my-bmile';
        $vcode = 'hello-code';

        $this->assertFalse($v->check(false, 'v'));
        $this->assertFalse($v->check(null, 'v'));
        $this->assertFalse($v->check(1, false));
        $this->assertFalse($v->check(1, null));

        $this->assertFalse($v->check($mobile, $vcode));

        $v->putCodeToCache($mobile, $vcode, $bag = 'default');

        $this->assertTrue($v->check($mobile, $vcode, $bag, false));

        $this->assertFalse($v->check($mobile, $vcode . 'wrong', $bag, false));
        $this->assertFalse($v->check($mobile . 'wrong', $vcode, $bag, false));

        $this->assertTrue($v->check($mobile, $vcode, $bag, true));

        $this->assertFalse($v->check($mobile, $vcode, $bag));
    }
}


class Sender implements SenderInterface
{
    public $mobile;
    public $msg;
    public function send($mobile, $msg)
    {
        $this->mobile = $mobile;
        $this->msg = $msg;
    }
}


class Store
{

    public $store = [];

    public function put($key, $value, $min)
    {
        $this->store[$key] = compact('value', 'min');
    }

    public function get($key)
    {
        return isset($this->store[$key]['value']) ? $this->store[$key]['value'] : null;
    }

    public function forget($key)
    {
        unset ($this->store[$key]);
    }
}