# pretty-json
The new JSON pretty print approach.

Example:

```php
require __DIR__ . '/../vendor/autoload.php';

use jDelta\PrettyJson;

$myData = [
    'service_url' => 'http://example.com/api/my-friends',
    'success' => true,
    'data' => [
        ['id'=>1, 'name'=>'Bill Gates', 'age' => 62],
        ['id'=>2, 'name'=>'Elon Musk', 'age' => 46],
        ['id'=>3, 'name'=>'Mark Zuckerberg', 'age' => 33]
    ],
    'total' => 3,
    'response_time' => '0.0014s'
];

//Before
echo '<pre>';
echo json_encode($myData, JSON_PRETTY_PRINT);
echo '</pre>';

//Now
echo '<pre>';
echo PrettyJson::getPrettyPrint(json_encode($myData));
echo '</pre>';
```

# Result before:
```js
{
    "service_url": "http:\/\/example.com\/api\/my-friends",
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Bill Gates",
            "age": 62
        },
        {
            "id": 2,
            "name": "Elon Musk",
            "age": 46
        },
        {
            "id": 3,
            "name": "Mark Zuckerberg",
            "age": 33
        }
    ],
    "total": 3,
    "response_time": "0.0014s"
}
```

# Result now:
```js
{
    "service_url": "http://example.com/api/my-friends",
    "success": true,
    "data": [
        {"id": 1, "name": "Bill Gates", "age": 62},
        {"id": 2, "name": "Elon Musk", "age": 46},
        {"id": 3, "name": "Mark Zuckerberg", "age": 33}
    ],
    "total": 3,
    "response_time": "0.0014s"
}
```
