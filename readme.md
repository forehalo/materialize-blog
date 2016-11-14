## Materialize Blog

A new blog manage system disigned according to Google [Material Design Spec](https://www.google.com/design/spec/material-design/introduction.html).

Backend based on [Laravel 5.2](https://laravel.com), a web application framework with expressive, elegant syntax.

Demo at [Forehalo' blog](http://forehalo.me).

### Feature

* Collapsible posts list, url: `/`
* Also normal posts view at `/posts`
* Create with markdown (Javascript parser: [marked](https://github.com/chjj/marked), PHP parser: [parsedown](https://github.com/erusev/parsedown)).
* Highlight code & code block ([Prism](http://prismjs.com)).
* Self host comments.
* Artisan CLI to multi-parse articles with given template.


### .Next

* Vuerify - refactor front end with vue.js

### Install

Clone this repository to your computer, or download zip file at [here](https://github.com/forehalo/materialize-blog/archive/master.zip).

    $git clone https://github.com/forehalo/materialize-blog.git blog

Then, same as installing Laravel, run

    composer install

at the root directory. Almost right here.

Configure your `.env` file at the root directory to ensure that you have put right configurations used to connect database.

Next step, run

    php artisan migrate --seed

to migrate the tables. You'd better not miss the `--seed` option, because it will generate some faker in tables, which include the default `username` and `password` to log in dashboard.

###Login

login dashboard at `/login`, default name `admin` or email `admin@example.com` , passowrd `admin`

### License

![](http://i.imgur.com/8ZtPnc7.png)

http://www.gnu.org/licenses/lgpl.txt


## CREATE NICE ARTICLES.
