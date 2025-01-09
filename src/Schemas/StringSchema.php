<?php
/**
 * StringSchema 類別檔案
 *
 * 此檔案包含用於驗證和處理字串類型數據的結構定義
 *
 * @package J7\Zod\Schemas
 */

namespace J7\Zod\Schemas;

use J7\Zod\Exceptions\InvalidStringException;
use J7\Zod\Exceptions\LongStringException;
use J7\Zod\Exceptions\ShortStringException;

/**
 * StringSchema 類別
 *
 * 用於驗證字串類型的數據，可以設定最小和最大長度限制
 */
class StringSchema extends Schema {

	/**
	 * 字串最小長度
	 *
	 * @var int|null
	 */
	private $min;

	/**
	 * 字串最大長度
	 *
	 * @var int|null
	 */
	private $max;

	/**
	 * 建立新的 StringSchema 實例
	 *
	 * @return static
	 */
	public static function make() {
		return new static();
	}

	/**
	 * 設定字串最小長度
	 *
	 * @param int $min 最小長度
	 * @return $this
	 */
	public function min( $min ) {
		$this->min = $min;

		return $this;
	}

	/**
	 * 設定字串最大長度
	 *
	 * @param int $max 最大長度
	 * @return $this
	 */
	public function max( $max ) {
		$this->max = $max;

		return $this;
	}

	/**
	 * 解析並驗證字串值
	 *
	 * @param mixed $value 要驗證的值
	 * @return string 驗證後的字串
	 * @throws InvalidStringException 當值不是字串時拋出
	 * @throws ShortStringException 當字串長度小於最小長度時拋出
	 * @throws LongStringException 當字串長度大於最大長度時拋出
	 */
	protected function parse_value( $value ) {
		if (! is_string($value)) {
			throw InvalidStringException::make($value);
		}

		if (! is_null($this->min) && strlen($value) < $this->min) {
			throw ShortStringException::make($value, $this->min);
		}

		if (! is_null($this->max) && strlen($value) > $this->max) {
			throw LongStringException::make($value, $this->max);
		}

		return $value;
	}
}
