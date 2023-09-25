<?php

//
// Create a DOCX file. Page example
 //
 // @category   Phpdocx
 // @package    examples
 // @subpackage easy
 // @copyright  Copyright (c) 2009-2011 Narcea Producciones Multimedia S.L.
 //             (http://www.2mdc.com)
 // @license    LGPL
 // @version    2.0
 // @link       http://www.phpdocx.com
 // @since      File available since Release 2.0
 //
require_once '../../classes/CreateDocx.inc';

$docx = new CreateDocx();

$text = '<h1>Lorem ipsum dolor sit amet</h1>
<p>Consectetur adipiscing elit. Ut vestibulum cursus nunc vel posuere. Integer vehicula sem ac leo vehicula blandit a eget urna. Quisque magna nisl, malesuada at luctus eu, lobortis nec nunc. Aliquam ut risus mauris, eget scelerisque urna. </p>
<ul>
  <li>Morbi vulputate auctor augue vel imperdiet. Aenean condimentum sodales elit, sit amet egestas quam pharetra eu. </li>
  <li>Fusce nec augue tellus, sed faucibus elit. Pellentesque ut odio nisi, vel laoreet quam. Integer ante ante, iaculis eu porta vitae, lacinia id nulla. </li>
  <li>Sed tincidunt orci eget ligula pretium bibendum. Praesent turpis eros, pellentesque nec porta eu, pretium euismod nunc. </li>
  <li>Nunc imperdiet lacus nec sem feugiat sit amet semper nisl facilisis. Suspendisse potenti.</li>
</ul>
<p>Donec diam dui, venenatis a rutrum eu, consequat nec massa. In varius augue quis dui egestas sit amet pretium odio malesuada. Donec nec purus velit. Vivamus tincidunt venenatis magna eu mattis. Vivamus nec dignissim risus. Mauris eu quam at tellus eleifend sollicitudin id in dolor. Suspendisse pretium pellentesque quam, eu pulvinar ligula tincidunt ut. Nunc a neque vitae nulla malesuada eleifend. Ut rutrum velit et tortor placerat ac iaculis ante dictum. Vestibulum id lorem quis dui consectetur egestas et ut enim. Nam eget tincidunt ligula.</p>
<p>Vivamus congue lacus ac sem semper vel vehicula arcu eleifend. Ut auctor luctus consequat. Nullam vitae varius sapien. Suspendisse faucibus luctus justo, eu ullamcorper ante porttitor ac. Nunc rhoncus arcu vel nulla suscipit gravida euismod nibh consectetur. Aenean ante nulla, luctus quis placerat in, fermentum eu ante. Nunc sagittis arcu vitae purus sodales at aliquet felis iaculis. Nam pharetra, ipsum vel scelerisque porttitor, lacus quam congue magna, eu pharetra metus metus id neque. Vivamus vel elementum ante. Pellentesque erat nunc, cursus ut consectetur sagittis, pretium nec nisl. Praesent erat mi, ornare non tincidunt vel, venenatis sit amet sapien. Donec pulvinar nisi vitae risus adipiscing mollis quis at quam. Maecenas faucibus lorem sit amet purus aliquet gravida.</p>';

$docx->addText($text);

$paramsPage = array(
    'titlePage' => 1,
    'orient' => 'normal',
    'top' => 4000,
    'bottom' => 4000,
    'right' => 4000,
    'left' => 4000
);

$docx->createDocx('kwd', $paramsPage);

?>
