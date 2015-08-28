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
        parent::__construct($number);
        $this->data['classification_type'] = "LC";
    }

    protected function get_subject($cn) {
        $subject = "All Subjects";

        if ($this->in_range($cn, "GF,GN-GT"))
            $subject .= ", Anthropology";
        if ($this->in_range($cn, 'QM,QP,RA'))
            $subject .= ", Applied Heath Science";
        if ($this->in_range($cn, "N,TR"))
            $subject .= ", Art";
        if ($this->in_range($cn, "BR,BS,BT,BV,BX"))
            $subject .= ", Biblical & Theological Studies";
        if ($this->in_range($cn, 'QH', 'QR'))
            $subject .= ", Biology";
        if ($this->in_range($cn, "HB,HC,HG,HJ,K,HD1-HD1395.5,HD2321-HD9999,HF5001-HF6182"))
            $subject .= ", Business & Economics";
        if ($this->in_range($cn, "QD"))
            $subject .= ", Chemistry";
        if ($this->in_range($cn, "BV"))
            $subject .= ", Christian Formation & Ministry";
        if (false)
            $subject .= ", Communication";
        if ($this->in_range($cn,'QA75.5','QA76.765'))
            $subject .= ", Computer Science";
        if ($this->in_range($cn, "L"))
            $subject .= ", Education";
        if ($this->in_range($cn,'TA','TN'))
            $subject .= ", Engineering";
        if ($this->in_range($cn,'PN,PQ,PR,PS,PT,PZ'))
            $subject .= ", English";
        if ($this->in_range($cn,'GE,QE38,QC882-QC994.9,QH72-QH77,TD169-TD1066'))
            $subject .= ", Environmental Science";
        if ($this->in_range($cn, 'PA,PB'))
            $subject .= ", Foreign Languages";
        if ($this->in_range($cn, "QE"))
            $subject .= ", Geology";
        if ($this->in_range($cn,'D,E,F'))
            $subject .= ", History";
        if ($this->in_range($cn,'HC,HD'))
            $subject .= ", HNGR";
        if ($this->in_range($cn,'BV,BX'))
            $subject .= ", Intercultural Studies";
        if ($this->in_range($cn,'QA'))
            $subject .= ", Mathematics";
        if ($this->in_range($cn,'M,ML,MT'))
            $subject .= ", Music";
        if ($this->in_range($cn,'BA,BB,BC,BD,BH,BJ'))
            $subject .= ", Philosophy";
        if ($this->in_range($cn,'QB-QC'))
            $subject .= ", Physics";
        if ($this->in_range($cn,'J'))
            $subject .= ", Politics & International Relations";
        if ($this->in_range($cn,'BF,QP351-QP495,R726.5-R726.8,RC321-RC571'))
            $subject .= ", Psychology";
        if ($this->in_range($cn,'HM-HX'))
            $subject .= ", Sociology";
        if ($this->in_range($cn,'HT101-HT395'))
            $subject .= ", Urban Studies";

        return strtr($subject,array('  '=>' '));
    }

    protected function cmp_cn($a,$b) {
        $n = strlen($a);
        $m = strlen($b);
        $a = str_split(self::normalize($a));
        $b = str_split(self::normalize($b));

        for ($i=0; $i<$n && $i<$m; $i++) {
            if ($a[$i]!=$b[$i])
                return strcmp($a[$i],$b[$i]);

        }
        return 0;
    }

    private static function normalize($cn,$type='min') {
        $cn_normalized = "ERROR";

        $regex_alpha = "([A-Z]{1,3})";
        $regex_num = "([0-9]{0,4})";
        $regex_extra = "(\.[A-Z0-9][0-9]*)";
        $regex = "/^{$regex_alpha}{$regex_num}?{$regex_extra}?/";

        $matches = array();
        if (preg_match($regex,$cn,$matches)) {
            $alpha = $matches[1];

            if (isset($matches[2])) {
                $alpha = self::normalize_alpha($matches[1],$type);
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
            $cn_normalized = $alpha.$num.$extra;
        }
        return $cn_normalized;
    }

    private static function normalize_alpha($alpha,$type) {
        $ch = ($type=='min')?'A':'Z';
        for ($i=0; $i<3-strlen($alpha); ++$i)
            $alpha .= $ch;
        return $alpha;
    }

    private static function normalize_num($num) {
        $str = '';
        for ($i=0; $i<4-strlen($num); ++$i)
            $str .= '0';

        return $str.$num;
    }

    private static function normalize_extra($extra) {

        $match = array();
        if (preg_match("/[A-Z]/",$extra,$match)) {
            $ch = $match[0];
            $i = 2;
        } else {
            $ch = 'A';
            $i = 1;
        }

        $extra = substr($extra,$i);
        $str = ".$ch";
        for ($i=0; $i<4-strlen($extra); ++$i) {
            $str .= '0';
        }
        return $str.$extra;
    }
}
