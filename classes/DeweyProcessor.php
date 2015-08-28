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

        if ($this->in_range($cn,"300,301,306"))
            $s .= ", Anthropology";
        if ($this->in_range($cn,"611-616"))
            $s .= ", Applied Health Science";
        if ($this->in_range($cn,"700-770"))
            $s .= ", Art";
        if ($this->in_range($cn,"200-299"))
            $s .= ", Biblical & Theological Studies";
        if ($this->in_range($cn,'570-599'))
            $s .= ", Biology";
        if ( $this->in_range($cn,'330-349,657-659,406,506,650,706,906'))
            $s .= ", Business & Economics";
        if ($this->in_range($cn,'540-548'))
            $s .= ", Chemistry";
        if ($this->in_range($cn,'230-236,238-243,246-249,262-265,268-287'))
            $s .= ", Christian Formation & Ministry";
        if ($this->in_range($cn,'70-79'))
            $s .= ", Communication: journalism";
        if ($this->in_range($cn,'302'))
            $s .= ", Communication: interpersonal";
        if ($this->in_range($cn,'383,384'))
            $s .= ", Communication: businesses";
        if ($this->in_range($cn,'791,792'))
            $s .= ", Communication: cinema and theatre arts";
        if ($this->in_range($cn,'800,808'))
            $s .= ", Communication: rhetoric";
        if ($this->in_range($cn,'3-6'))
            $s .= ", Computer Science";
        if ($this->in_range($cn,'370-378'))
            $s .= ", Education";
        if ($this->in_range($cn,'620-629'))
            $s .= ", Engineering";
        if ($this->in_range($cn,'800-829'))
            $s .= ", English";
        if (false)
            $s .= ", Environmental Science";
        if (false)
            $s .= ", Foreign Languages";
        if ($this->in_range($cn,'550-560'))
            $s .= ", Geology";
        if ($this->in_range($cn,'900-999'))
            $s .= ", History";
        if (false)
            $s .= ", HNGR";
        if (false)
            $s .= ", Intercultural Studies";
        if ($this->in_range($cn,'500-519'))
            $s .= ", Mathematics";
        if ($this->in_range($cn,'780-789'))
            $s .= ", Music";
        if ($this->in_range($cn,'100-129,140-149,160-199'))
            $s .= ", Philosophy";
        if ($this->in_range($cn,'520-539'))
            $s .= ", Physics";
        if ($this->in_range($cn,'310-329'))
            $s .= ", Politics & International Relations";
        if ($this->in_range($cn,'150-159,616'))
            $s .= ", Psychology";
        if ($this->in_range($cn,'300-309'))
            $s .= ", Sociology";
        if ($this->in_range($cn,'307'))
            $s .= ", Urban Studies";

        return $s;
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
}
