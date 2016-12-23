# Materialize Blog

A new blog management system disigned according to Google [Material Design](https://www.google.com/design/spec/material-design/introduction.html).

Back-end base on [Laravel 5.3](https://laravel.com), a PHP application framework with expressive, elegant syntax.

Front-end built with [Vue](https://vuejs.org), a Progressive
JavaScript Framework bring data binding to js.

Demo at [Forehalo' blog](http://forehalo.me).

## Feature

* Single page (Vue)
* Create with markdown (Javascript parser: [marked](https://github.com/chjj/marked), PHP parser: [parsedown](https://github.com/erusev/parsedown)).
* Code highlight ([Prism](http://prismjs.com)).
* Self host comments.
* Easy localization

## Install

Clone this repository to local, or download zip file at [here](https://github.com/forehalo/materialize-blog/archive/master.zip).

```
$git clone https://github.com/forehalo/materialize-blog.git blog
```

Then, install Laravel and other php dependencies, run

```
composer install
chmod 777 -R storage/
chmod 777 -R bootstrap/cache/
```

at the root directory. Almost right here.

Configure your `.env` file at the root directory to ensure that you have put right configurations used to connect database.

Next step, migrate tables and seed fakers

```
php artisan migrate
php artisan db:seed
```

> The `db:seed` command will seed all tables. If you just want to pre-generate an admin account, run with option `--class=AdminTableSeeder`

Now you can login dashboard at `/dashboard` with name `admin` or email `admin@example.com`, password `admin`.

## Custom

All front-end assets has been compiled so you could directly use them without compiling manually.

But if you don't like the default theme, hm... OK, install front-end environment and DIY.

```
yarn install    // or "npm install"
```

`yarn` is another package manager like `npm`, [read more](https://yarnpkg.com/en/docs/). 

Resources are putted in `/resources` folder.
```
├─assets
│  ├─fonts
│  │  └─material-design-icons        ------ icon files
│  ├─js                              ------ js workspace
│  │  ├─blog                           ------ user entery
│  │  │  ├─archives
│  │  │  ├─navigations
│  │  │  ├─pages
│  │  │  └─posts
│  │  ├─components                     ------ global components
│  │  └─dashboard                      ------ dashboard entery
│  │      ├─posts
│  │      └─settings
│  └─sass                            ------ sass workspace
│      ├─blog
│      └─dashboard
├─lang                               ------ language dictionary
│  ├─en
│  └─zh-CN
└─views
    ├─auth
    ├─blog
    └─dashboard
```

### Style & Script

run the following command after install all dependencies. This will watch all assets files, and auto-compile when change saved.

Before working, ensure you know well about [Vue](https://vuejs.org) and [Sass](http://sass-lang.com).

```
yarn run dev
```

### Language

You can esaily add another language support by adding a subfolder in `resources/lang`. Every file returns a php array. Copy and translate all the files.

> Dictionary used by Vue should be putted in `resources/lang/your_lang/app.php`

Modify the `locale` item value to your default language folder name in `config/app.php`. Done!

Then, use `trans()` global helper function in PHP, and `this.$trans()` in Vue components.

## License

[MIT](http://opensource.org/licenses/MIT)

Copyright (c) 2015-2016 Forehalo
