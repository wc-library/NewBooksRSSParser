<?php

namespace xml\feed;

class RSS {
    protected $xml;

    public function __construct($url) {
        if (($xmlstr=\file_get_contents($url))===FALSE)
            throw new \RuntimeException("Failed to fetch content from url: \n$url");

        $xmlstr = self::fixEncoding($xmlstr);

        $doc = new \DOMDocument();
        if ($doc->loadXML($xmlstr,LIBXML_PARSEHUGE|LIBXML_PEDANTIC) === FALSE) {
            \error_log("failed to loadXML from string");
        } else if ( ($this->xml=\simplexml_import_dom($doc)) === FALSE) {
            \error_log("failed to import DOM node into SimpleXML");
        }
    }

    public static function fixEncoding($xmlstr) {
        return \util\Encoding::toUTF8(
            preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $xmlstr)
            ); // https://github.com/neitanod/forceutf8
    }

    public function items() {
        return $this->xml->channel->item;
    }

    public function numItems() {
        return count($this->xml->channel->item);
    }

    public function xml() {
        header("Content-type: text/xml");
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'
            . $this->xml->channel->asXML() . "\n</rss>";

        return \preg_replace("@(</[a-z_]*>)(<[a-z])@","\\1\n\\2",$xml);
    }
}
