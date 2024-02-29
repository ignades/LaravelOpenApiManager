
## About LaravelOpenApiManager Author:Ignacio Sebastian Olivieri first version  27/02/2024

To do a best Documentation to work on a team I think 27/02/2024 to start create an application to create very fast the annotations on each Controller of laravel to use with Swagger

- [Swagger-OpenAPI Specification](https://swagger.io/docs/specification/about/).

## Requirements

To work with this Package is essential observe rules 

- Use Correct Names of Controllers and Models this code is based on this logic . 
- Example1 Controller ( ProductsController ) Model (Product) OK
- Example2 Controller ( ProdController ) Model (Products) BAD! 
- You can use Resources Routes and Personal Routes of your Controller, Only in : dir routes/api.php OK

`` Mandatory ``
- Step1 Create Controller with methods
- Step2 Create Migration Table with methods
- Step3 Create Model with methods
- Step4 Create Routes with methods or Resource 

- Artisan Commands : to add Annotations on your controller you need use command this will generate the Annotations for each Api Method

- php artisan app:create-swagl5

- Thi documentation and code is under Construction actually work but need more Parameters this will be do from me ;).
- Mandatory : The parameters passed from Url as follow 
- 
- Routes
- Route::post('/product/{id}/{price}', [ProductsController::class,'myMethod']);
- This {id}/{price} parameters are the fields of the DB table so you need write the names equals as reflection of tabel


- Route::post('/product/{id}/{price}', [ProductsController::class,'myMethod']);  OK!
- |--Table 
- |-------- id
- |-------- name
- |-------- price
- |-------- description

- Route::post('/product/{id_prod}/{price_product}', [ProductsController::class,'myMethod']);  BAD!
- |--Table
- |-------- id
- |-------- name
- |-------- price
- |-------- description
