# Repository Pattern Example

リポジトリパターンを実装してみた例  
- https://github.com/sogaoh/LaravelPractice/pull/3


## Environment
- macOS Mojave 10.14.4
- Docker version 18.09.2, build 6247962 (installed)
- docker-compose version 1.23.2, build 1110ad01 (installed)
- PHP 7.3.3 (cli) (built: Mar 27 2019 01:21:44) ( NTS )
- Laravel Framework 5.8.7


## Prerequirements
- (Same as `README.md` in this directory)
    - Prerequirements
    - Initialize

## Sample data setup
```
# cd /path/to/LaravelPractice

# docker ps                   #(confirm container name)
# docker exec -it php bash

var/www # php artisan migrate
var/www # php artisan db:seed --class=FruitTableSeeder
var/www # exit 

# 
```


## Run Sample
```
# open http://localhost/apii/fruit/all 
-> Display all data (3 records.)   # Not Repository pattern used.


# open http://localhost/api/fruit/2
-> Display a data of id 2          # Repository pattern used.
```


## Source Code (partial)
- Controller
    ```FruitController.php
    
        //Not Repository Pattern
        public function index()
        {
            return JsonResponse::create(
                Fruit::all(),
                Response::HTTP_OK
            );
        }
    
        //!! Repository Pattern !!
        public function show($id)
        {
            if ($id == 0) {
                return JsonResponse::create(
                    $this->fruitRepository->getAll(),
                    Response::HTTP_OK
                );
            }
            return JsonResponse::create(
                $this->fruitRepository->getFirstRecordById($id),
                Response::HTTP_OK
            );
        }
    ``` 

- Repository Implement 
    ```FruitDbRepository.php 
    
    class FruitDbRepository extends Fruit implements FruitRepositoryInterface
    {
        public function getAll()
        {
            return FruitDbRepository::all();
        }
    
        public function getFirstRecordById($id)
        {
            return FruitDbRepository::where('id', '=', $id)->first();
        }
    }
    ```
    
- Service Provider
    ```RepositoryServiceProvider.php[^1]
    
        public function register()
        {
            // Fruit
            $this->app->bind(
                App\Repositories\Fruit\FruitRepositoryInterface::class,
                App\Repositories\Fruit\FruitDbRepository::class
            );
        }
    ```


# Note     
[^1]: `extends ServiceProvider` : `php artisan make:provider RepositoryServiceProvider` で生成可能。その場合、`config\app.php` に追記が必要