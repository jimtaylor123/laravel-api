<?php

namespace App\Traits;

Trait HasRelationships {

    public function relationships() {
        return config("jsonapi.resources.{$this->type()}.relationships");
    }
    
}