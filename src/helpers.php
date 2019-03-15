<?php

if (!function_exists('format_price')) {

	/**
	 * @param string|float|integer $price
	 * @param string               $currency
	 *
	 * @return string
	 */
	function format_price($price, string $currency = '₽') {
		$result = number_format($price, 0, ',', ' ');

		if ($currency && mb_strlen($currency)) {
			$result .= ' ' . $currency;
		}

		return $result;
	}
}


if (!function_exists('bytes_convert')) {

	/**
	 * @param string $bytes
	 * @param string $format указывает на конкретные единицы измерения ('B', 'KB', 'MB', 'GB', 'TB')
	 *
	 * @return string
	 */
	function bytes_convert($bytes, $format = NULL) {
		$base = 1024;
		$units = [ 'B', 'KB', 'MB', 'GB', 'TB' ];
		$size = 1;

		if (is_null($format)) {
			for ($i = count($units) - 1; $i >= 0; $i--) {
				$size = pow($base, $i);
				$format = $units[ $i ];
				if ($bytes > $size) {
					break;
				}
			}
		} else {
			$format = mb_strtoupper($format, 'UTF-8');
			$exp = array_search($format, $units);
			$size = pow($base, $exp);
		}

		return round($bytes / $size) . ' ' . $format;
	}
}