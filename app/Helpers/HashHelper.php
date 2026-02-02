<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class HashHelper
{
    /**
     * Check if the hashed ID matches the real ID in any given model or table.
     *
     * @param string $hashedId The hashed ID to verify
     * @param string $model The model name (optional, can be a fully qualified class name)
     * @param string $table The table name (if no model is provided)
     * @param string $column The column name for ID (defaults to 'id')
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function verifyHashedId($hashedId, $model = null, $table = null, $column = 'id')
    {
        // Use the cache key based on hashed ID
        $cacheKey = 'hash_check_' . $hashedId;

        // Check if the result is cached
        $cachedResult = cache()->get($cacheKey);

        if ($cachedResult) {
            return $cachedResult;
        }

        // If no model is provided, use the table name
        if (!$model && $table) {
            // Query directly using DB if no model is provided
            // echo $hashedId;die;
            $result = DB::table($table)
                // ->whereRaw("SHA2(CONCAT($column, ?), 256) = ?", [config('app.key'), $hashedId])
                ->whereRaw("SHA2(CONCAT(?, $column), 256) = ?", [config('app.key'), $hashedId])
                // ->whereRaw("SHA2(CONCAT($column, ?), 256) = ?", [config('app.key'), $hashedId])
                ->first();
        } elseif ($model) {
            // If model is provided, query using the model
            $result = $model::whereRaw("SHA2(CONCAT($column, ?), 256) = ?", [config('app.key'), $hashedId])
                ->first();
        } else {
            // If neither model nor table is provided, return null
            return null;
        }

        // Cache the result if not found in cache
        cache()->put($cacheKey, $result, now()->addMinutes(10)); // Cache for 10 minutes

        return $result;
    }
}
