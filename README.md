Readme quick notes:

1. List tasks

web: http://127.0.0.1:8000/tasks
api: curl http://127.0.0.1:8000/api/tasks
console: php artisan tasks:list

2. Add new task
web: http://127.0.0.1:8000/tasks/add
api: curl -i -d "url=https://store-images.s-microsoft.com/image/apps.50484.9007199266244427.4d45042b-d7a5-4a83-be66-97779553b24d.2c71c1ea-c28f-4dd1-b72d-c43cdd3476f4?mode=scale&q=90&h=300&w=200" -X POST http://127.0.0.1:8000/api/tasks
console: php artisan task:add http://www.google.com

3. Download task
web: http://127.0.0.1:8000/tasks/37/download
api: curl http://127.0.0.1:8000/api/tasks/37/download > somedoc.txt
console: 

Queue run: php artisan queue:work --tries=3

.\vendor\bin\phpunit