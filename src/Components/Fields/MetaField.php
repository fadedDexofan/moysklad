<?php

namespace MoySklad\Components\Fields;

use MoySklad\Exceptions\UnknownEntityException;
use MoySklad\Providers\EntityProvider;

class MetaField extends AbstractFieldAccessor{

    private $ep;

    public function __construct($fields)
    {
        if ( $fields instanceof static ) {
            parent::__construct($fields->getInternal());
        } else {
            parent::__construct($fields);
        }
        $this->ep = EntityProvider::instance();
    }

    public function getClass(){
        if ( empty($this->type) ) return null;
        if ( !isset($this->ep->entityNames[$this->type]) ){
            throw new UnknownEntityException($this->type);
        }
        return $this->ep->entityNames[$this->type];
    }

    public static function getClassFromPlainMeta($metaField){
        $meta = new static($metaField);
        return $meta->getClass();
    }
}