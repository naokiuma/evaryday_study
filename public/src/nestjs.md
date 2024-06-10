# injectableがやってること

こういうの。
```
@Injectable()
export class UsersService {
  constructor(
    @InjectRepository(User)
    private readonly userRepository: Repository<User>,
  ) {}
```
→このUserを、オーソドックスに使えるようにしている
https://qiita.com/potato4d/items/64a1f518abdfe281ce01

# ログの出し方
シンプルにconsole.log
出したいファイルで

```

import { Logger } from '@nestjs/common';

// 出したい場所で以下を記述
const logger = new Logger('ロガーテスト');
logger.log('ログの出力テスト');

```

またはターミナルからは以下で確認可能

```jsx
docker ps
で、appのコンテナidを確認し、
docker logs -f <CONTAINER_ID>
```

出したログは、ドッカーの該当アプリのログに出る。

```
docker ps
で、appのコンテナidを確認し、
docker logs -f <CONTAINER_ID>

```
