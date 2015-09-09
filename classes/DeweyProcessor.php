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
        parent::__construct("Dewey",$prefix,$number + 0.0,$cutter);
    }

    protected function get_subject($cn) {
        $subjects = array();

        if ($this->matches($cn,"300,301,306"))
            $subjects[] = "Anthropology";

        if ($this->matches($cn,"611-616"))
            $subjects[] = "Applied Health Science";

        if ($this->matches($cn,"700-770"))
            $subjects[] = "Art";

        if ($this->matches($cn,"200-299"))
            $subjects[] = "Biblical & Theological Studies";

        if ($this->matches($cn,'570-599'))
            $subjects[] = "Biology";

        if ( $this->matches($cn,'330-349,657-659,406,506,650,706,906'))
            $subjects[] = "Business & Economics";

        if ($this->matches($cn,'540-548'))
            $subjects[] = "Chemistry";

        if ($this->matches($cn,'230-236,238-243,246-249,262-265,268-287'))
            $subjects[] = "Christian Formation & Ministry";

        if ($this->matches($cn,'70-79,302,383,384,791,792,800,808'))
            $subjects[] = "Communication";

        if ($this->matches($cn,'3-6'))
            $subjects[] = "Computer Science";

        if ($this->matches($cn,'370-378'))
            $subjects[] = "Education";

        if ($this->matches($cn,'620-629'))
            $subjects[] = "Engineering";

        if ($this->matches($cn,'800-829'))
            $subjects[] = "English";

        if (false)
            $subjects[] = "Environmental Science";

        if (false)
            $subjects[] = "Foreign Languages";

        if ($this->matches($cn,'550-560'))
            $subjects[] = "Geology";

        if ($this->matches($cn,'900-999'))
            $subjects[] = "History";

        if (false)
            $subjects[] = "HNGR";

        if (false)
            $subjects[] = "Intercultural Studies";

        if ($this->matches($cn,'500-519'))
            $subjects[] = "Mathematics";

        if ($this->matches($cn,'780-789'))
            $subjects[] = "Music";

        if ($this->matches($cn,'100-129,140-149,160-199'))
            $subjects[] = "Philosophy";

        if ($this->matches($cn,'520-539'))
            $subjects[] = "Physics";

        if ($this->matches($cn,'310-329'))
            $subjects[] = "Politics & International Relations";

        if ($this->matches($cn,'150-159,616'))
            $subjects[] = "Psychology";

        if ($this->matches($cn,'300-309'))
            $subjects[] = "Sociology";

        if ($this->matches($cn,'307'))
            $subjects[] = "Urban Studies";

        return implode(', ',$subjects);
    }

    protected function cmp_cn($cn1, $cn2) {
        if ($cn1<$cn2) {
            return -1;
        } else if ($cn1==$cn2) {
            return 0;
        } else {
            return 1;
        }
    }

    protected function matches($cn, $range) {
        foreach ( Util::parse_range($range) as $r ) {
            if (count($r)===1) {
                if ($this->cmp_cn($cn,$r[0])===0)
                    return true;
            } else if ($this->cmp_cn($r[0],$cn)<=0 && $this->cmp_cn($cn,$r[1])<=0) {
                return true;
            }
        }
        return false;
    }
}
