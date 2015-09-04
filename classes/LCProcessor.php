<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LCProcessor
 *
 * @author bgarcia
 */
class LCProcessor extends AbstractClassificationProcessor {
    public function __construct($prefix,$number,$cutter) {
        parent::__construct('LC',$prefix,$number,$cutter);
    }

    protected function get_subject($cn) {
        $subjects = array();

        if ($this->matches($cn, "GF,GN-GT"))
            $subjects[] = "Anthropology";

        if ($this->matches($cn, 'QM,QP,RA'))
            $subjects[] = "Applied Heath Science";

        if ($this->matches($cn, "N,TR"))
            $subjects[] = "Art";

        if ($this->matches($cn, "BL-BV1999,BV4000-BV4399,BX"))
            $subjects[] = "Biblical & Theological Studies";

        if ($this->matches($cn, 'QH', 'QR'))
            $subjects[] = "Biology";

        if ($this->matches($cn, "HB,HC,HG,HJ,K,HD1-HD1395.5,HD2321-HD9999,HF5001-HF6182"))
            $subjects[] = "Business & Economics";

        if ($this->matches($cn, "QD"))
            $subjects[] = "Chemistry";

        if ($this->matches($cn, "BV4400-BV5099"))
            $subjects[] = "Christian Formation & Ministry";

        if (false)
            $subjects[] = "Communication";

        if ($this->matches($cn,'QA75.5','QA76.765'))
            $subjects[] = "Computer Science";

        if ($this->matches($cn, "L"))
            $subjects[] = "Education";

        if ($this->matches($cn,'TA','TN'))
            $subjects[] = "Engineering";

        if ($this->matches($cn,'PN,PQ,PR,PS,PT,PZ'))
            $subjects[] = "English";

        if ($this->matches($cn,'GE,QE38,QC882-QC994.9,QH72-QH77,TD169-TD1066'))
            $subjects[] = "Environmental Science";

        if ($this->matches($cn, 'PA,PB'))
            $subjects[] = "Foreign Languages";

        if ($this->matches($cn, "QE"))
            $subjects[] = "Geology";

        if ($this->matches($cn,'D,E,F'))
            $subjects[] = "History";

        if ($this->matches($cn,'HC,HD'))
            $subjects[] = "HNGR";

        if ($this->matches($cn,'BV'))
            $subjects[] = "Intercultural Studies";

        if ($this->matches($cn,'QA'))
            $subjects[] = "Mathematics";

        if ($this->matches($cn,'M,ML,MT'))
            $subjects[] = "Music";

        if ($this->matches($cn,'BA,BB,BC,BD,BH,BJ'))
            $subjects[] = "Philosophy";

        if ($this->matches($cn,'QB-QC'))
            $subjects[] = "Physics";

        if ($this->matches($cn,'J,BV2000-BV3999'))
            $subjects[] = "Politics & International Relations";

        if ($this->matches($cn,'BF,QP351-QP495,R726.5-R726.8,RC321-RC571'))
            $subjects[] = "Psychology";

        if ($this->matches($cn,'HM-HX'))
            $subjects[] = "Sociology";

        if ($this->matches($cn,'HT101-HT395'))
            $subjects[] = "Urban Studies";

        return implode(', ',$subjects);
    }

    private static function cmp_cn($cn, $class) {
        $n = count($class);

        for ($i=0; $i<$n; $i++) {
            if ($cn[$i] !== $class[$i] && $class[$i]!=='*') {
                return ( ord($cn[$i]) < ord($class[$i] ))?-1:1;
            }
        }

        return 0;
    }

    protected static function in_class($cn, $class) {
        return self::cmp_cn($cn, $class)===0;
    }

    protected static function before_class($cn,$class) {
        return self::cmp_cn($cn, $class)===-1;
    }

    protected static function after_class($cn,$class) {
        return self::cmp_cn($cn, $class)===1;
    }

    protected function matches($cn, $rangeList) {
        if ( ($cn=self::normalize($cn)) === FALSE)
            return FALSE;
        foreach ( Util::parse_range($rangeList) as $r ) {
            if (count($r)===1) {
                if ( ($class=self::normalize($r[0])) === FALSE)
                    return FALSE;
                return self::in_class($cn,$class);
            } else {
                if ( ($min=self::normalize($r[0])) === FALSE
                     || ($max=self::normalize($r[1])) === FALSE) {
                    return FALSE;
                }

                if (self::in_class($cn, $min)
                || self::in_class($cn, $max)
                ||(self::after_class($cn,$min) && self::before_class($cn,$max))
                ) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    private static function normalize($cn) {

        $regex_alpha = "([A-Z]{1,3})";
        $regex_num = "([0-9]{0,4})";
        $regex_extra = "([ ]?\.[A-Z0-9][0-9]*)";
        $regex = "/^{$regex_alpha}{$regex_num}?{$regex_extra}?/";

        $matches = array();
        if (preg_match($regex,$cn,$matches)) {
            $alpha = $matches[1];

            if (isset($matches[2])) {
                $alpha = self::normalize_alpha($matches[1]);
                $num = self::normalize_num($matches[2]);
                if (isset($matches[3])) {
                    $extra = self::normalize_extra($matches[3]);
                } else {
                    $extra = '';
                }
            } else {
                $num = '';
                $extra = '';
            }
            return str_split($alpha.$num.$extra);
        }

        return FALSE;
    }

    private static function normalize_alpha($alpha) {
        for ($i=0; $i<3-strlen($alpha); ++$i)
            $alpha .= '*';
        return $alpha;
    }

    private static function normalize_num($num) {
        $n = 4-strlen($num);
        for ($i=0; $i<$n; ++$i)
            $num .= '*';
        return $num;
    }

    private static function normalize_extra($extra) {

        $match = array();
        if (preg_match("/[A-Z]/",$extra,$match)) {
            $ch = $match[0];
            $i = 2;
        } else {
            $ch = '*';
            $i = 1;
        }

        $extra = substr($extra,$i);
        $n = 4-strlen($extra);

        for ($i=0; $i<$n; ++$i) {
            $extra .= '*';
        }
        return "$ch$extra";
    }
}
