<?php

namespace cn\processor;

class Dewey extends AbstractProcessor {
    public function __construct($number) {
        $this->cn = $number + 0.0;
        $this->data = array('classification_type'=>'Dewey',
            'subject' => $this->getSubject());
    }

    public function getSubject() {
        $subjects = array();

        if ($this->matches("300,301,306"))
            $subjects[] = "Anthropology";

        if ($this->matches("611-616"))
            $subjects[] = "Applied Health Science";

        if ($this->matches("700-770"))
            $subjects[] = "Art";

        if ($this->matches("200-299"))
            $subjects[] = "Biblical & Theological Studies";

        if ($this->matches('570-599'))
            $subjects[] = "Biology";

        if ( $this->matches('330-349,657-659,406,506,650,706,906'))
            $subjects[] = "Business & Economics";

        if ($this->matches('540-548'))
            $subjects[] = "Chemistry";

        if ($this->matches('230-236,238-243,246-249,262-265,268-287'))
            $subjects[] = "Christian Formation & Ministry";

        if ($this->matches('70-79,302,383,384,791,792,800,808'))
            $subjects[] = "Communication";

        if ($this->matches('3-6'))
            $subjects[] = "Computer Science";

        if ($this->matches('370-378'))
            $subjects[] = "Education";

        if ($this->matches('620-629'))
            $subjects[] = "Engineering";

        if ($this->matches('800-829'))
            $subjects[] = "English";

        if (false)
            $subjects[] = "Environmental Science";

        if (false)
            $subjects[] = "Foreign Languages";

        if ($this->matches('550-560'))
            $subjects[] = "Geology";

        if ($this->matches('900-999'))
            $subjects[] = "History";

        if (false)
            $subjects[] = "HNGR";

        if ($this->matches("266"))
            $subjects[] = "Intercultural Studies";

        if ($this->matches('500-519'))
            $subjects[] = "Mathematics";

        if ($this->matches('780-789'))
            $subjects[] = "Music";

        if ($this->matches('100-129,140-149,160-199'))
            $subjects[] = "Philosophy";

        if ($this->matches('520-539'))
            $subjects[] = "Physics";

        if ($this->matches('310-329'))
            $subjects[] = "Politics & International Relations";

        if ($this->matches('150-159,616'))
            $subjects[] = "Psychology";

        if ($this->matches('300-309'))
            $subjects[] = "Sociology";

        if ($this->matches('307'))
            $subjects[] = "Urban Studies";

        return implode(', ',$subjects);
    }

    protected function compareTo($class) {
        if ($this->cn<$class) {
            return -1;
        } else if ($this->cn==$class) {
            return 0;
        } else {
            return 1;
        }
    }

    public function matches($range) {
        foreach ( \util\Utility::parseRange($range) as $r ) {
            if (count($r)===1) {
                if ($this->equals($r[0]))
                    return true;
            } else if ($this->greaterThan($r[0]) && $this->lessThan($r[1])) {
                return true;
            }
        }
        return false;
    }
}
