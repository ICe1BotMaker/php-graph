# php-graph
A dirty-looking php graph.

*The module file is `__module__lib__gd__.php`.*


> **WARNING! This module only works in `php 8.0`**
> #### Because it is still beta,
> **the line graph does not work.**


**To set `php.ini` before use:**

- First, run the editor and open the `php.ini` file.

- Then use `Ctrl + F` or search to find `;extension=gd`.

- If you look at the front, it's annotated with a semiclon, but erase the semiclon.

- Now when you're ready to use the `gd` library, you're going to say, `__module__lib__gd__.php` and calls the `imagegraph` function.

The module is now ready for use! The parameters can be set as follows.

```
defaultFont = (string); // Set the default font.

chartX = (number); // Chart Position x
chartY = (number); // Chart Position y

chartOffsetX = (number); // Width of the element to which external elements other than the figure will fit in "600x600"
chartOffsetY = (number); // Height of the element to which external elements other than the figure will fit in "600x600"

chartWidth = (number); // Width of chart
chartHeight = (number); // Height of chart

data = [ // Chart Info
    title = (string); // Chart Title
    type = (string); // Chart Type (bar | line)
    chart_data = [ // Chart Data
        square_height = (number); // Chart Bar Height
        data_colors = (array); // Chart Bar Colors
        min_value = (number); // Chart Min Value
        max_value = (number); // Chart Max Value
        datas = (array); // Chart Datas
    ]
]
```

<br>

examples of use:

```php
<?php
require_once "./__module__lib__gd__.php";

$imgData = imagecreatetruecolor(750, 750);

$transparent = rgba($imgData, 255, 255, 255, 127);
imagefill($imgData, 0, 0, $transparent);

$data = [
    "title" => "IT'S EXAMPLE",
    "type" => "bar",
    "chart_data" => [
        "square_height" => 75,
        "data_colors" => [
            [35 + 25, 25 + 25, 66 + 25],
            [94, 84, 142],
            [159, 134, 192],
            [190, 149, 196],
        ],
        "min_value" => 0,
        "max_value" => 24,
        "datas" => []
    ]
];

for ($i = 0; $i < count(<your-datas>); $i++) {
    $data["chart_data"]["datas"][$i] = [
        "name" => <your-datas>[$i]-><your-key>,
        "legend" => <your-datas>[$i]-><your-key>,
        "value" => <your-datas>[$i]-><your-key>
    ];
}

imagegraph($imgData, $defaultFont, 0, 0, 75, 100, 750, 750, $data);

imagepng($imgData);
imagedestroy($imgData);
?>
```
