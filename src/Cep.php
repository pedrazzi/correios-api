<?php

declare(strict_types=1);

namespace Pedrazzi\Correios;

/**
 * CEP
 * 
 * Localiza ceps e endereços 
 *
 * @author Fábio Pedrazzi <pedrazzi@hotmail.com>
 * @date 06/10/2022
 * 
 */
class Cep
{
	const URL_BASE = "https://buscacepinter.correios.com.br/app/endereco/carrega-cep-endereco.php";

	/**
	 * Get
	 *
	 * Localiza ceps e endereços
	 * 
	 * @param string $endereco CEP ou um Endereço
	 * @author Fábio Pedrazzi <pedrazzi@hotmail.com>
	 * @date 07/10/2022
	 */
	public function get(string $endereco = ''): object|array
	{

		try {
			$opts = [
				'http' =>
				[
					'method'  => 'POST',
					'header'  => 'Content-Type: application/x-www-form-urlencoded',
					'content' => http_build_query(
						[
							'endereco' => $endereco,
							'tipoCEP' => 'ALL'
						]
					)
				]
			];

			$context  = stream_context_create($opts);

			$result = file_get_contents(self::URL_BASE, false, $context);

			return json_decode($result);
		} catch (\Exception $th) {
			return (array) $th;
		}
	}
}
