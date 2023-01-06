<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (\in_array($key, $this->encryptable, true)) {
            try {
                $decryptedValue = Crypt::decrypt($value);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $decryptException) {
                $decryptedValue = 'The value could not be decrypted.';
            }
            return $decryptedValue;
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (\in_array($key, $this->encryptable, true)) {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
}
