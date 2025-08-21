<?php

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

/**
 * Crypto Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class CryptoManager extends ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Encode
     *----------------------------------------*/

    /**
     * encode string to base64
     *
     * @param string $data
     * @return string
     */
    public function base64Encode(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * encode string to hex
     *
     * @param string $data
     * @return string
     */
    public function hexEncode(string $data): string
    {
        return bin2hex($data);
    }

    /*----------------------------------------*
     * Decode
     *----------------------------------------*/

    /**
     * decode base64 string
     *
     * @param string $data
     * @return string
     */
    public function base64Decode(string $data): string
    {
        return base64_decode($data);
    }

    /**
     * decode hex string
     *
     * @param string $data
     * @return string
     */
    public function hexDecode(string $data): string
    {
        return hex2bin($data);
    }

    /*----------------------------------------*
     * Hash
     *----------------------------------------*/

    /**
     * hash string
     *
     * @param string $algorithm
     * @param string $data
     * @return string
     */
    public function hash(string $algorithm, string $data): string
    {
        return hash($algorithm, $data);
    }

    /**
     * hash string with md5
     *
     * @param string $data
     * @return string
     */
    public function hashMd5(string $data): string
    {
        return $this->hash("md5", $data);
    }

    /**
     * hash string with sha256
     *
     * @param string $data
     * @return string
     */
    public function hashSha256(string $data): string
    {
        return $this->hash("sha256", $data);
    }

    /**
     * hash string with sha512
     *
     * @param string $data
     * @return string
     */
    public function hashSha512(string $data): string
    {
        return $this->hash("sha512", $data);
    }

    /**
     * hash string with sha3-256
     *
     * @param string $data
     * @return string
     */
    public function hashSha3_256(string $data): string
    {
        return $this->hash("sha3-256", $data);
    }

    /**
     * hash string with sha3-512
     *
     * @param string $data
     * @return string
     */
    public function hashSha3_512(string $data): string
    {
        return $this->hash("sha3-512", $data);
    }

    /*----------------------------------------*
     * Encrypt
     *----------------------------------------*/

    /**
     * encrypt with algorithm
     *
     * @param string $algorithm
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encrypt(string $algorithm, string $key, mixed $data, bool $serialize = false): string
    {
        $data = $serialize ? serialize($data) : $data;

        $ivSize = openssl_cipher_iv_length($algorithm);

        $iv = openssl_random_pseudo_bytes($ivSize);

        $encrypted = openssl_encrypt($data, $algorithm, $key, OPENSSL_RAW_DATA, $iv);

        return $this->base64Encode($iv . $encrypted);
    }

    /**
     * encrypt with aes-256-cbc
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Cbc(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-cbc", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-ccm
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Ccm(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-ccm", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-cfb
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Cfb(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-cfb", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-cfb1
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Cfb1(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-cfb1", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-cfb8
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Cfb8(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-cfb8", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-ctr
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Ctr(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-ctr", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-gcm
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Gcm(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-gcm", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-ocb
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Ocb(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-ocb", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-ofb
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Ofb(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-ofb", $key, $data, $serialize);
    }

    /**
     * encrypt with aes-256-xts
     *
     * @param string $key
     * @param mixed $data
     * @param bool $serialize
     * @return string
     */
    public function encryptAes256Xts(string $key, mixed $data, bool $serialize = false): string
    {
        return $this->encrypt("aes-256-xts", $key, $data, $serialize);
    }

    /*----------------------------------------*
     * Decrypt
     *----------------------------------------*/

    /**
     * decrypt with algorithm
     *
     * @param string $algorithm
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decrypt(string $algorithm, string $key, string $data, bool $unserialize = false): mixed
    {
        $data = $this->base64Decode($data);

        $ivSize = openssl_cipher_iv_length($algorithm);

        $iv = substr($data, 0, $ivSize);

        $encrypted = substr($data, $ivSize);

        $decrypted = openssl_decrypt($encrypted, $algorithm, $key, OPENSSL_RAW_DATA, $iv);

        return $unserialize ? unserialize($decrypted) : $decrypted;
    }

    /**
     * decrypt with aes-256-cbc
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Cbc(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-cbc", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-ccm
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Ccm(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-ccm", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-cfb
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Cfb(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-cfb", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-cfb1
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Cfb1(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-cfb1", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-cfb8
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Cfb8(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-cfb8", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-ctr
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Ctr(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-ctr", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-gcm
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Gcm(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-gcm", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-ocb
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Ocb(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-ocb", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-ofb
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Ofb(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-ofb", $key, $data, $unserialize);
    }

    /**
     * decrypt with aes-256-xts
     *
     * @param string $key
     * @param string $data
     * @param bool $unserialize
     * @return mixed
     */
    public function decryptAes256Xts(string $key, string $data, bool $unserialize = false): mixed
    {
        return $this->decrypt("aes-256-xts", $key, $data, $unserialize);
    }

    /*----------------------------------------*
     * Password
     *----------------------------------------*/

    /**
     * generate password
     *
     * @param string $characters
     * @param int $length
     * @return string
     */
    public function generatePassword(string $characters, int $length): string
    {
        return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
    }

    /**
     * generate password by
     *
     * @param int $length
     * @param bool $useAlphabet
     * @param bool $useNumeric
     * @param bool $useSymbol
     * @param string|null $addCharacters
     * @return string
     */
    public function generatePasswordBy(
        int $length,
        bool $useAlphabet = true,
        bool $useNumeric = true,
        bool $useSymbol = true,
        string|null $addCharacters = null,
    ): string {
        $characters = $addCharacters ?? "";

        if ($useAlphabet) $characters .= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($useNumeric)  $characters .= "0123456789";
        if ($useSymbol)   $characters .= "!@#$%^&*()-_=+[]{};:,.<>?/~";

        return $this->generatePassword($characters, $length);
    }

    /**
     * make hash password
     *
     * @param string $data
     * @return string
     */
    public function hashPassword(string $data): string
    {
        return password_hash($data, PASSWORD_DEFAULT);
    }

    /**
     * make hash password with bcrypt algorithm
     *
     * @param string $data
     * @param int $cost
     * @return string
     */
    public function hashPasswordBcrypt(string $data, int $cost = 12): string
    {
        return password_hash($data, PASSWORD_BCRYPT, [
            "cost" => $cost
        ]);
    }

    /**
     * make hash password with argon2i algorithm
     *
     * @param string $data
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return string
     */
    public function hashPasswordArgon2i(
        string $data,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): string {
        return password_hash($data, PASSWORD_ARGON2I, [
            "memory_cost" => $memoryCost,
            "time_cost"   => $timeCost,
            "threads"     => $threads
        ]);
    }

    /**
     * make hash password with argon2id algorithm
     *
     * @param string $data
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return string
     */
    public function hashPasswordArgon2id(
        string $data,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): string {
        return password_hash($data, PASSWORD_ARGON2ID, [
            "memory_cost" => $memoryCost,
            "time_cost"   => $timeCost,
            "threads"     => $threads
        ]);
    }

    /**
     * verify password
     *
     * @param string $data
     * @param string $hash
     * @return bool
     */
    public function verifyPassword(string $data, string $hash): bool
    {
        return password_verify($data, $hash);
    }

    /**
     * check password need rehash
     *
     * @param string $hash
     * @return bool
     */
    public function isPasswordNeedRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_DEFAULT);
    }

    /**
     * check password need rehash with bcrypt algorithm
     *
     * @param string $hash
     * @param int $cost
     * @return bool
     */
    public function isPasswordNeedRehashBcrypt(string $hash, int $cost = 12): bool
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, [
            "cost" => $cost
        ]);
    }

    /**
     * check password need rehash with argon2i algorithm
     *
     * @param string $hash
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return bool
     */
    public function isPasswordNeedRehashArgon2i(
        string $hash,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): bool {
        return password_needs_rehash($hash, PASSWORD_ARGON2I, [
            "memory_cost" => $memoryCost,
            "time_cost"   => $timeCost,
            "threads"     => $threads
        ]);
    }

    /**
     * check password need rehash with argon2id algorithm
     *
     * @param string $hash
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return bool
     */
    public function isPasswordNeedRehashArgon2id(
        string $hash,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): bool {
        return password_needs_rehash($hash, PASSWORD_ARGON2ID, [
            "memory_cost" => $memoryCost,
            "time_cost"   => $timeCost,
            "threads"     => $threads
        ]);
    }

    /**
     * rehash password if needed
     *
     * @param string $hash
     * @return string
     */
    public function rehashPassword(string $hash): string
    {
        return $this->isPasswordNeedRehash($hash)
            ? $this->hashPassword($hash)
            : $hash;
    }

    /**
     * rehash password if needed with bcrypt algorithm
     *
     * @param string $hash
     * @param int $cost
     * @return string
     */
    public function rehashPasswordBcrypt(string $hash, int $cost = 12): string
    {
        return $this->isPasswordNeedRehashBcrypt($hash, $cost)
            ? $this->hashPasswordBcrypt($hash, $cost)
            : $hash;
    }

    /**
     * rehash password if needed with argon2i algorithm
     *
     * @param string $hash
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return string
     */
    public function rehashPasswordArgon2i(
        string $hash,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): string {
        return $this->isPasswordNeedRehashArgon2i($hash, $memoryCost, $timeCost, $threads)
            ? $this->hashPasswordArgon2i($hash, $memoryCost, $timeCost, $threads)
            : $hash;
    }

    /**
     * rehash password if needed with argon2id algorithm
     *
     * @param string $hash
     * @param int $memoryCost
     * @param int $timeCost
     * @param int $threads
     * @return string
     */
    public function rehashPasswordArgon2id(
        string $hash,
        int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        int $timeCost = PASSWORD_ARGON2_DEFAULT_TIME_COST,
        int $threads = PASSWORD_ARGON2_DEFAULT_THREADS,
    ): string {
        return $this->isPasswordNeedRehashArgon2id($hash, $memoryCost, $timeCost, $threads)
            ? $this->hashPasswordArgon2id($hash, $memoryCost, $timeCost, $threads)
            : $hash;
    }
}
