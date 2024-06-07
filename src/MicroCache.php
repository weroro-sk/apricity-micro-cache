<?php

declare(strict_types=1);

namespace Apricity;

/**
 * Simple in-memory caching mechanism for PHP applications.
 *
 * @see https://github.com/weroro-sk/apricity-micro-cache/blob/main/README.md Documentation
 */
class MicroCache
{
    /**
     * This array serves as a cache storage where cached items are stored for later retrieval.
     * It holds key-value pairs, where each key represents a unique identifier for the cached item,
     * and the corresponding value holds the actual cached data.
     *
     * @var array<string, mixed> $microCache The associative array used to store cached items.
     */
    protected static array $microCache = [];

    /**
     * Store an item in the cache.
     *
     * This method stores an item in the cache under the specified key. If the key already exists,
     * its value will be overwritten with the new value. If the TTL (time-to-live) parameter is provided
     * and is greater than zero, the item will expire and be removed from the cache after the specified
     * number of seconds. If the TTL is zero, the item will be cached indefinitely.
     *
     * @param mixed $key The key under which to store the item. Can be of any type except Closure.
     * @param mixed $value The value to store.
     * @param int $ttl Time-to-live in seconds. If zero, the item is cached indefinitely.
     *
     * @return string|int The key under which the item is stored.
     * @throws MicroCacheException If the key is callable or if the key is empty and not zero or false.
     *
     * ```
     * $key = MicroCache::set('my_key', 'my_value', 3600);
     * ```
     */
    public static function set(mixed $key, mixed $value, int $ttl = 0): string|int
    {
        // Normalize the item key
        $key = self::normalizeItemKey($key);
        // Store the item in the cache
        static::$microCache[$key] = [
            'value' => $value,
            'exp' => $ttl !== 0 ? time() + $ttl : 0,
        ];
        return $key;
    }

    /**
     * Retrieve an item value from the cache.
     *
     * This method retrieves the value of an item stored in the cache under the specified key.
     * If the item exists in the cache and has not expired, its value will be returned.
     * If the item does not exist or has expired, null will be returned.
     *
     * @param mixed $key The key of the item to retrieve. Can be of any type except Closure.
     *
     * @return mixed|null The cached item value or null if the key doesn't exist or has expired.
     * @throws MicroCacheException If the key is callable or if the key is empty and not zero or false.
     *
     * ```
     * $value = MicroCache::get('my_key');
     * if (is_null($value)) {
     *     echo "Cache miss";
     * } else {
     *     echo "Cache value: " . $value;
     * }
     * ```
     */
    public static function get(mixed $key): mixed
    {
        // Normalize the item key
        $key = self::normalizeItemKey($key);
        // Check if the item exists in the cache and is not expired
        if (self::has($key)) {
            return static::$microCache[$key]['value'];
        }
        return null;
    }

    /**
     * Delete an item from the cache.
     *
     * This method removes the item stored in the cache under the specified key.
     * If the item exists in the cache, it will be deleted. If the item does not exist,
     * no action will be taken.
     *
     * @param mixed $key The key of the item to delete. Can be of any type except Closure.
     *
     * @return void
     * @throws MicroCacheException If the key is callable or if the key is empty and not zero or false.
     *
     * ```
     * MicroCache::delete('my_key');
     * ```
     */
    public static function delete(mixed $key): void
    {
        // Normalize the item key
        $key = self::normalizeItemKey($key);
        // Check if the item exists in the cache
        if (self::has($key)) {
            // Delete the item from the cache
            unset(static::$microCache[$key]);
        }
    }

    /**
     * Clear all items from the cache.
     *
     * This method clears all items stored in the cache, effectively resetting
     * the cache to an empty state.
     *
     * @return void
     *
     * ```
     * MicroCache::clear();
     * ```
     */
    public static function clear(): void
    {
        // Clear the cache
        static::$microCache = [];
    }

    /**
     * Check if an item exists in the cache and is not expired.
     *
     * This method checks whether the specified key exists in the cache and
     * if it is not expired. If the item exists and is not expired, it returns
     * true; otherwise, it returns false.
     *
     * @param mixed $key The key to check. Can be of any type except Closure.
     *
     * @return bool True if the item exists and is not expired, false otherwise.
     * @throws MicroCacheException If the key is callable or if the key is empty and not zero or false.
     *
     * ```
     * if (MicroCache::has('my_key')) {
     *     echo "Cache exists";
     * } else {
     *     echo "Cache does not exist or has expired";
     * }
     * ```
     */
    public static function has(mixed $key): bool
    {
        // Normalize the item key
        $key = self::normalizeItemKey($key);
        // Check if the item exists in the cache
        if (empty(static::$microCache[$key])) {
            return false;
        }
        // Get the cached item
        $item = static::$microCache[$key];
        // Check if the item has expired
        if ($item['exp'] !== 0 && $item['exp'] < time()) {
            // If expired, delete the item from the cache
            unset(static::$microCache[$key]);
            return false;
        }
        return true;
    }

    /**
     * Normalize the cache item key.
     *
     * This method normalizes the cache item key to ensure consistency and compatibility.
     * If the key is not a string or integer, it attempts to convert it using available functions.
     * It throws an exception if the key is empty and not zero or false.
     *
     * @param mixed $key The key to normalize. Can be of any type except Closure.
     *
     * @return string The normalized key.
     * @throws MicroCacheException If the key is callable or if the key is empty and not zero or false.
     *
     * ```
     * $key1 = null;
     * $key2 = [];
     * $key3 = 123;
     * $key4 = function () {};
     *
     * try {
     *     $normalizedKey1 = MicroCache::normalizeItemKey($key1);
     *     echo "Normalized key 1: $normalizedKey1\n";
     * } catch (InvalidArgumentException $e) {
     *     echo $e->getMessage();
     * }
     *
     * try {
     *     $normalizedKey2 = MicroCache::normalizeItemKey($key2);
     *     echo "Normalized key 2: $normalizedKey2\n";
     * } catch (InvalidArgumentException $e) {
     *     echo $e->getMessage();
     * }
     *
     * try {
     *     $normalizedKey3 = MicroCache::normalizeItemKey($key3);
     *     echo "Normalized key 3: $normalizedKey3\n";
     * } catch (InvalidArgumentException $e) {
     *     echo $e->getMessage();
     * }
     *
     * try {
     *      // Normalization of a Closure-type key
     *      $normalizedKey4 = MicroCache::normalizeItemKey($key4);
     *      echo "Normalized key 4: $normalizedKey4\n";
     * } catch (InvalidArgumentException $e) {
     *      // Catching and printing the exception if the key is a Closure type
     *      echo $e->getMessage();
     * }
     * ```
     */
    protected static function normalizeItemKey(mixed $key): string
    {
        // Check if the key is callable or if the key is empty and not zero or false
        if ((empty($key) && $key !== 0 && $key !== false)
            || (!is_array($key) && !is_string($key) && is_callable($key))) {
            // Throw an exception if the key is callable or if the key is empty and not zero or false
            throw new MicroCacheException("A cache key must be provided, cannot be empty, and cannot be callable.");
        }

        if (!is_string($key) && !is_integer($key)) {
            // Attempt to convert the key using available functions
            $key = serialize($key);
            // $key = json_encode($key);
            // $key = var_export($key, true);
        }

        return $key;
    }
}


