<?php

namespace J7\Zod\Tests\Schemas;

use J7\Zod\Exceptions\InvalidStringException;
use J7\Zod\Exceptions\LongStringException;
use J7\Zod\Exceptions\ShortStringException;
use J7\Zod\Zod as Z;

it('should parse a string', function () {
    // Act.
    $result = Z::string()->parse('test');

    // Assert.
    expect($result)->toEqual('test');
});

it('should validate string length', function () {
    // Act & Assert.
    expect(function () {
        Z::string()->min(5)->parse('1');
    })->toThrow(ShortStringException::class);

    expect(function () {
        Z::string()->max(1)->parse('123');
    })->toThrow(LongStringException::class);
});

it('should throw for non-strings', function () {
    // Act & Assert.
    expect(function () {
        Z::string()->parse([]);
    })->toThrow(InvalidStringException::class);
});
