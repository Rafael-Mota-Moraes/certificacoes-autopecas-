## Como rodar o projeto (localmente por enquanto)

- Rode em duas janelas diferentes do terminal

```bash
php artisan serve
```

```bash
composer run dev
```

- Subir banco postgres e colocar as seguintes variáveis no .env

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
APP_KEY=
```

- Rodar o seguinte comando

```bash
php artisan key:generate
```
