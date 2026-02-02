<?php

namespace App\Traits;

trait HasDeterministicHash
{
    /**
     * Generate deterministic hash using HMAC (e.g., for model ID).
     */
    public function generateHash($value)
    {
        return hash_hmac('sha256', $value, config('app.key'));
    }

    /**
     * Automatically set the hash field (e.g., id_hash) when saving.
     */
    public static function bootHasDeterministicHash()
    {
        static::saving(function ($model) {
            if (!empty($model->id)) {
                $model->id_hash = $model->generateHash($model->id);
            }
        });
    }

    /**
     * Verify a given value matches the model's stored hash.
     */
    public function verifyHash($value, $hashField = 'id_hash')
    {
        return $this->$hashField === $this->generateHash($value);
    }
}
