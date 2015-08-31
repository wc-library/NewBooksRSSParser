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

        if ($this->in_range($cn,"300,301,306"))
            $subjects[] = "Anthropology";

        if ($this->in_range($cn,"611-616"))
            $subjects[] = "Applied Health Science";

        if ($this->in_range($cn,"700-770"))
            $subjects[] = "Art";

        if ($this->in_range($cn,"200-299"))
            $subjects[] = "Biblical & Theological Studies";

        if ($this->in_range($cn,'570-599'))
            $subjects[] = "Biology";

        if ( $this->in_range($cn,'330-349,657-659,406,506,650,706,906'))
            $subjects[] = "Business & Economics";

        if ($this->in_range($cn,'540-548'))
            $subjects[] = "Chemistry";

        if ($this->in_range($cn,'230-236,238-243,246-249,262-265,268-287'))
            $subjects[] = "Christian Formation & Ministry";

        if ($this->in_range($cn,'70-79'))
            $subjects[] = "Communication: journalism";

        if ($this->in_range($cn,'302'))
            $subjects[] = "Communication: interpersonal";

        if ($this->in_range($cn,'383,384'))
            $subjects[] = "Communication: businesses";

        if ($this->in_range($cn,'791,792'))
            $subjects[] = "Communication: cinema and theatre arts";

        if ($this->in_range($cn,'800,808'))
            $subjects[] = "Communication: rhetoric";

        if ($this->in_range($cn,'3-6'))
            $subjects[] = "Computer Science";

        if ($this->in_range($cn,'370-378'))
            $subjects[] = "Education";

        if ($this->in_range($cn,'620-629'))
            $subjects[] = "Engineering";

        if ($this->in_range($cn,'800-829'))
            $subjects[] = "English";

        if (false)
            $subjects[] = "Environmental Science";

        if (false)
            $subjects[] = "Foreign Languages";

        if ($this->in_range($cn,'550-560'))
            $subjects[] = "Geology";

        if ($this->in_range($cn,'900-999'))
            $subjects[] = "History";

        if (false)
            $subjects[] = "HNGR";

        if (false)
            $subjects[] = "Intercultural Studies";

        if ($this->in_range($cn,'500-519'))
            $subjects[] = "Mathematics";

        if ($this->in_range($cn,'780-789'))
            $subjects[] = "Music";

        if ($this->in_range($cn,'100-129,140-149,160-199'))
            $subjects[] = "Philosophy";

        if ($this->in_range($cn,'520-539'))
            $subjects[] = "Physics";

        if ($this->in_range($cn,'310-329'))
            $subjects[] = "Politics & International Relations";

        if ($this->in_range($cn,'150-159,616'))
            $subjects[] = "Psychology";

        if ($this->in_range($cn,'300-309'))
            $subjects[] = "Sociology";

        if ($this->in_range($cn,'307'))
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
}
