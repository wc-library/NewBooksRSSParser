<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NewBooksFeedReader
 *
 * @author bgarcia
 */
class CarliBookFeed extends RSSFeed {

    public function __construct() {
        parent::__construct("https://i-share.carli.illinois.edu/newbooks/newbooks.cgi?library=WHEdb&list=all&day=7&op=and&text=&lang=English&submit=RSS");
        $nitems = count($this->xml->channel->item);
        for ( $i=0; $i<$nitems; ++$i ) {

            $str =  explode('&lt;BR/&gt;',
                    preg_replace('@&lt;img border="0" src="(.*)" vspace="3" border="0" align="right"/&gt;@',"\\1",
                    str_replace(array(
                            '&lt;B&gt;',
                            '&lt;/B&gt;',
                            '<description>','</description>'),
                        '',
                        $this->xml->channel->item[$i]->description->asXML()
                        ))
                );
            $this->xml->channel->item[$i]->description = implode("\n",$str);
            $fields = $str;

            foreach($fields as $f) {

                //separate field name and field value
                $matches = array();
                if(preg_match("/^([-a-zA-Z_ ]*[a-zA-Z]{4}): /",$f,$matches)) {;
                    $fname = strtolower(str_replace(' ','_',trim($matches[1])));
                    $fvalue = trim(str_replace($matches[0],'',$f));

                    $this->xml->channel->item[$i]->addChild($fname,$fvalue);

                    if ($fname === 'call_number') {
                        $cn_data = self::analyze_call_number($fvalue);
                        foreach($cn_data as $name => $value) {
                            $name = htmlspecialchars($name);
                            $value = htmlspecialchars($value);
                            $this->xml->channel->item[$i]->addChild($name,$value);
                        }
                    }
                }
            }
        }
    }

    public static function analyze_call_number($callnumber) {
        return ClassificationFactory::makeProcessor($callnumber)->data();
    }
}
