# Repository Files Make Command

リポジトリパターン実装用のスケルトンファイル生成コマンドを自作した


## Environment
- macOS Mojave 10.14.4
- PHP 7.3.5 (cli) (built: May  2 2019 12:40:36) ( NTS )
- Laravel Framework 5.8.7


## 準備
``` 
# cd /path/to/LaravelPractice/server
# composer install
```

## 使用法
```
# php artisan make:repository Hoge

-> (成功)
Repository files created successfully.

```


## 実装手順概要
- `php artisan make:command Repository`
- /path/to/LaravelPractice/server/app/Console/Commands/Repository.php が生成される
- App\Console\Commands\Repository.php # handle を実装
    - see [./server/app/Console/Commands\Repository.php](./server/app/Console/Commands\Repository.php)


## Refs
- [Laravel5.3で自作artisanコマンド.md](https://bmf-tech.com/posts/Laravel5.3%E3%81%A6%E3%82%99%E8%87%AA%E4%BD%9Cartisan%E3%82%B3%E3%83%9E%E3%83%B3%E3%83%88%E3%82%99.md) 
    - 2016-12-18
    

## Others
``` 
❯ php artisan list | grep 'make:repository'
  make:repository      Create repository files.
```
