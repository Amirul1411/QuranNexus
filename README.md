# Web Recitation Interface Documentation

## Tutorial video playlist links:

Laravel 10 Beginners Course (Twitter Clone Project)  
Yelo Code  
https://youtube.com/playlist?list=PLqDySLfPKRn5d7WbN9R0yJA9IRgx-XBlU&si=VHXr1anKT-9_Ixoc

Vite in Laravel Project  
Igor Babko  
https://youtube.com/playlist?list=PLXDouhCU5r6qDa_0O8_4T7o5mDg9pMRMo&si=RrDN1qw7DrS8eVMJ

Laravel Livewire 3 course (Beginners)  
Yelo Code  
https://youtube.com/playlist?list=PLqDySLfPKRn543NM_fTrJRdhjBgsogzSC&si=aDO1T8HquKY4H9XP

Larevel Jetstream Tutorials  
Yelo Code  
https://youtube.com/playlist?list=PLqDySLfPKRn4G-Qark0-RAF6ga43-6TEL&si=F2-aZfUApi6IWloh

Filament 3 course for beginners  
Yelo Code  
https://youtube.com/playlist?list=PLqDySLfPKRn6fgrrdg4_SmsSxWzVlUQJo&si=ymmk1fYC63E1IfiL

Build Blog with Laravel, Livewire and Filament 3 Course (2023)  
Yelo Code  
https://youtube.com/playlist?list=PLqDySLfPKRn5cEn5H2djYJNcmlaYWz-L3&si=NncLimaAtxfUXxcy

Laravel Rest API  
Envato Tuts  
https://youtu.be/YGqCZjdgJJk?si=vtO2odiZzUtRSeC1

Tailwind CSS Tutorial  
Net Ninja  
https://youtube.com/playlist?list=PL4cUxeGkcC9gpXORlEHjc5bgnIi5HEGhw&si=hrdmIUwPhIZ5yeP6

Alpine.js  
The Codeholic  
https://www.youtube.com/watch?v=5ILDMMLgX0E&list=WL&index=3&t=17s

## Github References:

https://github.com/yelocode/laravel-blog-project  
https://github.com/quran/quran.com-frontend-next  
https://github.com/thecodeholic/alpinejs-course

## FYP2 Final Report

https://drive.google.com/file/d/1wy2zbYzd2yam5f342B2_IsgWH0EOcNxv/view?usp=sharing  

## Env Files:

https://drive.google.com/drive/folders/1ok3hedG_vBK_wgxERw4q-D1UW5NCOyPC?usp=drive_link

## Quran Nexus Public Apis Collections:

https://drive.google.com/drive/folders/1qsDJzbZ9G5sf_sUsR0NdOWh-5V3y9Fp8?usp=sharing  

Notes: Some of the Apis which are not related to Quranic data are not meant to be shared public. For example, achievement and daily quotes Apis. There are meant to be used by mobile app alone. For reference on which Apis are to be made public, refer to 'Web Apis' section inside api.php.   

## Quran Data Distributors:

1. Quran.com: https://quran.com/  
2. Quran Corpus: https://corpus.quran.com/  
3. Tanzil: https://tanzil.net/#19:1  

## Documentation Reference:

Bootstrap icon - https://icons.getbootstrap.com/  
Hero icon - https://heroicons.com/outline  
Laravel - https://laravel.com/docs/11.x/readme  
Livewire 3 - https://livewire.laravel.com/docs/quickstart  
Laravel Mongodb Package - https://www.mongodb.com/docs/drivers/php/laravel-mongodb/current/usage-examples/find/  
TailwindCss - https://tailwindcss.com/docs/installation  
Alpinejs - https://alpinejs.dev/directives/data  
Laravel Jetstream - https://jetstream.laravel.com/introduction.html  
Laravel Filament - https://filamentphp.com/docs/3.x/panels/installation  
VS Code Shortcut - https://code.visualstudio.com/shortcuts/keyboard-shortcuts-windows.pdf    
PHP Java Bridge Client API - https://php-java-bridge.sourceforge.net/pjb/docs/php-api-old/  

## To Access Deployed Version of the Web on VPS

Browse https://quran.seaade2024.com/Home in a browser.

## To use Quran Corpus JAVA API on Localhost:

Download the JAVA API from this link https://drive.google.com/drive/folders/1WxRJGsmnSudqSBZlwXy_hh257g6pfdMd?usp=sharing  

The web code use PHP whereas the Quran Corpus API is written in Java. Therefore, several preliminary steps need to be taken in order to use Quran Corpus Java API in our PHP code.  

PHP java bridge is the package used to interact between PHP and Java code.  

Follow the instructions on this link https://php-java-bridge.sourceforge.net/pjb/tomcat6.php

After you have downloaded the JavaBridge.war and have deployed it to Tomcat server (inside webapps directory of the tomcat directory, e.g. C:\xampp\tomcat\webapps), you must include the jqurantree-1.0.0.jar file inside the lib directory of the tomcat directory (e.g. C:\xampp\tomcat\lib).  

Please remember to run Tomcat server everytime you want to call the methods from jqurantree or else it won't work. jqurantree normally used in seeder files to seed the database. For example, the WordSeeder.php has the line "require 'http://localhost:8080/JavaBridge/java/Java.inc';" which is to include the JavaBridge library so that we can call the java methods inside jqurantree from our PHP code.  For reference on how to use the PHP Java Bridge, please refer to the link https://php-java-bridge.sourceforge.net/pjb/docs/php-api-old/  
  
## Web Recitation Interface Demonstration Video

https://drive.google.com/drive/folders/1XnzaUNGcs-6zF-sWoiw8TFNr4_Ck-tA5?usp=sharing

## List of Commands

### Installing Dependencies

composer install  (To install composer dependencies)  
npm install  (To install npm dependencies)  

### Version Checking

php artisan --version (To check laravel version)  
php -v (To check php version)

### To Run the Code on a Localhost

npm run dev (To apply CSS styling to the website)  
php artisan serve (To run the server and view the website in a browser)  

Run both commands above on different terminals at the same time. Then browse http://127.0.0.1:8000/Home in a browser to access the homepage from a localhost.  

### Commonly Used PHP Artisan Commands

vendor/bin/phpunit [path to test file] {e.g. vendor/bin/phpunit tests/Unit/ExampleTest.php} (To run a test file)  

php artisan route:list (To list all routes)  

php artisan make:controller [Controller name] {e.g. php artisan make:controller HomeController} (To create a controller)  

php artisan make:test [Test file name] {e.g. php artisan make:test UserTest} (To create a test file)  

php artisan make:livewire [Livewire component name] {e.g. php artisan make:livewire SurahList} (To create a livewire component)  

php artisan make:model [Model name] {e.g. php artisan make:model SurahModel} (To create a model)  

php artisan make:model [Model name] --all {e.g. php artisan make:model SurahModel --all} (To create a model and all of others related files such as seeder, request, controller, factory, migration, and policy)  

php artisan make:seeder [Seeder name] {e.g. php artisan make:seeder AyahSeeder} (To create a database seeder)  

php artisan make:provider [Provider name] {e.g. php artisan make:provider CustomServiceProvider} (To create a provider)  

php artisan make:filament-resource  (To create a filament resource which will be displayed in the admin page)  

php artisan make:policy [Policy name] {e.g. php artisan make:policy UserPolicy} (To create a policy)  

php artisan make:resource [Resource name] {e.g. php artisan make:resource SurahResource} (To create a resource file)  

php artisan make:test [Test file] {e.g. php artisan make:test JavaBridgeTest} (To create a test file)  

php artisan make:view [View name] {e.g. php artisan make:view home} (To create a view file)  

php artisan migrate (To migrate the migration files)  

php artisan migrate:status (To check migration status)  

php artisan migrate:rollback (To rollback last migration)  

php artisan db:seed  (To run database seeders to seed the database, refer to DatabaseSeeder.php to comment out any seeder class you don't want to run before running this command)  

php artisan db:seed --class=[Seeder name] {e.g. php artisan db:seed --class=SurahSeeder} (To run a specific seeder class only)  

php artisan test --filter=[Test file name] {e.g. php artisan: test --filter=JavaBridgeTest} (To run a specific test file only)  

php artisan app:cleanup-recently-read  (To cleanup all users' recently read items)  

php artisan schedule:run  (To run scheduled tasks on localhost)  

php artisan schedule:interrupt  (To interrupt schedule:run invocations)  

php artisan schedule:work  (To invoke the scheduler every minute)  

php artisan schedule:list (To view all scheduled tasks)  

### Commonly Used Log Commands

tail -f storage/logs/laravel.log  (To read the last lines of log file)  

rm storage/logs/laravel.log  (To remove the log file)  

### Commonly Used Git Commands

git remote -v (To view list of remote repositories connectoed to the local repository)  

git remote remove [REmote repository name] {e.g. git remote remove origin} (To remove a remote repository)  

git remote add [Remote repository name] [Remote repository link] {e.g. git remote add origin https://github.com/Amirul1411/QuranNexus.git} (To add a remote repository to the local repository)  

git push -u [Remote repository name] [Remote repository branch] {e.g. git push -u origin main} (To push local changes to a remote repository and set the upstream (tracking) reference for the current branch)  
Notes: -u denotes upstream reference  

gitk (To open gitk)  

git gui (To open git gui)  

git stash (To temporarily save changes in your working directory)  

git stash --keep-index (To temporarily save changes in your working directory, but it excludes changes that have already been staged)

git stash list  (To view the list of stashed local changes)  

git stash pop (To pop out the last local changes in the stash)  

git stash pop stash@{[Stash index]} {e.g. git stash pop stash@{0}} (To pop out a specific stashed local changes)  

git stash push --keep-index -m "[Your message]" {e.g. git stash push --keep-index -m ""Fixing bug in ayah indexing logic""} (To stash a local chages with descriptive message)  

git stash drop stash@{[Stash index]} {e.g. git stash drop stash@{1}} (To delete a specific stash entry)  

gitk stash@{[Stash index]} {e.g. gitk stash@{0}} (To visualize the changes stored in a specific stash entry using gitk)  

## User Accounts

Test User  - testuser@gmail.com  - user1234  
Test Editor - testeditor@gmail.com - editor1234  
Test Admin - testadmin@gmail.com - admin1234  
Test - test@gmail.com - test1234

## Commonly Used VS Code Shorcuts

'Ctrl + Shift + F' - Search a text in all files inside the project directory  
'Ctrl + F' - Search a text in the currently open file inside the project directory  
'Ctrl + P' - Quick open a file

## Quran Total Words

Total words in al-Quran: 77430 (-1 because of duplicate word document at word_key 37:130:4)  
Total ayahs in al-Quran: 6236  
Total overall: 83665

## General Notes

1. Test Admin is the most commonly used user account to login the web.  
2. app.blade.php is the layout file used to render all other view pages except admin page.  
3. web.php is the file used to define routes for the web.  
4. api.php is the file used to define public apis.  
5. console.php is the file used to define schedued tasks (may also known as cron jobs).  
6. app.scss is the file used to define the web styling.  
7. helpers.php is the file contains public method that is accessible accross any other files.  
8. Database seeder files use old version of Quran.com APIs. You may need to refer to Quran.com API documentation to use the latest version but it requires authentication from Quran.com.  
9. User's new account registration may encounters error related to email verification (as long as the MAIL part in the env file is not configured) but the registration itself is successful. You may proceed with login using the newly registered account while ignoring the error.  
10. If you want to access admin page with admin account, please refer to the commented instructions inside auth.php.  
11. Only .env file will be used by laravel to render the website. The other .env files such as .env.backup (local environment) and .env.production (production environment) served as template to be copied to .env file to get the specific configurations for that particular environment.  

## Directory Stucture

1. All of frontend files (including livewire frontend files) are located inside resources/views directories. These are the files that will be dispayed to the user when rendering the website in the browser.   
2. All of the livewire controller files are located inside app/Livewire directory. These are the files to define logic implementation to implement any intended functionalities.  
3. All of the policy files are located inside app/Policies directory. These are the files used to define policies which are rules related to the models.  
4. All of the model files are located inside app/Models directory.  These are the files used to define properties or methods of the models.  
5. All of the configuration files such as database.php, filesystems.php, auth.php, etc are located inside config directory. These are the files used to define configuration of the system.  
6. All of the seeder files are located inside datbase/seeders directory. These are the file used to define methods to seed the database with data obtained from APIs or any other sources.  
7. All of the language files are located inside lang directory. These are the files used to render message from a specific language and can be used to implement switch language functionality. Please refer to the video in the links https://www.youtube.com/watch?v=az7m6LIEeTU&list=PLqDySLfPKRn5d7WbN9R0yJA9IRgx-XBlU&index=44 and https://www.youtube.com/watch?v=qLLNhTAuaRk&list=PLqDySLfPKRn5d7WbN9R0yJA9IRgx-XBlU&index=45 for further understanding.  
8. All of the route files are located inside routes directory. These are the files used to define routes to navigate between pages in the web (web.php), define public APIs (api.php), and define schedule tasks (console.php).  
9. All of the filament resource files are located inside app/Filament/Resources directory. These files will be displayed in the admin page.  
10. All of the API resource files are located inside app/Http/Resources/V1 directory. These files are used to return json response from the incoming API request.  
11. All of the controller files including API controller files are located inside app/Http/Controllers (app/Http/Controllers/Api/V1 for API controller files) directory. These files are used as the intermediary between the models and views files because laravel implement MVC (Model-View-Controller) architecture.  

## Copyright from Quran Data Originators

### Tanzil

PLEASE DO NOT REMOVE OR CHANGE THIS COPYRIGHT BLOCK

Tanzil Quran Text (Uthmani, version 1.0.2)  
Copyright (C) 2008-2009 Tanzil.info  
License: Creative Commons BY-ND 3.0 Unported

This copy of quran text is carefully produced, highly  
verified and continuously monitored by a group of specialists  
at Tanzil project.

TERMS OF USE:

Permission is granted to copy and distribute verbatim copies  
of this text, but CHANGING IT IS NOT ALLOWED.

This quran text can be used in any website or application,  
provided its source (Tanzil.info) is clearly indicated, and  
a link is made to http://tanzil.info to enable users to keep  
track of changes.

This copyright notice shall be included in all verbatim copies  
of the text, and shall be reproduced appropriately in all files  
derived from or containing substantial portion of this text.

Please check updates at: http://tanzil.info/updates/

### Quran Corpus

PLEASE DO NOT REMOVE OR CHANGE THIS COPYRIGHT BLOCK

Quranic Arabic Corpus (morphology, version 0.4)  
Copyright (C) 2011 Kais Dukes  
License: GNU General Public License

The Quranic Arabic Corpus includes syntactic and morphological  
annotation of the Quran, and builds on the verified Arabic text  
distributed by the Tanzil project.

TERMS OF USE:

Permission is granted to copy and distribute verbatim copies  
of this file, but CHANGING IT IS NOT ALLOWED.

This annotation can be used in any website or application,  
provided its source (the Quranic Arabic Corpus) is clearly  
indicated, and a link is made to http://corpus.quran.com to enable  
users to keep track of changes.

This copyright notice shall be included in all verbatim copies  
of the text, and shall be reproduced appropriately in all works  
derived from or containing substantial portion of this file.

Please check updates at: http://corpus.quran.com/download


