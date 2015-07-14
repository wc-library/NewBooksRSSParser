<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author bgarcia
 */
interface ClassificationProcessorInterface {
    public function data(); // returns an associative array (fieldname=>value)
                            // indicating the fields CarliBookFeed should append
                            // to an entry
}
