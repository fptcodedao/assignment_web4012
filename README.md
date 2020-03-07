
# About Project Đang update :3
_ Assginment _


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

run: `php artisan key:generate`

**Step4:**
update database with migration & fake data

`php artisan migrate --seed`

**Step5:**
short link

`php artisan storage:link`
