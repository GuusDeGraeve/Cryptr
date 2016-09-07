<?php

	namespace GuusDeGraeve\Cryptr;

	class Cryptr
	{
		const 	DEFAULT_DIGEST_ALG				= 'sha512',
				DEFAULT_PRIVATE_KEY_BITS		= 4096,
				DEFAULT_PRIVATE_KEY_TYPE		= OPENSSL_KEYTYPE_RSA;

		public static function createKeyPair($passphrase = null)
		{
			// Create private & public key pair
			$pair = openssl_pkey_new(array(
				'digest_alg'		=> self::DEFAULT_DIGEST_ALG,
				'private_key_bits'	=> self::DEFAULT_PRIVATE_KEY_BITS,
				'private_key_type'	=> self::DEFAULT_PRIVATE_KEY_TYPE
			));

			// Extract private key with passphrase
			openssl_pkey_export($pair, $privateKey, $passphrase);

			// Extract public key from key pair details
			$pairDetails = openssl_pkey_get_details($pair);
			$publicKey = $pairDetails['key'];

			return array($privateKey, $publicKey);
		}

		public static function encrypt($publicKey, $data)
		{
			openssl_public_encrypt($data, $crypted, $publicKey);

			return $crypted;
		}

		public static function decrypt($privateKey, $crypted, $passphrase = null)
		{
			$decryptedKey = openssl_get_privatekey($privateKey, $passphrase);

			openssl_private_decrypt($crypted, $data, $decryptedKey);

			return $data;
		}
	}

?>