<?php

namespace xml\feed;

class Carli extends RSS {

    // URL for the I-Share Carli RSS feed
    const CARLI_URL = "https://i-share.carli.illinois.edu/newbooks/newbooks.cgi?library=WHEdb&list=all&day=7&op=and&text=&lang=English&submit=RSS";


    /**
     * Carli constructor.
     * @param string $alternate_url (OPTIONAL) Specify the URL to the RSS feed. Used for testing.
     */
    public function __construct($alternate_url = null) {
        // Use the alternate url if set (e.g. for testing)
        $url = ($alternate_url === null) ? Carli::CARLI_URL : $alternate_url;

        parent::__construct($url);
        $nitems = count($this->xml->channel->item);
        for ( $i=0; $i<$nitems; ++$i ) {

            $tidy_desc = \str_replace(array('&lt;B&gt;','&lt;/B&gt;','<description>','</description>'),
                '',$this->xml->channel->item[$i]->description->asXML());

            $matches = array();
            if(\preg_match(
                '@&lt;img border="0" src="(.*)" vspace="3" border="0" align="right"/&gt;@',
                $tidy_desc,$matches)) {
                if (\util\Utility::isValidImage($matches[1])) {
                    $imgurl = $matches[1];
                } else {
                    $imgurl = "";
                }
                $tidy_desc = str_replace($matches[0],'',$tidy_desc);
            } else {
                $imgurl = "";
            }

            $fieldstr =  \explode('&lt;BR/&gt;',$tidy_desc);
            $this->xml->channel->item[$i]->description = \implode("\n",$fieldstr);

            $fields = array();
            foreach($fieldstr as $f) {
                //separate field name and field value
                $matches = array();
                if(\preg_match("/^([-a-zA-Z_ ]*[a-zA-Z]{4}): /",$f,$matches)) {
                    $fname = \strtolower(str_replace(' ','_',\trim($matches[1])));
                    $fvalue = \trim(str_replace($matches[0],'',$f));
		    $fields[$fname] = $fvalue;
                    if($fname == 'location'){
                    	continue;
		    }
                    $this->xml->channel->item[$i]->addChild($fname,$fvalue);
                }
            }

            $cn_data = \cn\processor\Factory::make($fields)->data();
            foreach($cn_data as $name => $value) {
                $name = \htmlspecialchars($name);
                $value = \htmlspecialchars($value);
                $this->xml->channel->item[$i]->addChild($name,$value);
            }

            unset($this->xml->channel->item[$i]->description[0]);

            if (! \util\Utility::isValidImage($imgurl))
                $imgurl = "";
            $this->xml->channel->item[$i]->addChild('cover',$imgurl);
        }
    }
}
