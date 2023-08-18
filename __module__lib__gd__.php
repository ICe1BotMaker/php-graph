<?php
function rgba($imgData, $red, $green, $blue, $alpha = 0) {
    return imagecolorallocatealpha($imgData, $red, $green, $blue, $alpha);
}

function text($imgData, $font, $fontSize, $text, $x, $y, $color) {
    $bountArr = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $bountArr[2] - $bountArr[0];
    $textHeight = $bountArr[1] - $bountArr[3];

    $x = $x - $textWidth * 0.5;
    $y = $y + $textHeight * 0.5;

    imagefttext($imgData, $fontSize, 0, $x, $y, $color, $font, $text);
}

function category($imgData, $font, $fontSize, $text, $x, $y, $rectColor, $textColor) {
    imagefilledrectangle($imgData, $x, $y, $x + 15, $y + 15, $rectColor);
    imagefttext($imgData, $fontSize, 0, $x + 20, $y + 12, $textColor, $font, $text);
}

function imagelinedotted($im, $x1, $y1, $x2, $y2, $dist, $col) {
    $transp = imagecolortransparent($im);
    $style = array($col);
    
    for ($i = 0; $i < $dist; $i++) {
        array_push($style, $transp);
    }
    
    imagesetstyle($im, $style);
    imageline($im, $x1, $y1, $x2, $y2, IMG_COLOR_STYLED);
    imagesetstyle($im, array($col));
}

function wave($imageData, $width, $height, $steps, $x1, $text_color) {
    for ($i = 1; $i <= ($width / $steps); $i++) {
        $y1 = ($height / 2) - number_format(sin(deg2rad($x1)) * 90, 0);
        $x2 = $x1 + $steps;
        
        $y2 = ($height / 2) - number_format(sin(deg2rad($x2)) * 90, 0);
        
        imageline($imageData, $x1, $y1, $x2, $y2, $text_color);
        
        $x1 = $x2;
    }
}

function imagegraph(
    $imgData,

    $defaultFont = "./fonts/GmarketSansMedium.otf", 

    $chartX = 0, 
    $chartY = 0, 
    
    $chartOffsetX = 75, 
    $chartOffsetY = 100, 
    
    $chartWidth = 750, 
    $chartHeight = 750, 
    
    $data = [
        "title" => "no title", 
        "type" => "bar",
        "chart_data" => [
            "square_height" => 75, 
            "data_colors" => [], 
            "min_value" => 0,
            "max_value" => 48,
            "datas" => []
        ]
    ]
    ) {
    $whiteColor = rgba($imgData, 255, 255, 255);
    $blackColor = rgba($imgData, 0, 0, 0);
    $grayColor = rgba($imgData, 150, 150, 150);
    $smokeColor = rgba($imgData, 200, 200, 200);

    // TITLE
    text($imgData, $defaultFont, 18, $data["title"], 375 + $chartX, 65 + $chartY, $blackColor);

    // CHART BORDER
    imagesetthickness($imgData, 1);
    imagerectangle($imgData, $chartOffsetX + $chartX, $chartOffsetY + $chartY, $chartWidth - $chartOffsetX + $chartX, $chartHeight - $chartOffsetY + $chartY, $grayColor);

    for ($i = 0; $i < $data["chart_data"]["max_value"] / 2; $i++) {
        imagesetthickness($imgData, 1);
        imagelinedotted($imgData, $chartX + 75 + (($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])) / 2) * 2 + (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"]))) * 2, $chartOffsetY + $chartY, $chartX + 75 + (($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])) / 2) * 2 + (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"]))) * 2, $chartHeight - $chartOffsetY + $chartY, 2, $smokeColor);
    
        if ($i < 11) {
            imagesetthickness($imgData, 1);
            imagelinedotted($imgData, $chartOffsetX + $chartX, 125 + ($i * 50) + $chartY, $chartWidth - $chartOffsetX + $chartX, 125 + ($i * 50) + $chartY, 2, $smokeColor);
        }
    }

    // CHART UNIT
    for ($i = $data["chart_data"]["min_value"]; $i <= $data["chart_data"]["max_value"]; $i++) {
        if ($i % 2 == 0) text($imgData, $defaultFont, 8, $i, $chartX + 75 + ($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"]))), $chartY + $chartHeight - $chartOffsetY + 15, $blackColor);

        if ($i % 2 == 0 && $i != $data["chart_data"]["max_value"]) {
            imagesetthickness($imgData, 1);
            imagelinedotted($imgData, $chartX + 75 + ($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])) / 2) * 2 + (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])), $chartOffsetY + $chartY, $chartX + 75 + ($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])) / 2) * 2 + (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"])), $chartHeight - $chartOffsetY + $chartY, 10, $smokeColor);
        }

        imageline($imgData, $chartX + 75 + ($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"]))), $chartY + $chartHeight - $chartOffsetY + 3, $chartX + 75 + ($i * (($chartWidth - ($chartOffsetX * 2)) / ($data["chart_data"]["max_value"]))), $chartY + $chartHeight - $chartOffsetY - 5, $i % 2 == 0 ? $blackColor : $smokeColor);
    }

    for ($i = 0; $i <= 24; $i++) {
    }

    // CHART DATA
    $squareHeight = $data["chart_data"]["square_height"];
    $dataColors = $data["chart_data"]["data_colors"];
    $chart1Data = $data["chart_data"]["datas"];

    $idx = 0;
    $lineIdx = 0;

    for ($i = 0; $i < count($chart1Data); $i++) {
        if ($data["type"] == "bar") {
            imagesetthickness($imgData, 0);
            imagefilledrectangle($imgData, $chartOffsetX + $chartX, $chartOffsetY + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + 50 + $chartY, $chartOffsetX + $chartX + $chart1Data[$i]["value"] * (600 / $data["chart_data"]["max_value"]), $chartOffsetY + $squareHeight + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + 50 + $chartY, rgba($imgData, $dataColors[$i][0], $dataColors[$i][1], $dataColors[$i][2]));

            text($imgData, $defaultFont, 8, $chart1Data[$i]["name"], $chartOffsetX - 25 + $chartX, $chartOffsetY + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + $chartY + 55 + $squareHeight / 2, $blackColor);
            imagefttext($imgData, 12, 0, $chartOffsetX + $chartX + 10, $chartOffsetY + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + 75 + $chartY, $whiteColor, $defaultFont, $chart1Data[$i]["value"]);

            category($imgData, $defaultFont, 10, isset($chart1Data[$i]["legend"]) ? $chart1Data[$i]["legend"] : $chart1Data[$i]["name"], $chartX + $chartWidth - $chartOffsetX + 25, $chartY + $chartOffsetY + 15 + ($i * 25), rgba($imgData, $dataColors[$i][0], $dataColors[$i][1], $dataColors[$i][2]), $blackColor);
        } elseif ($data["type"] == "line") {
            if ($i != 0) {
                imagesetthickness($imgData, 5);
                imageline($imgData, $chartOffsetX + $chartX + $chart1Data[$i]["value"] * (600 / $data["chart_data"]["max_value"]), $chartOffsetY + $squareHeight + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + 50 + $chartY - 50, $chartOffsetX + $chartX + $chart1Data[$i - 1]["value"] * (600 / $data["chart_data"]["max_value"]), $chartOffsetY + $squareHeight + (750 / (count($data["chart_data"]["datas"])) / 2 * $i) + 50 + $chartY - ((count($chart1Data) * 35)), rgba($imgData, $dataColors[$i][0], $dataColors[$i][1], $dataColors[$i][2]));
            }

            if ($idx % 6 == 0) {
                $idx = 0;
                $lineIdx += 1;
            }
            category($imgData, $defaultFont, 10, $chart1Data[$i]["name"], $chartX + $chartOffsetX + ($idx * (strlen($chart1Data[$i]["name"]) + 100)), $chartHeight - $chartOffsetY + ($lineIdx * 25), rgba($imgData, $dataColors[$i][0], $dataColors[$i][1], $dataColors[$i][2]), $blackColor);
            $idx += 1;
        }
    }
}

// header("Content-type: image/png");

// $imgData = imagecreatetruecolor(825, 750);

// $transparent = rgba($imgData, 255, 255, 255, 127);
// imagefill($imgData, 0, 0, $transparent);

// $data = [
//     "title" => "IT'S EXAMPLE",
//     "type" => "bar",
//     "chart_data" => [
//         "square_height" => 75,
//         "data_colors" => [
//             [35 + 25, 25 + 25, 66 + 25],
//             [94, 84, 142],
//             [159, 134, 192],
//             [190, 149, 196],
//         ],
//         "min_value" => 0,
//         "max_value" => 24,
//         "datas" => []
//     ]
// ];

// for ($i = 0; $i < 4; $i++) {
//     $data["chart_data"]["datas"][$i] = [
//         "name" => "a" . $i,
//         "legend" => "abcdef" . $i,
//         "value" => $i * 5
//     ];
// }

// imagegraph($imgData, "./fonts/GmarketSansMedium.otf", 0, 0, 75, 100, 750, 750, $data);

// imagepng($imgData);
// imagedestroy($imgData);
