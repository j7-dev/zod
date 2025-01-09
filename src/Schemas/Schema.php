<?php
/**
 * Schema 基礎類別
 *
 * 這個檔案包含了所有 Schema 類型的基礎抽象類別，
 * 提供了通用的驗證和解析功能。
 *
 * @package J7\Zod\Schemas
 */

namespace J7\Zod\Schemas;

/**
 * Schema 抽象類別
 *
 * 為所有具體的 Schema 類型提供基礎實作，
 * 包含可選性設定、預設值處理等共用功能。
 */
abstract class Schema {

	/**
	 * 標記該 schema 是否為可選
	 *
	 * @var bool
	 */
	protected $is_optional = false;

	/**
	 * Schema 的預設值
	 *
	 * @var mixed
	 */
	protected $default_value = null;

	/**
	 * 將 schema 設定為可選
	 *
	 * @return self
	 */
	public function optional() {
		$this->is_optional = true;

		return $this;
	}

	/**
	 * 將 schema 設定為必填
	 *
	 * @return self
	 */
	public function required() {
		$this->is_optional = false;

		return $this;
	}

	/**
	 * 設定 schema 的預設值
	 *
	 * @param mixed $value 預設值
	 * @return self
	 */
	public function default( $value ) {
		// Parse the default value to make sure it's valid for the current schema.
		$this->default_value = $this->parse_value($value);

		return $this->optional();
	}

	/**
	 * 解析輸入值
	 *
	 * @param mixed $value 要解析的值
	 * @return mixed 解析後的值
	 */
	public function parse( $value = null ) {
		if ($this->is_optional && is_null($value)) {
			return $this->default_value;
		}

		return $this->parse_value($value);
	}

	/**
	 * 解析具體值的抽象方法
	 *
	 * @param mixed $value 要解析的值
	 * @return mixed 解析後的值
	 */
	abstract protected function parse_value( $value );
}
