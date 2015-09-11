<?php

namespace cn\processor;

class Generic extends AbstractProcessor {
    public function __construct($segments) {
        $txt = "";
        foreach($segments as $seg) {
            if ($txt==='')
                $txt = "{ $seg";
            else
                $txt .= ", $seg";
        }
        $txt .= "}";
        $this->data = array('classification_type'=>"UNKNOWN",
            'UNKNOWN'=>$txt);

    }

    protected function getSubject($cn) {
        return "";
    }

    protected function matches($cn, $range) {
        return FALSE;
    }
}
