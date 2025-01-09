<?php
/**
 * Zod 驗證庫
 *
 * 這是一個用於數據驗證的 PHP 庫，靈感來自於 JavaScript 的 Zod 庫。
 * 提供了物件、字串、數字等數據類型的驗證功能。
 *
 * @package J7\Zod
 */

namespace J7\Zod;

use J7\Zod\Schemas\NumberSchema;
use J7\Zod\Schemas\ObjectSchema;
use J7\Zod\Schemas\StringSchema;

/**
 * Zod 主類別
 *
 * 提供了創建各種數據驗證模式的靜態方法。
 */
class Zod {

	/**
	 * 創建物件驗證模式
	 *
	 * @param array $schema 物件的結構定義
	 * @return ObjectSchema 物件驗證模式實例
	 */
	public static function object( $schema = [] ) {
		return ObjectSchema::make($schema);
	}

	/**
	 * 創建字串驗證模式
	 *
	 * @return StringSchema 字串驗證模式實例
	 */
	public static function string() {
		return StringSchema::make();
	}

	/**
	 * 創建數字驗證模式
	 *
	 * @return NumberSchema 數字驗證模式實例
	 */
	public static function number() {
		return NumberSchema::make();
	}
}
