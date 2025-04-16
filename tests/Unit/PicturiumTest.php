<?php

use Picturium\Picturium;

it("uses correct instance configuration", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/");
    Picturium::configure("another", "http://localhost:20046/", "withtoken");

    $autoDefaultInstance = new Picturium("data/test.jpg");
    expect($autoDefaultInstance->getInstance())->toMatchArray([
        "url" => "http://127.0.0.1:20045/",
        "token" => null,
    ]);

    $defaultInstance = new Picturium("data/test.jpg", "default");
    expect($defaultInstance->getInstance())->toMatchArray([
        "url" => "http://127.0.0.1:20045/",
        "token" => null,
    ]);

    $anotherInstance = new Picturium("data/test.jpg", "another");
    expect($anotherInstance->getInstance())->toMatchArray([
        "url" => "http://localhost:20046/",
        "token" => "withtoken",
    ]);
});
