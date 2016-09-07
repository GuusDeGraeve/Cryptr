<?php 

	use GuusDeGraeve\Cryptr\Cryptr;

	class CryptrTest extends PHPUnit_Framework_TestCase
	{
		const 	TEST_PASSPHRASE = 'P4$$phR4$3',
				TEST_DATA		= 'Test data';

		public function testEncryptDecrypt()
		{
			$data = self::TEST_DATA;

			list($privateKey, $publicKey) = Cryptr::createKeyPair(self::TEST_PASSPHRASE);

			$crypted = Cryptr::encrypt($publicKey, $data);

			$decrypted = Cryptr::decrypt($privateKey, $crypted, self::TEST_PASSPHRASE);

			$this->assertEquals($decrypted, $data);
		}
	}