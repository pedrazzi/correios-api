<?php

declare(strict_types=1);

namespace Pedrazzi\Correios;

/**
 * Rastro
 * 
 * Faz rastreamento de um objeto dos correios 
 *
 * @author Fábio Pedrazzi <pedrazzi@hotmail.com>
 * @date 06/10/2022
 * 
 */
class Rastro
{
	const URL_BASE = "https://proxyapp.correios.com.br/v1/sro-rastro/";

	/**
	 * Get
	 *
	 * Faz rastreamento de um objeto dos correios 
	 * 
	 * @param string $id "QM172482092BR" or "NL084421420BR"
	 * @author Fábio Pedrazzi <pedrazzi@hotmail.com>
	 * @date 07/10/2022
	 */
	public function get(string $id = ''): object|array
	{

		try {
			$url = self::URL_BASE . $id;
			$result = json_decode(file_get_contents($url));
			$objetos = [];

			foreach ($result->objetos as $o => $obj) {
				$eventos = [];

				foreach ($obj->eventos as $e => $ev) {
					$eventos[$e] = $ev;
					$eventos[$e]->urlIcone = "https://proxyapp.correios.com.br$ev->urlIcone";
				}

				$objetos[$o] = $obj;
				$objetos[$o]->eventos = $eventos;
			}

			return ['objetos' => $objetos];
		} catch (\Exception $th) {
			return $th;
		}
	}
}
