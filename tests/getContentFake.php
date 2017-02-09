<?php

/*
|--------------------------------------------------------------------------
| getContent Fake
|--------------------------------------------------------------------------
|
| Since the getContent function requires the use of monkcms.php
| for testing purposes we will just fake a getContent call
| and return data that matches the expected response
|
*/
function getContent(...$args)
{
    if ($args[0] == 'page') {
        return [
            'show'=>
            [
                'title' => 'Example Page Title',
                'description' => 'Example Page Description',
                'tags' => 'Example Page Keywords'
            ]
        ];
    }
    if ($args[0] == 'event') {
        return [
            'show'=>
            [
                'title' => 'Example Event Title',
                'description' => 'Example Event Description',
                'category' => 'Example Event Keywords',
                'imageurl' => 'http://www.placecage.com/1200/630'
            ]
        ];
    }
    if ($args[0] == 'sermon') {
        return [
            'show'=>
            [
                'title' => 'Example Sermon Title',
                'summary' => 'Example Sermon Description',
                'tags' => 'Example Sermon Keywords',
                'imageurl' => 'http://www.placecage.com/1200/630'
            ]
        ];
    }
    if ($args[0] == 'media') {
        return [
            'show'=>
            [
                'imageurl' => 'http://www.placecage.com/1200/630'
            ]
        ];
    }
}
