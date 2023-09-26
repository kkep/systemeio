## Install
Set database config
```dotenv
DATABASE_URL="postgresql://postgres:postgres@127.0.0.1:5432/app?serverVersion=15&charset=utf8"
```
Run bash commands
```bash
composer i
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```


## Test
`/calculate-price`
```json
{
    "product": 0,
    "taxNumber": "GR635345758",
    "couponCode": "F4"
}
```

`/purchase`
```json
{
    "product": 0,
    "taxNumber": "GR635345758",
    "couponCode": "F4",
    "paymentProcessor": "paypal"
}
```
