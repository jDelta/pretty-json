# pretty-json
The new JSON pretty print approach.

Example:

```php
require __DIR__ . '/../vendor/autoload.php';

use jDelta\PrettyJson;

$myData = [
    'success' => true,
    'data' => [
        ['id'=>1, 'name'=>'Bill Gates', 'age' => 62],
        ['id'=>2, 'name'=>'Elon Musk', 'age' => 46],
        ['id'=>3, 'name'=>'Mark Zuckerberg', 'age' => 33]
    ],
    'total' => 3
];
//Before
echo '<pre>';
echo json_encode($myData, JSON_PRETTY_PRINT);
echo '</pre>';
//Now
echo '<pre>';
echo PrettyJson::getPrettyJson(json_encode($myData));
echo '</pre>';
```

# Result before:
```js
{
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
    "total": 3
}
```

# Result now:
```js
{
    "success": true,
    "data": [
        {"id": 1, "name": "Bill Gates", "age": 62},
        {"id": 2, "name": "Elon Musk", "age": 46},
        {"id": 3, "name": "Mark Zuckerberg", "age": 33}
    ],
    "total": 3
}
```
