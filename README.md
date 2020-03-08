
# About Project
_ Assginment web4012 _

## First Run:
**Step1:**
pull package composer

`composer install`

**Step2:**
pull package node_module & build theme 

`npm run && npm run production`

**Step3:**
config

copy file .env.example to .env

config database in .env

> Generate key
run: `php artisan key:generate`

**Step4:**
update database with migration & fake data

`php artisan migrate --seed`

**Step5:**
short link storage

`php artisan storage:link`

**Step6:**
config smtp mail in .env
>example
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=admin@fptcodedao.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="Khari Nguyen"
MAIL_FROM_ADDRESS=admin@fptcodedao.com
```

**Step7:**

`php artisan serve`

Now view in the browser local: http://localhost:8000/

### Account Demo
| Name      | Email                 | Password | Role       |
|-----------|-----------------------|----------|------------|
| KhariDz   | admin@fptcodedao.com  | admin123 | Full Admin |
| Editor    | editor@fptcodedao.com | admin123 |Editor      |
