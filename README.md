# heroku-php-getting-started

> Potongan kode PHP berbasis [Silex](http://silex.sensiolabs.org/) framework, untuk deploy di heroku.

## Cara Deploy

Install terlebih dahulu [Heroku Toolbelt](https://toolbelt.heroku.com/).

### 🛒 Persiapan Aplikasi
```sh
# clone kode dari git
$ git clone https://github.com/ghostvar/heroku-php-getting-started.git

# masuk ke folder hasil clone
$ cd heroku-php-getting-started

# buat app di heroku
$ heroku create 

# upload kode ke cloud
$ git push heroku main
```

### 📦 Persipan Database
```sh
# install database postgres di heroku
$ heroku addons:create heroku-postgresql:hobby-dev

# masuk ke database 
$ heroku pg:psql
```

### 📥 Restore Database
```sql
-- buat tabel
CREATE TABLE test_table (
	id serial NOT NULL,
	"name" text NULL,
	CONSTRAINT test_table_pkey PRIMARY KEY (id)
);

-- insert data
INSERT INTO test_table (id, "name") VALUES(1, 'hello database');

-- keluar dari database
\q
```

### 📌 Penutup
```sh
# buka app di browser
$ heroku open
```

Atau

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

## Dokumentasi

> Akan datang.

For more information about using PHP on Heroku, see these Dev Center articles:

- [Getting Started with PHP on Heroku](https://devcenter.heroku.com/articles/getting-started-with-php)
- [PHP on Heroku](https://devcenter.heroku.com/categories/php)