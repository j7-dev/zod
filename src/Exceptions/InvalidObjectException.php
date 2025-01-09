<?php

namespace J7\Zod\Exceptions;

class InvalidObjectException extends \Exception {

	public static function make( $value ) {
		return new static('Invalid object. Expected an object or associative array, `' . gettype($value) . '` given.');
	}
}
