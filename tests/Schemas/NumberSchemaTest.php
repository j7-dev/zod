<?php

namespace J7\Zod\Tests\Schemas;

use J7\Zod\Exceptions\BigNumberException;
use J7\Zod\Exceptions\InvalidNumberException;
use J7\Zod\Exceptions\SmallNumberException;
use J7\Zod\Zod as Z;

it('should parse numbers', function () {
    // Act & Assert.
    expect(Z::number()->parse(42))->toEqual(42);
    expect(Z::number()->parse(42.5))->toEqual(42.5);
    expect(Z::number()->parse('42'))->toEqual(42);
});

it('should validate number size', function () {
    // Act & Assert.
    expect(function () {
        Z::number()->min(5)->parse(1);
    })->toThrow(SmallNumberException::class);

    expect(function () {
        Z::number()->max(1)->parse(2);
    })->toThrow(BigNumberException::class);
});

it('should throw for non-numbers', function () {
    // Act & Assert.
    expect(function () {
        Z::number()->parse('test');
    })->toThrow(InvalidNumberException::class);
});
