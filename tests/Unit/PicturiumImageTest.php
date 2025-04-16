<?php

use Picturium\Picturium;
use Picturium\PicturiumImage;

beforeEach(function () {
    $this->img = new PicturiumImage();
});

it("creates image instance without src", function () {
    expect($this->img)->toBeInstanceOf(PicturiumImage::class);
    expect(fn() => $this->img->src())->toThrow("Please, provide image source!");
});

it("creates image instance with src", function () {
    $instance = new PicturiumImage("data/test.jpg");

    expect($instance)->toBeInstanceOf(PicturiumImage::class);
    expect(fn() => $instance->src())->not->toThrow("Please, provide image source!");
});

it("returns the correct media query", function () {
    $this->img->minWidth(-10);
    expect($this->img->media())->toBe("(min-width: 0px)");

    $this->img->minWidth(1);
    expect($this->img->media())->toBe("(min-width: 1px)");
});

it("returns the correct src", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $this->img->width(300);

    expect($this->img->src("data/test.jpg"))->toBe(
        "http://127.0.0.1:20045/data/test.jpg?w=300&token=2ef3ee77915c035f7e3e92ea9662b798b2b7121660a967590fe3e069d05d56c5"
    );
});

it("returns the correct srcset", function () {
    Picturium::configure("default", "http://127.0.0.1:20045/", "168b2fb584075e1f5120dcd644477496c67");
    $this->img->width(300)->maxDPR(3);

    expect($this->img->srcset("data/test.jpg"))->toBe(
        "http://127.0.0.1:20045/data/test.jpg?w=300&token=2ef3ee77915c035f7e3e92ea9662b798b2b7121660a967590fe3e069d05d56c5 1x, http://127.0.0.1:20045/data/test.jpg?dpr=2&w=300&token=0307471c908e80a68c6fa4dc9a894986e930b557a367099291a39a2935b64f87 2x, http://127.0.0.1:20045/data/test.jpg?dpr=3&w=300&token=5bdbe9d9b2d5efd493497a9934caff7d6b2b399ec6d7389ceedec7932524e833 3x"
    );
});
