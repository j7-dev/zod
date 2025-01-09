<?php

namespace J7\Zod\Exceptions;

class InvalidStringException extends \Exception {

	public static function make( $value ) {
		return new static('Invalid string. Expected a string, `' . gettype($value) . '` given.');
	}
}
