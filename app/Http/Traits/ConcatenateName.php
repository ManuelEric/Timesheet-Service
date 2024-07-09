<?php

namespace App\Http\Traits;

trait ConcatenateName {
    
    public function concat(string $first_name, ?string $last_name)
    {
        $concat = $first_name;

        if ( $last_name ) {

            $concat = $first_name . ' ' . $last_name;

        }

        return $concat;
    }

}
