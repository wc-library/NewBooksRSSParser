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
class DeweyProcessor extends AbstractClassificationProcessor {
    public function __construct($prefix,$number,$cutter) {
        parent::__construct($number + 0.0);
        $this->data['classification_type'] = "Dewey";
    }

    protected function get_subject($cn) {
        $s = 'All Subjects';

        if (in_array($cn,array(300,301,306)))
            $s .= ", Anthropology";
        if (self::in_range($cn,611,616))
            $s .= ", Applied Health Science";
        if (self::in_range($cn,700,770))
            $s .= ", Art";
        if (self::in_range($cn,200,299))
            $s .= ", Biblical & Theological Studies";
        if (self::in_range($cn,570,599))
            $s .= ", Biology";
        if ( self::in_range($cn,330,349) || self::in_range($cn,657,659) || in_array($cn,array(406,506,650,706,906)))
            $s .= ", Business & Economics";
        if (self::in_range($cn,540,548))
            $s .= ", Chemistry";
        if (self::in_range($cn,230,236) || self::in_range($cn,238,243) || self::in_range($cn,246,249) || self::in_range($cn,262,265) || self::in_range($cn,268,287))
            $s .= ", Christian Formation & Ministry";
        if (self::in_range($cn,70,79))
            $s .= ", Communication: journalism";
        if ($cn==302)
            $s .= ", Communication: interpersonal";
        if (self::in_range($cn,383,384))
            $s .= ", Communication: businesses";
        if (self::in_range($cn,791,792))
            $s .= ", Communication: cinema and theatre arts";
        if ($cn==800 || $cn==808)
            $s .= ", Communication: rhetoric";
        if (self::in_range($cn,3,6))
            $s .= ", Computer Science";
        if (self::in_range($cn,370,378))
            $s .= ", Education";
        if (self::in_range($cn,620,629))
            $s .= ", Engineering";
        if (self::in_range($cn,800,829))
            $s .= ", English";
        if (false)
            $s .= ", Environmental Science";
        if (false)
            $s .= ", Foreign Languages";
        if (self::in_range($cn,550,560))
            $s .= ", Geology";
        if (self::in_range($cn,900,999))
            $s .= ", History";
        if (false)
            $s .= ", HNGR";
        if (false)
            $s .= ", Intercultural Studies";
        if (self::in_range($cn,500,519))
            $s .= ", Mathematics";
        if (self::inrange($cn,700,799))
            $s .= ", Music";
        if (self::in_range($cn,100,129) || self::in_range($cn,140,149) || self::in_range($cn,160,199))
            $s .= ", Philosophy";
        if (self::in_range($cn,520,539))
            $s .= ", Physics";
        if (self::in_range($cn,310,329))
            $s .= ", Politics & International Relations";
        if (self::in_range($cn,150,159) || $cn==616)
            $s .= ", Psychology";
        if (self::in_range($cn,300,309))
            $s .= ", Sociology";
        if ($cn==307)
            $s .= ", Urban Studies";

        return $s;
    }

    private static function in_range($cn, $min,$max) {
        return ($cn>=$min && $cn<=$max);
    }
}
