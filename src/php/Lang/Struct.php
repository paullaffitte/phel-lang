<?php

namespace Phel\Lang;

use InvalidArgumentException;
use Phel\Printer;

abstract class Struct extends Table {

    /**
     * Returns the list of allowed keywords.
     * 
     * @return Keyword[]
     */
    public abstract function getAllowedKeys(): array;

    protected function validateOffset($offset) {
        if (!in_array($offset, $this->getAllowedKeys())) {
            $printer = new Printer();
            $keyName = $printer->print($offset, false);
            $structname = get_class($this);
            throw new InvalidArgumentException(
                "This key '$keyName' is not allowed for struct $structname"
            );
        }
    }

    public function offsetSet($offset, $value) {
        $this->validateOffset($offset);
        parent::offsetSet($offset, $value);
    }

    public function offsetExists($offset) {
        $this->validateOffset($offset);
        return parent::offsetExists($offset);
    }

    public function offsetUnset($offset) {
        $this->validateOffset($offset);
        parent::offsetUnset($offset);
    }

    /**
     * @return mixed|null
     */
    public function offsetGet($offset) {
        $this->validateOffset($offset);
        return parent::offsetGet($offset);
    }
}