Proyecto de fin de curso de Cristian y Mena de una pagina de venta de cursos de programacion online

Seeder configuarado en DatabaseSeeder :  php artisan db:seed

Para la recuperacion de contraseña se tiene que añadir estas credenciales en el .env y el usuario tiene que estar registrado

MAIL_MAILER=smtp 
MAIL_HOST=smtp.gmail.com 
MAIL_PORT=587 
MAIL_USERNAME=rstpwdpincode@gmail.com 
MAIL_PASSWORD=fbditambiprlyjgk
MAIL_ENCRYPTION=tls 
MAIL_FROM_ADDRESS=rstpwdpincode@gmail.com 
MAIL_FROM_NAME="PinCode"

Para el stripe
STRIPE_KEY=pk_live_51RTT0GGxqii4yoL2CvIc8e6kn5rBoR2PMXiZikYmI5d0R4e2votdr6nPvrLt6BzuH4zpMFVrNriDRLJkMymCuK0a00asqitMLf
STRIPE_SECRET=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
CASHIER_CURRENCY=eur
CASHIER_CURRENCY_LOCALE=es_ES
