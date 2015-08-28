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

        if (self::is_equal($cn, "GF") || self::in_range($cn, 'GN', 'GT'))
            $subject .= ", Anthropology";
        if (self::is_equal($cn, 'QM') || self::is_equal($cn, "QP") || self::is_equal($cn, "RA"))
            $subject .= ", Applied Heath Science";
        if (self::is_equal($cn, "N") || self::is_equal($cn, "TR"))
            $subject .= ", Art";
        if (self::is_equal($cn, "BR") || self::is_equal($cn, "BS") || self::is_equal($cn, "BT") || self::is_equal($cn, "BV") || self::is_equal($cn, "BX"))
            $subject .= ", Biblical & Theological Studies";
        if (self::in_range($cn, 'QH', 'QR'))
            $subject .= ", Biology";
        if (self::is_equal($cn, "HB") || self::is_equal($cn, "HC") || self::is_equal($cn, "HG") || self::is_equal($cn, "HJ") || self::is_equal($cn, "K") || self::in_range($cn,'HD1','HD1395.5') || self::in_range($cn,'HD2321','HD9999') || self::in_range($cn,'HF5001','HF6182'))
            $subject .= ", Business & Economics";
        if (self::is_equal($cn, "QD"))
            $subject .= ", Chemistry";
        if (self::is_equal($cn, "BV"))
            $subject .= ", Christian Formation & Ministry";
        if (false)
            $subject .= ", Communication";
        if (self::in_range($cn,'QA75.5','QA76.765'))
            $subject .= ", Computer Science";
        if (self::is_equal($cn, "L"))
            $subject .= ", Education";
        if (self::in_range($cn,'TA','TN'))
            $subject .= ", Engineering";
        if (self::is_equal($cn,'PN') || self::is_equal($cn, "PQ") || self::is_equal($cn,'PR') || self::is_equal($cn, "PS") || self::is_equal($cn, "PT")|| self::is_equal($cn, "PZ"))
            $subject .= ", English";
        if (self::is_equal($cn,'GE') || self::is_equal($cn, "QE38") || self::in_range($cn,'QC882','QC994.9') || self::in_range($cn,'QH72','QH77') || self::in_range($cn,'TD169','TD1066'))
            $subject .= ", Environmental Science";
        if (self::is_equal($cn, 'PA') || self::is_equal($cn, 'PB'))
            $subject .= ", Foreign Languages";
        if (self::is_equal($cn, "QE"))
            $subject .= ", Geology";
        if (self::is_equal($cn,'D') || self::is_equal($cn, "E") || self::is_equal($cn, "F"))
            $subject .= ", History";
        if (self::is_equal($cn,'HC') || self::is_equal($cn, "HD"))
            $subject .= ", HNGR";
        if (self::is_equal($cn,'BV') || self::is_equal($cn, "BX"))
            $subject .= ", Intercultural Studies";
        if (self::is_equal($cn,'QA'))
            $subject .= ", Mathematics";
        if (self::is_equal($cn,'M') || self::is_equal($cn, "ML") || self::is_equal($cn, "MT"))
            $subject .= ", Music";
        if (self::is_equal($cn,'B') || self::is_equal($cn, "BC") || self::is_equal($cn,'BD') || self::is_equal($cn, "BH") || self::is_equal($cn, "BJ"))
            $subject .= ", Philosophy";
        if (self::in_range($cn,'QB','QC'))
            $subject .= ", Physics";
        if (self::is_equal($cn,'J'))
            $subject .= ", Politics & International Relations";
        if (self::is_equal($cn,'BF') || self::in_range($cn,'QP351','QP495') || self::in_range($cn,'R726.5','R726.8') || self::in_range($cn,'RC321','RC571'))
            $subject .= ", Psychology";
        if (self::in_range($cn,'HM','HX'))
            $subject .= ", Sociology";
        if (self::in_range($cn,'HT101','HT395'))
            $subject .= ", Urban Studies";

        return strtr($subject,array('  '=>' '));
    }

    private static function is_equal($cn,$target) {
        return (self::cmp_cn($cn,$target)==0);
    }

    private static function in_range($cn,$min,$max) {
        return (self::cmp_cn($min,$cn)<=0 && self::cmp_cn($cn,$max)<=0);
    }

    private static function cmp_cn($a,$b) {
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
