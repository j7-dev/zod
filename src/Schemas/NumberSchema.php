<?php
/**
 * NumberSchema 類別檔案
 *
 * 此檔案包含用於驗證和處理數字類型的結構定義
 *
 * @package J7\Zod\Schemas
 */

namespace J7\Zod\Schemas;

use J7\Zod\Exceptions\BigNumberException;
use J7\Zod\Exceptions\InvalidNumberException;
use J7\Zod\Exceptions\SmallNumberException;

/**
 * NumberSchema 類別
 *
 * 用於驗證數字類型的結構，支援最小值和最大值的限制
 */
class NumberSchema extends Schema {

	/**
	 * 最小值限制
	 *
	 * @var float|int|null
	 */
	private $min;

	/**
	 * 最大值限制
	 *
	 * @var float|int|null
	 */
	private $max;

	/**
	 * 建立新的 NumberSchema 實例
	 *
	 * @return static
	 */
	public static function make() {
		return new static();
	}

	/**
	 * 設定數字的最小值限制
	 *
	 * @param float|int $min 最小值
	 * @return $this
	 */
	public function min( $min ) {
		$this->min = $min;

		return $this;
	}

	/**
	 * 設定數字的最大值限制
	 *
	 * @param float|int $max 最大值
	 * @return $this
	 */
	public function max( $max ) {
		$this->max = $max;

		return $this;
	}

	/**
	 * 解析並驗證數值
	 *
	 * @param mixed $value 要驗證的值
	 * @return float|int
	 * @throws InvalidNumberException 當輸入值不是有效的數字時
	 * @throws SmallNumberException 當數值小於最小值限制時
	 * @throws BigNumberException 當數值大於最大值限制時
	 */
	protected function parse_value( $value ) {
		if (! is_numeric($value)) {
			throw InvalidNumberException::make($value);
		}

		// Convert both integers and floats to numbers.
		$value = $value + 0;

		if (! is_null($this->min) && $value < $this->min) {
			throw SmallNumberException::make($value, $this->min);
		}

		if (! is_null($this->max) && $value > $this->max) {
			throw BigNumberException::make($value, $this->max);
		}

		return $value;
	}
}
