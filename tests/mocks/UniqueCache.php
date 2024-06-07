<?php

namespace Apricity\tests\mocks;

use Apricity\MicroCache;

class UniqueCache extends MicroCache
{
    protected static array $microCache = [];
}
