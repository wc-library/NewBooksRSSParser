<?php

namespace xml\feed;

class Carli extends RSS {

    public function __construct() {
        parent::__construct("https://i-share.carli.illinois.edu/newbooks/newbooks.cgi?library=WHEdb&list=all&day=7&op=and&text=&lang=English&submit=RSS");
        $nitems = count($this->xml->channel->item);
        for ( $i=0; $i<$nitems; ++$i ) {

            $str =  \explode('&lt;BR/&gt;',
                    \preg_replace('@&lt;img border="0" src="(.*)" vspace="3" border="0" align="right"/&gt;@',"\\1",
                    \str_replace(array(
                            '&lt;B&gt;',
                            '&lt;/B&gt;',
                            '<description>','</description>'),
                        '',
                        $this->xml->channel->item[$i]->description->asXML()
                        ))
                );
            $this->xml->channel->item[$i]->description = \implode("\n",$str);
            $fieldstr = $str;
            $fields = array();

            foreach($fieldstr as $f) {
                //separate field name and field value
                $matches = array();
                if(\preg_match("/^([-a-zA-Z_ ]*[a-zA-Z]{4}): /",$f,$matches)) {
                    $fname = \strtolower(str_replace(' ','_',\trim($matches[1])));
                    $fvalue = \trim(str_replace($matches[0],'',$f));
                    $fields[$fname] = $fvalue;
                    $this->xml->channel->item[$i]->addChild($fname,$fvalue);
                }
            }

            $cn_data = \cn\processor\Factory::make($fields)->data();
            foreach($cn_data as $name => $value) {
                $name = \htmlspecialchars($name);
                $value = \htmlspecialchars($value);
                $this->xml->channel->item[$i]->addChild($name,$value);
            }
        }
    }
}
