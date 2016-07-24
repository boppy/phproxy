<?php

/**
 *
 * PHProxy
 *
 * @author		boppy <henning.bopp@gmail.com>
 * @copyright	2016- (boppy)
 * @license		GNU GPL v3
 * @repo       	https://github.com/phproxy/phproxy
 * @docs		http://phproxy.readthedocs.org
 *
 */

if(!isset($path)) $path = '../';

`lessc --clean-css {$path}css/style.less > {$path}css/style.css`;
touch($path .'css/style.less.ts', filemtime($path.'css/style.less'));
$f = preg_replace('|[\S\s]*?(#ppce_[\S\s]*)|', '$1', file_get_contents($path .'css/style.css'));
file_put_contents($path .'css/style-inline.css', $f);
