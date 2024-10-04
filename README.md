## Tentang AntislotV8

AntislotV8 adalah aplikasi scanning dan pencegahan defacmeent slot berbasis website yang di bangun dan di kembangkan dengan Framework Laravel versi 8. Fitur-fitur pada aplikasi AntislotV8 antara lain :

-   Login (Done)
-   Dashboard (Done)
-   Scan Backlink Slot (Done)
-   Defend Wordpress & Laravel (Done)
-   Wordlist (NEW)
-   Profile (Done)

## Persyaratan

Aplikasi ini menggunakan Framework Laravel versi 8. Tentunya versi php yang digunakan adalah:

-   Minimal Versi PHP: 7.4

## Installation

-   Install [Composer](https://getcomposer.org/download) and [Npm](https://nodejs.org/en/download)
-   Clone the repository: `git clone https://github.com/mzrismuarf/antislotv8`
-   Install dependencies: `composer install ; npm install`
-   Run `cp .env.example .env` for create .env file
-   Edit `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
-   Run `php artisan key:generate`
-   Run `php artisan migrate --seed` for migration database
-   Run `php artisan storage:link` for create folder storage
-   For Server Linux Run `chmod 777 -R storage/` for fix permission storage
-   Run `npm run dev`

## Penggunaan

-   Login sebagai Admin email: antislot@anti.slot & pw: @Antislot1337

Ketika project ini dideploy ke hosting atau vps dan baru pertama kali login, sangat disarankan mengganti email dan password default pada menu setting (Admin Dashboard). 

Note : Aplikasi ini sangat bergantung pada wordlist yang digunakan. Apabila ingin menambah wordlist baru, sangat diperkenankan untuk membantu mengembangkan aplikasi ini.<br>
<br>
Aplikasi ini kemungkinan tidak bisa mendeteksi web atau file yang di telah diObfuscate
<br>
Jika ada pertanyaan bisa kontak aku di email ini <b>mzrismuarf[at]gmail[dot]com</b>

</p>

## FIX ERROR
Jika pada saat menjalankan 'npm run dev' mengalami error seperti ini:
`> cross-env NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js

'cross-env' is not recognized as an internal or external command,
operable program or batch file.`

Maka bisa mencoba menjalankan perintah berikut
-   Run `npm install --save-dev cross-env`
Dan jalankan kembali npm run dev
-   Run `npm run dev`

## PATCH CVE-2021-3129

AntiSlot ini menggunakan versi laravel versi 8, dan terdapat kerentanan pada CVE-2021-3129. Kerentanan tersebut pada "APP_DEBUG = True". Untuk mencegahnya pada 'APP_DEBUG' bisa ganti value nya bernilai 'false', dan sudah didefault pada .env.example bernilai 'APP_DEBUG = False".

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
