<?php

use Picturium\Format;
use Picturium\Picturium;
use Picturium\PicturiumImage;
use Picturium\Rotate;
use Picturium\UrlGenerator;

it("generates URL without token", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/");
    $instance = new Picturium("data/test.jpg");
    $image = new PicturiumImage();

    $url = (new UrlGenerator($instance))->generateUrl($image->serialize());
    expect($url)->toBeUrl();
    expect($url)->toBe("http://127.0.0.1:20045/data/test.jpg");
});

it("generates URL with token", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $instance = new Picturium("data/test.jpg");
    $image = new PicturiumImage();

    $url = (new UrlGenerator($instance))->generateUrl($image->serialize());
    expect($url)->toBeUrl();
    expect($url)->toBe(
        "http://127.0.0.1:20045/data/test.jpg?token=25b6f13e813892aa84199686a54da0cffaf66e97b6492c99808d47862fc423d8"
    );
});

it("generates URL with parameters for images", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $instance = new Picturium("data/test.jpg");
    $image = new PicturiumImage();
    $image->width(300)->height(200)->background("blue")->quality(20)->rotate(Rotate::LEFT)->format(Format::AVIF);

    $url = (new UrlGenerator($instance))->generateUrl($image->serialize());
    expect($url)->toBeUrl();
    expect($url)->toBe(
        "http://127.0.0.1:20045/data/test.jpg?bg=blue&f=avif&h=200&q=20&rot=90&w=300&token=9ffef7e9f729af7a0838da2eb3355e00e11f5e609b4e86458c6f2042c7477889"
    );
});

it("generates URL with parameters for original images", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $instance = new Picturium("data/test.jpg");
    $image = new PicturiumImage();
    $image->width(300)->height(200)->background("blue")->quality(20)->rotate(Rotate::LEFT)->original();

    $url = (new UrlGenerator($instance))->generateUrl($image->serialize());
    expect($url)->toBeUrl();
    expect($url)->toBe(
        "http://127.0.0.1:20045/data/test.jpg?original=true&token=a639d96dd9a9129c8bd0d2dec1b463eac2a9fcccec2e4e024e15f0aca855ef79"
    );
});

it("generates URL with parameters for documents", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $instance = new Picturium("data/test.pdf");
    $image = new PicturiumImage();
    $image->width(300)->height(200)->quality(20)->thumb(2)->rotate(Rotate::LEFT)->format(Format::AVIF);

    $url = (new UrlGenerator($instance))->generateUrl($image->serialize());
    expect($url)->toBeUrl();
    expect($url)->toBe(
        "http://127.0.0.1:20045/data/test.pdf?f=avif&h=200&q=20&rot=90&thumb=p:2&w=300&token=ca21f269920a6254250648c3ea99e1c3a48e7edfa6279b937c6914aee336e40f"
    );
});
