<?php

namespace App\Traits;

use Illuminate\Support\Str;

Trait HasType {

    public function type($name=null): string {
        return Str::lower(Str::plural($name?? class_basename($this)));
    }
    
}