<?php
namespace APICARDS;
/**
 * class of Card
 *
 * @author gmedyacine
 */
class Card{
    
    protected $category;
    
    protected $value;
    
    public function __construct($category,$value) {
        $this->category=$category;
        $this->value=$value;
    }
    
    function getCategory() {
        return $this->category;
    }

    function getValue() {
        return $this->value;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setValue($value) {
        $this->value = $value;
    }


}
