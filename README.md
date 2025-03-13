## Base MultiTenancy

### Erros
1. Acessando Painel do Cliente na Aplicação Central:

    - O painel de clientes (ClientPanel) está acessível em domínios centrais, quando deveria estar disponível apenas em domínios de tenants.

2. Acessando Painel do Admin na Aplicação do Tenant:

    - O painel de admin (AdminPanel) está acessível em domínios de tenants, quando deveria estar disponível apenas em domínios centrais.

3. Usuário do Cliente não está logando:

    - Os usuários do painel de clientes não conseguem fazer login, possivelmente devido a problemas de autenticação ou configuração do banco de dados do tenant.

### Funcionalidades
- CRUD de Tenants e Usuários

### Requisitos
- Docker

### Instalação

#### Clone o repositório:
```bash
git clone https://github.com/txrangel/Multi-Tenancy.git
cd Multi-Tenancy
```

#### Copiar Env:
```bash
cp .env.example .env
```

#### Iniciar dependências:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

#### Iniciar o servidor:
```bash
./vendor/bin/sail up --build
```

#### Instalar dependências:
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

#### Iniciar o servidor:
```bash
./vendor/bin/sail npm run dev
```

#### Criar chave do programa (se não houver):
```bash
./vendor/bin/sail artisan key:generate
```

#### Rodar as migrações:
```bash
./vendor/bin/sail artisan migrate
```

#### Linkar base para imagens
```bash
./vendor/bin/sail artisan storage:link
```

#### Criar base minima
```bash
./vendor/bin/sail artisan db:seed --class=FullDatabaseSeeder
```