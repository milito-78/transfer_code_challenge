## Bank Transfer System
This project implement with Clean architecture & DDD.

To start project please follow these steps:

- run `php artisan migrate --seed`

## Api documentation

This system has 2 api.

| Title                     | Method | Route                                | Body                                                                                                                    | Response                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |  
|---------------------------|--------|--------------------------------------|-------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Transfer By Card          | POST   | _base_url_/v1/transfers/card-to-card | `{"origin_card_number" : "3528413185345594",    "destination_card_number" : "4929048107443656",    "amount" : "5000" }` | `{"message":"Successfully created","data":{"id":27,"card_id":1,"destination_card_id":2,"amount":5000,"pure_amount":4500,"fee":500,"tracking_code":"h4tGwpreTNwQNOAx684295","status_id":2,"status_label":"Success","type_id":-1,"type_label":"Decrease","created_at":"2024-01-19 12:44:05","updated_at":"2024-01-19 12:44:05"}}`                                                                                                                                                                                                                                                                                                                                                                        |
| Get top three transactors | GET    | _base_url_/v1/top-users              |                                                                                                                         | `{"message":"successful","data":[{"id":5,"name":"Jamil Hessel III","transactions":[{"id":8,"card_id":5,"card":{"id":5,"card_number":"3528216776147042","status_id":1,"status_label":"Active","expired_at":"2025-01-19 00:00:00"},"destination_card_id":9,"destination_card":{"id":9,"card_number":"4539313329284862","status_id":1,"status_label":"Active","expired_at":"2025-01-19 00:00:00"},"amount":9,"pure_amount":1,"fee":6,"tracking_code":"mZnktJbHfxhNcXkPZqIu","status_id":2,"status_label":"Success","type_id":-1,"type_label":"Decrease","created_at":"2024-01-19 01:27:08","updated_at":"2024-01-19 01:27:08"}],"created_at":"2024-01-19 01:27:08","updated_at":"2024-01-19 01:27:08"}]}` |

You can use postman collection in [postman folder](postman)

## Testing

To run tests, please use laravel run test command:

`php artisan test`

Project has only unit tests for repositories. :/
