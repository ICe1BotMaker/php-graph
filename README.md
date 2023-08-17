# php-graph
A dirty-looking php graph.

*The module file is `__module__lib__gd__.php`.*

<br>

**To set `php.ini` before use:**

- First, run the editor and open the `php.ini` file.

- Then use `Ctrl + F` or search to find `;extension=gd`.

- If you look at the front, it's annotated with a semiclon, but erase the semiclon.

- Now when you're ready to use the `gd` library, you're going to say, `__module__lib__gd__.php` and calls the `imagegraph` function.

The module is now ready for use! The parameters can be set as follows.

```
canvasWidth = (number);
canvasHeight = (number);

defaultFont = (string);

chartX = (number);
chartY = (number);

chartOffsetX = (number);
chartOffsetY = (number);

chartWidth = (number);
chartHeight = (number);

data = [
    title = (string);
    type = (string);
    chart_data = [
        square_height = (number);
        data_colors = (array);
        min_value = (number);
        max_value = (number);
        datas = (array);
    ]
]
```

<br>

examples of use:

```php
imagegraph(750, 750, "./fonts/GmarketSansMedium.otf", 0, 0, 75, 100, 750, 750, [
    "title" => "INPUT CHART TITLE",
    "type" => "bar",
    "chart_data" => [
        "square_height" => 75,
        "data_colors" => [
            [rand(0, 255), rand(0, 255), rand(0, 255)],
            [rand(0, 255), rand(0, 255), rand(0, 255)],
            [rand(0, 255), rand(0, 255), rand(0, 255)],
            [rand(0, 255), rand(0, 255), rand(0, 255)],
        ],
        "min_value" => 0,
        "max_value" => 48,
        "datas" => [
            [
                "name" => "test1",
                "value" => rand(0, 48)
            ],
            [
                "name" => "test2",
                "value" => rand(0, 48)
            ],
            [
                "name" => "test3",
                "value" => rand(0, 48)
            ],
            [
                "name" => "test4",
                "value" => rand(0, 48)
            ]
        ]
    ]
]);
```
