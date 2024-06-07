<?php

namespace Apricity\tests;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Apricity\MicroCache;
use ReflectionException;
use ReflectionMethod;

class MicroCacheTest extends TestCase
{
    public function testSet()
    {
        $key = MicroCache::set('my_key', 'my_value', 3600);
        $this->assertEquals('my_key', $key);

        MicroCache::clear();
    }

    public function testGetValueIfExists()
    {
        MicroCache::set('my_key', 'my_value', 3600);
        $value = MicroCache::get('my_key');
        $this->assertEquals('my_value', $value);

        MicroCache::clear();
    }

    public function testGetValueForNonExistentKey()
    {
        $nonExistentValue = MicroCache::get('non_existent_key');
        $this->assertNull($nonExistentValue);

        MicroCache::clear();
    }

    public function testGetValueForExpiredKey()
    {
        MicroCache::set('expired_key', 'expired_value', -1);
        $expiredValue = MicroCache::get('expired_key');
        $this->assertNull($expiredValue);

        MicroCache::clear();
    }

    public function testDelete()
    {
        MicroCache::set('my_key', 'my_value', 3600);
        MicroCache::delete('my_key');
        $this->assertNull(MicroCache::get('my_key'));

        MicroCache::clear();
    }

    public function testClear()
    {
        MicroCache::set('my_key_1', 'my_value_1', 3600);
        MicroCache::set('my_key_2', 'my_value_2', 3600);
        MicroCache::clear();
        $this->assertNull(MicroCache::get('my_key_1'));
        $this->assertNull(MicroCache::get('my_key_2'));
    }

    public function testHas()
    {
        MicroCache::set('my_key', 'my_value', 3600);
        $this->assertTrue(MicroCache::has('my_key'));
        MicroCache::delete('my_key');
        $this->assertFalse(MicroCache::has('my_key'));

        MicroCache::clear();
    }

    public function testNormalizeItemKeyValid()
    {
        $reflectionMethod = new ReflectionMethod(MicroCache::class, 'normalizeItemKey');
        //$reflectionMethod->setAccessible(true);
        try {
            $this->assertEquals('test', $reflectionMethod->invokeArgs(null, ['test']));
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testNormalizeItemKeyEmpty()
    {
        $reflectionMethod = new ReflectionMethod(MicroCache::class, 'normalizeItemKey');
        //$reflectionMethod->setAccessible(true);
        try {
            $this->expectException(InvalidArgumentException::class);
            $reflectionMethod->invokeArgs(null, ['']);
        } catch (ReflectionException $e) {
            $this->fail($e->getMessage());
        }
    }
}
