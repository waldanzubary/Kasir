## How to Use
1. Clone Project ini.
2. Clone Project Python Scanner: https://github.com/waldanzubary/scanner-barcode-.git
3. Pada Project Laravel, run pada terminal:

composer install
Salin smtp dan setting .env:

MAIL_MAILER=smtp

MAIL_HOST=smtp.gmail.com

MAIL_PORT=465

MAIL_USERNAME="mirzazubaridjunaid@gmail.com"

MAIL_PASSWORD="yqsjzaispztobmax"

MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS="mirzazubaridjunaid@gmail.com"

MAIN_FROM_NAME="${APP_NAME}"

php artisan key:generate
php artisan migrate --seed
php artisan storage:link

Run:
php artisan serve

Kemudian run project python dengan run pada terminal:
Setting project Python sesuai readme.md pada project
Sesuaikan index camera dengan webcam atau kamera eksternal Komputer
python scanner.py
