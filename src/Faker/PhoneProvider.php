<?php


namespace App\Faker;

use Faker\Provider\Base;

class PhoneProvider extends Base
{
    const MODEL_NAME = [
        'Samsung Galaxy S5',
        'Samsung Galaxy S6',
        'Samsung Galaxy S7',
        'Samsung Galaxy S8',
        'Samsung Galaxy Note 1',
        'Samsung Galaxy Note 2',
        'Samsung Galaxy Note 3',
        'Apple Iphone 4',
        'Apple Iphone 5',
        'Apple Iphone 6',
        'Apple Iphone 7',
        'Apple Iphone 8',
        'Huawei P8',
        'Huawei P9',
        'Huawei P10',
        'Xperia M4',
        'Xperia M5',
        'Xperia MX',
        'Nokia Lumia 650',
        'Nokia Lumia 750',
        'Nokia Lumia 850',
    ];

    const MODEL_REF = [
        'MG-205',
        'XC-555',
        'GTS-324',
        'MGS-2587',
        'ZTX-5419',
        'MLT-4125',
        'QTP-2659',
        'QRZ-2751',
    ];

    const COLOR = [
        'noir',
        'blanc',
        'vert',
        'rouge',
        'bleu',
        'or',
        'argent',
    ];

    public function modelName()
    {
        return self::randomElement(self::MODEL_NAME);
    }

    public function modelRef()
    {
        return self::randomElement(self::MODEL_REF);
    }

    public function memory()
    {
        return rand(4, 128);
    }
    public function color()
    {
        return self::randomElement(self::COLOR);
    }

    public function price()
    {
        return rand(100, 1000);
    }
}
