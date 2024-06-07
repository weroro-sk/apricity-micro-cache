## Code Details

### MicroCache::set

1. **Normalize the item key**:
    - Ensure the provided key is in a valid format by calling the normalizeItemKey method.
2. **Store the item in the cache**:
    - Assign the provided value to the cache under the normalized key.
    - If a TTL is provided and greater than zero, calculate the expiration time and store it along with the item.
3. **Return the key**:
    - Return the key under which the item is stored.

### MicroCache::get

1. **Normalize the item key**:
    - Ensure the provided key is in a valid format by calling the normalizeItemKey method.
2. **Check if the item exists in the cache**:
    - If the item exists and is not expired, return its value.
    - If the item does not exist or has expired, return null.

### MicroCache::delete

1. **Normalize the item key**:
    - Ensure the provided key is in a valid format by calling the normalizeItemKey method.
2. **Check if the item exists in the cache**:
    - If the item exists, remove it from the cache.

### MicroCache::clear

1. **Clear the cache**:
    - Reset the cache to an empty state by assigning an empty array to the $cache property.

### MicroCache::has

1. **Normalize the item key**:
    - Ensure the provided key is in a valid format by calling the normalizeItemKey method.
2. **Check if the item exists and is not expired**:
    - If the item exists and is not expired, return true.
    - If the item does not exist or has expired, return false.

### [protected] MicroCache::normalizeItemKey

1. **Check if the key is callable or empty**:
    - Throw an InvalidArgumentException if the key is callable or empty.
2. **Convert the key if needed**:
    - If the key is not a string or integer, attempt to convert it using serialization or other available functions.
3. **Return the normalized key**:
    - Return the normalized key as a string.
