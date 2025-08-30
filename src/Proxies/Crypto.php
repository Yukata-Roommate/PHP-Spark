<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\CryptoManager;

/**
 * Crypto Proxy
 *
 * @package Spark\Proxies
 *
 * @method static string base64Encode(string $data)
 * @method static string hexEncode(string $data)
 *
 * @method static string base64Decode(string $data)
 * @method static string hexDecode(string $data)
 *
 * @method static string hash(string $algorithm, string $data)
 * @method static string hashMd5(string $data)
 * @method static string hashSha256(string $data)
 * @method static string hashSha512(string $data)
 * @method static string hashSha3_256(string $data)
 * @method static string hashSha3_512(string $data)
 *
 * @method static string encrypt(string $algorithm, string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Cbc(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Ccm(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Cfb(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Cfb1(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Cfb8(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Ctr(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Gcm(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Ocb(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Ofb(string $key, mixed $data, bool $serialize = false)
 * @method static string encryptAes256Xts(string $key, mixed $data, bool $serialize = false)
 *
 * @method static mixed decrypt(string $algorithm, string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Cbc(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Ccm(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Cfb(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Cfb1(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Cfb8(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Ctr(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Gcm(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Ocb(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Ofb(string $key, string $data, bool $unserialize = false)
 * @method static mixed decryptAes256Xts(string $key, string $data, bool $unserialize = false)
 *
 * @method static string generatePassword(string $characters, int $length)
 * @method static string generatePasswordBy(int $length, bool $useAlphabet = true, bool $useNumeric = true, bool $useSymbol = true, string|null $addCharacters = null)
 * @method static string hashPassword(string $data)
 * @method static string hashPasswordBcrypt(string $data, int $cost = 12)
 * @method static string hashPasswordArgon2i(string $data, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 * @method static string hashPasswordArgon2id(string $data, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 * @method static bool verifyPassword(string $data, string $hash)
 * @method static bool isPasswordNeedRehash(string $hash)
 * @method static bool isPasswordNeedRehashBcrypt(string $hash, int $cost = 12)
 * @method static bool isPasswordNeedRehashArgon2i(string $hash, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 * @method static bool isPasswordNeedRehashArgon2id(string $hash, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 * @method static string rehashPassword(string $hash)
 * @method static string rehashPasswordBcrypt(string $hash, int $cost = 12)
 * @method static string rehashPasswordArgon2i(string $hash, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 * @method static string rehashPasswordArgon2id(string $hash, int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST, int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST, int $threads = PASSWORD_ARGON2_DEFAULT_THREADS)
 *
 * @see \Spark\Proxies\Managers\CryptoManager
 */
class Crypto extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = CryptoManager::class;
}
