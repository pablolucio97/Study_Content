# Applying cache using Redis on NestJS applications

1. Create a class to manage Redis cache methods. Example:
 ```typescript
 import { Inject, Injectable, OnModuleDestroy } from '@nestjs/common';
import Redis from 'ioredis';

import { logger } from '../utils/enhanced-logger';

@Injectable()
export class RedisService implements OnModuleDestroy {
  constructor(
    @Inject('REDIS_CLIENT')
    private redisClient: Redis,
    @Inject('REDIS_TTL_DEFAULT')
    private defaultTtl: number,
  ) {
    this.redisClient.on('connect', () => {
      logger.info({ module: 'RedisService' }, 'Redis Connection Established');
    });

    this.redisClient.on('error', (err) => {
      logger.error(err, { module: 'RedisService' }, 'Redis Connection Error');
    });
  }

  async onModuleDestroy(): Promise<void> {
    await this.redisClient.quit();
  }

  async set(key: string, value: string | number, ttl?: number): Promise<void> {
    const finalTtl = ttl ?? this.defaultTtl;
    await this.redisClient.setex(key, finalTtl, String(value));
  }

  async setObject<T>(key: string, value: T, ttl?: number): Promise<void> {
    const finalTtl = ttl ?? this.defaultTtl;
    await this.redisClient.setex(key, finalTtl, JSON.stringify(value));
  }

  get(key: string): Promise<string | null> {
    return this.redisClient.get(key);
  }

  async getObject<T>(key: string): Promise<T | null> {
    const value = await this.redisClient.get(key);
    if (!value) return null;
    try {
      return JSON.parse(value) as T;
    } catch (err) {
      const error = err instanceof Error ? err : new Error(String(err));

      logger.error(
        error,
        { module: 'RedisService', key, errorMessage: error.message },
        'Erro ao parsear objeto do Redis',
      );

      return null;
    }
  }

  async del(key: string): Promise<void> {
    await this.redisClient.del(key);
  }
}
 ```
## 2) Use cache correctly depending on the controller operation 

Cache strategy depends on **read vs write** operations:

### ✅ GET (read / listing / details)
- **Goal:** speed up repeated reads.
- **Pattern:** *cache-aside* → try Redis first, if missing fetch from DB/service, then `setObject`.
- **Keys:** use stable keys that represent the query (pagination, filters, id).
- **TTL:** usually short-to-medium (seconds/minutes) depending on how “fresh” it must be.

```ts
@Get()
async list(@Query('page') page = '1') {
  const cacheKey = `users:list:page:${page}`;

  const cached = await this.redis.getObject<any[]>(cacheKey);
  if (cached) return cached;

  const usersFromDb = [{ id: 1, name: 'Pablo' }];

  await this.redis.setObject(cacheKey, usersFromDb, 60);
  return usersFromDb;
}
```

---

### ✅ POST (create)
- Invalidate related list caches after creation.

```ts
@Post()
async create(@Body() dto: { name: string }) {
  const created = { id: Date.now(), name: dto.name };

  await this.redis.del('users:list:page:1');
  await this.redis.setObject(`users:detail:${created.id}`, created, 300);

  return created;
}
```

---

### ✅ PATCH/PUT (update)
- Invalidate detail and list caches.

```ts
@Patch(':id')
async update(@Param('id') id: string, @Body() dto: { name?: string }) {
  const updated = { id: Number(id), name: dto.name ?? 'Updated Name' };

  await this.redis.del(`users:detail:${id}`);
  await this.redis.del('users:list:page:1');
  await this.redis.setObject(`users:detail:${id}`, updated, 300);

  return updated;
}
```

---

### ✅ DELETE (remove)
- Remove detail cache and invalidate lists.

```ts
@Delete(':id')
async remove(@Param('id') id: string) {
  await this.redis.del(`users:detail:${id}`);
  await this.redis.del('users:list:page:1');

  return { success: true };
}
```
   
## General tips
- Cache on NestJS must be applied just for routes that are often read and rarely changes. 
- Cache can live in controllers, services, or interceptors.
- Always save the cache data as string using JSON.stringify for simplicity.
- Define a consistent cache key strategy.
- Combine cache invalidation with TTL.
