# inosoft

- composer install
- (for linux / mac) mv .env.example .env  
- (for windows) ren .env.example .env 
- php artisan key:generate
- php artisan migrate --seed
- php artisan jwt:secret
- php artisan serve
- php artisan test
- php artisan test --coverage-html=coverage 

header postman
- Accept : application/json
- Authorization : Bearer {{accessToken}}

Aditional Folders
- Coverage : the last test coverage data
- Collections : postman collections, consist of : auth, kendaraan, user, and global env
