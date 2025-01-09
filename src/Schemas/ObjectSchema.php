<?php
/**
 * ObjectSchema 類別檔案
 *
 * 此檔案包含用於處理物件結構驗證的 ObjectSchema 類別
 *
 * @package J7\Zod\Schemas
 */

namespace J7\Zod\Schemas;

use J7\Zod\Exceptions\InvalidObjectException;
use J7\Zod\Exceptions\InvalidObjectSchemaException;

/**
 * ObjectSchema 類別
 *
 * 用於驗證和解析物件結構的結構定義類別
 *
 * @package J7\Zod\Schemas
 */
class ObjectSchema extends Schema {

	/**
	 * @var Schema[] 結構定義陣列
	 */
	private $schema;

	/**
	 * 建構子
	 *
	 * @param Schema[] $schema 物件結構定義陣列
	 * @throws InvalidObjectSchemaException 當結構定義無效時拋出
	 */
	public function __construct( $schema = [] ) {
		if (! $this->isValidSchemasArray($schema)) {
			throw InvalidObjectSchemaException::make($schema);
		}

		$this->schema = $schema;
	}

	/**
	 * 建立 ObjectSchema 實例的靜態方法
	 *
	 * @param Schema[] $schema 物件結構定義陣列
	 * @return static 回傳新的 ObjectSchema 實例
	 */
	public static function make( $schema = [] ) {
		return new static($schema);
	}

	/**
	 * 解析輸入值
	 *
	 * @param mixed $value 要解析的值
	 * @return \stdClass 解析後的物件
	 * @throws InvalidObjectException 當輸入值不是有效的物件時拋出
	 */
	protected function parse_value( $value ) {
		if ($this->isAssociativeArray($value)) {
			$value = $this->arrayToObject($value);
		}

		if (! is_object($value)) {
			throw InvalidObjectException::make($value);
		}

		$parsed_value = new \stdClass();

		foreach ($this->schema as $key => $parser) {
			$parsed_value->$key = $parser->parse($value->$key ?? null);
		}

		return $parsed_value;
	}

	/**
	 * 檢查是否為關聯陣列
	 *
	 * @param mixed $value 要檢查的值
	 * @return bool 是否為關聯陣列
	 */
	private function isAssociativeArray( $value ) {
		if (! is_array($value)) {
			return false;
		}

		$keys         = array_keys($value);
		$numeric_keys = array_filter($keys, 'is_numeric');

		return count($numeric_keys) === 0;
	}

	/**
	 * 將陣列轉換為物件
	 *
	 * @param mixed $value 要轉換的值
	 * @return mixed 轉換後的物件或原始值
	 */
	private function arrayToObject( $value ) {
		if (! is_array($value)) {
			return $value;
		}

		foreach ($value as $key => $item) {
			$value[ $key ] = $this->arrayToObject($item);
		}

		return (object) $value;
	}

	/**
	 * 驗證結構定義陣列是否有效
	 *
	 * @param mixed $schema 要驗證的結構定義
	 * @return bool 結構定義是否有效
	 */
	private function isValidSchemasArray( $schema ) {
		if (! $this->isAssociativeArray($schema)) {
			return false;
		}

		foreach ($schema as $item) {
			if (! ( $item instanceof Schema )) {
				return false;
			}
		}

		return true;
	}
}
