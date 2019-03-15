<?php

if (!function_exists('format_price')) {

	/**
	 * @param string|float|integer $price
	 * @param string               $currency
	 *
	 * @return string
	 */
	function format_price($price, int $decimals = 2, string $currency = '₽') {
		$result = number_format($price, $decimals, ',', ' ');

		if ($currency && mb_strlen($currency)) {
			$result .= ' ' . $currency;
		}

		return $result;
	}
}


if (!function_exists('get_size_from_bytes')) {

	/**
	 * @param string|integer $bytes
	 * @param string         $format указывает на конкретные единицы измерения ('B', 'KB', 'MB', 'GB', 'TB')
	 *
	 * @return string
	 */
	function get_size_from_bytes($bytes, string $format = NULL) {
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


if (!file_exists('get_size_in_bytes')) {

	/**
	 * @param string $size
	 *
	 * @return float|int|string
	 */
	function get_size_in_bytes(string $size) {
		$size = trim($size);
		$last = strtolower($size[ strlen($size) - 1 ]);
		$size = floatval($size);

		switch ($last) {
			case 'g':
				$size *= 1024;
			case 'm':
				$size *= 1024;
			case 'k':
				$size *= 1024;
		}

		return $size;
	}
}


if (!function_exists('str_random')) {

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	function str_random(int $length = 7) {
		$string = time() . '-' . rand(0, 999999999999);
		$name = md5($string);

		return mb_substr($name, 0, $length);
	}
}


if (!function_exists('str_random2')) {

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	function str_random2(int $length = 7) {
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$chars_length = strlen($chars);
		for ($i = 0; $i < $length; $i++) {
			$rnd = rand(0, $chars_length);
			$result .= substr($chars, $rnd, 1);
		}

		return $result;
	}
}


if (!function_exists('get_max_filesize')) {

	/**
	 * @return float|int|null|string
	 */
	function get_max_filesize() {
		$sizes = [
			ini_get('post_max_size'),
			ini_get('upload_max_filesize'),
			ini_get('memory_limit'),
		];
		$max_size = NULL;

		foreach ($sizes as $size) {
			$size = get_size_in_bytes($size);

			if (is_null($max_size) || $size < $max_size) {
				$max_size = $size;
			}
		}

		return $max_size;
	}
}