# Micro-Cache

[![Latest Stable Version](http://poser.pugx.org/apricity/micro-cache/v)](https://packagist.org/packages/apricity/micro-cache) 
[![PHP Version Require](http://poser.pugx.org/apricity/micro-cache/require/php)](https://packagist.org/packages/apricity/micro-cache)
[![License](http://poser.pugx.org/apricity/micro-cache/license)](LICENSE) 

MicroCache is a lightweight and simple in-memory caching solution that allows you to store key-value pairs in memory.
It is particularly useful for caching data that is expensive to generate or retrieve from external sources.

> Class provides a straightforward approach to caching data in memory, allowing for efficient storage and
> retrieval of cached items.

## Installation

```bash
composer require apricity/micro-cache
```

## Table of contents

1. Usage
    - API
        - [MicroCache::set](#microcacheset)
        - [MicroCache::get](#microcacheget)
        - [MicroCache::delete](#microcachedelete)
        - [MicroCache::clear](#microcacheclear)
        - [MicroCache::has](#microcachehas)
    - [Inheritance](#inheritance-and-creation-of-a-unique-cache)
3. [Tests](#run-tests)
4. [Contributing](#contributing)
5. [Changelog](CHANGELOG.md)
6. [License](#license)

---

### MicroCache::set

Store an item in the cache.

This method stores an item in the cache under the specified key. If the key already exists, its value will be
overwritten with the new value. If the TTL (time-to-live) parameter is provided and is greater than zero, the item will
expire and be removed from the cache after the specified number of seconds. If the TTL is zero, the item will be cached
indefinitely.

```php
public static function set(mixed $key, mixed $value, int $ttl = 0): string|int
```

**Parameters**:

- `mixed $key`: The key under which to store the item. Can be of any type except Closure.
- `mixed $value`: The value to store.
- `int $ttl`: Time-to-live in seconds. If zero, the item is cached indefinitely.

**Returns**: `string|int` - The key under which the item is stored.

**Throws**: `InvalidArgumentException` - If the key is callable or if the key is empty and not zero or false.

#### Example

```php
$key = MicroCache::set('my_key', 'my_value', 3600);
```

---

### MicroCache::get

Retrieve an item value from the cache.

This method retrieves the value of an item stored in the cache under the specified key. If the item exists in the cache
and has not expired, its value will be returned. If the item does not exist or has expired, null will be returned.

```php
public static function get(mixed $key): mixed
```

**Parameters**:

- `mixed $key`: The key under which to store the item. Can be of any type except Closure.

**Returns**: `mixed|null` - The cached item value or null if the key doesn't exist or has expired.

**Throws**: `InvalidArgumentException` - If the key is callable or if the key is empty and not zero or false.

#### Example

```php
$value = MicroCache::get('my_key');
if (is_null($value)) {
    echo "Cache miss";
} else {
    echo "Cache value: " . $value;
}
```

---

### MicroCache::delete

Delete an item from the cache.

This method removes the item stored in the cache under the specified key. If the item exists in the cache, it will be
deleted. If the item does not exist, no action will be taken.

```php
public static function delete(mixed $key): void
```

**Parameters**:

- `mixed $key`: The key under which to store the item. Can be of any type except Closure.

**Returns**: `void`

**Throws**: `InvalidArgumentException` - If the key is callable or if the key is empty and not zero or false.

#### Example

```php
MicroCache::delete('my_key');
```

---

### MicroCache::clear

Clear all items from the cache.

This method clears all items stored in the cache, effectively resetting the cache to an empty state.

```php
public static function clear(): void
```

**Returns**: `void`

#### Example

```php
MicroCache::clear();
```

---

### MicroCache::has

Check if an item exists in the cache and is not expired.

This method checks whether the specified key exists in the cache and if it is not expired. If the item exists and is not
expired, it returns true; otherwise, it returns false.

```php
public static function has(mixed $key): bool
```

**Parameters**:

- `mixed $key`: The key under which to store the item. Can be of any type except Closure.

**Returns**: `bool` - True if the item exists and is not expired, false otherwise.

**Throws**: `InvalidArgumentException` - If the key is callable or if the key is empty and not zero or false.

#### Example

```php
if (MicroCache::has('my_key')) {
    echo "Cache exists";
} else {
    echo "Cache does not exist or has expired";
}
```

---

## Inheritance and creation of a unique cache

#### Shared cache

```php
use Apricity\MicroCache;

class SharedCache extends MicroCache {}

SharedCache::set('shared_cache_key', 'shared_value');

SharedCache::get('shared_cache_key'); // shared_value
MicroCache::get('shared_cache_key'); // shared_value

MicroCache::set('cache_key', 'cached_value');

SharedCache::get('cache_key'); // cached_value
MicroCache::get('cache_key'); // cached_value
```

#### Unique cache

```php
use Apricity\MicroCache;

class UniqueCache extends MicroCache {
    protected static array $microCache = []; // Non-shared unique cache.
}

UniqueCache::set('unique_cache_key', 'unique_value');

UniqueCache::get('unique_cache_key'); // unique_value
MicroCache::get('unique_cache_key'); // null

MicroCache::set('cache_key', 'cached_value');

UniqueCache::get('cache_key'); // null
MicroCache::get('cache_key'); // cached_value
```

---

### Run tests

```shell
composer test
```

---

## Contributing

We welcome contributions from the community! For guidelines on how to contribute, please refer to
the [CONTRIBUTING.md](CONTRIBUTING.md) file.

---

## License

This project is licensed under the BSD 3-Clause License - see the [LICENSE](LICENSE) file for details.

---

The repository has been migrated from GitLab.