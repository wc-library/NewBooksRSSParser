<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeweyProcessor
 *
 * @author bgarcia
 */
class DeweyProcessor implements ClassificationProcessorInterface {
    public function __construct($prefix,$number,$cutter) {
        $this->data = array();
        $this->data['classification_type'] = "Dewey";

        $cn = $number + 0.0;
        $this->data['subject'] = self::get_subject($cn);
    }

    public function data() {
        return $this->data;
    }

    private static function get_subject($cn) {
        $s = '';

        if (in_array($cn,array(300,301,306)))
            $s .= ", Anthropology";
        if (self::in_range($cn,611,616))
            $s .= ", Applied_Health_Science";
        if (self::in_range($cn,700,770))
            $s .= ", Art";
        if (self::in_range($cn,200,299))
            $s .= ", Biblical_and_Theological_Studies";
        if (self::in_range($cn,570,599))
            $s .= ", Biology";
        if ( self::in_range($cn,330,349) || self::in_range($cn,657,659) || in_array($cn,array(406,506,650,706,906)))
            $s .= ", Business_&_Economics";
        if (self::in_range($cn,540,548))
            $s .= ", Chemistry";
        if (self::in_range($cn,230,236) || self::in_range($cn,238,243) || self::in_range($cn,246,249) || self::in_range($cn,262,265) || self::in_range($cn,268,287))
            $s .= ", Christian_Formation_and_Ministry";
        if (self::in_range($cn,70,79))
            $s .= ", Communication:_journalism";
        if ($cn==302)
            $s .= ", Communication:_interpersonal";
        if (self::in_range($cn,383,384))
            $s .= ", Communication:_businesses";
        if (self::in_range($cn,791,792))
            $s .= ", Communication:_cinema_and_theatre_arts";
        if ($cn==800 || $cn==808)
            $s .= ", Communication:_rhetoric";
        if (self::in_range($cn,3,6))
            $s .= ", Computer_Science";
        if (self::in_range($cn,370,378))
            $s .= ", Education";
        if (self::in_range($cn,620,629))
            $s .= ", Engineering";
        if (self::in_range($cn,800,829))
            $s .= ", English";
        if (false)
            $s .= ", Environmental_Science";
        if (false)
            $s .= ", Foreign_Languages";
        if (self::in_range($cn,550,560))
            $s .= ", Geology";
        if (self::in_range($cn,900,999))
            $s .= ", History";
        if (false)
            $s .= ", HNGR";
        if (false)
            $s .= ", Intercultural_Studies";
        if (self::in_range($cn,500,519))
            $s .= ", Mathematics";
        if ($cn==780)
            $s .= ", Music";
        if (self::in_range($cn,100,129) || self::in_range($cn,140,149) || self::in_range($cn,160,199))
            $s .= ", Philosophy";
        if (self::in_range($cn,520,539))
            $s .= ", Physics";
        if (self::in_range($cn,310,329))
            $s .= ", Politics_and_International_Relations";
        if (self::in_range($cn,150,159) || $cn==616)
            $s .= ", Psychology";
        if (self::in_range($cn,300,309))
            $s .= ", Sociology";
        if ($cn==307)
            $s .= ", Urban_Studies";

        if ($s==='') {
            $s = "Unknown";
        } else {
            $s = substr($s,2);
        }
        return $s;
    }

    private static function in_range($cn, $min,$max) {
        return ($cn>=$min && $cn<=$max);
    }
}
