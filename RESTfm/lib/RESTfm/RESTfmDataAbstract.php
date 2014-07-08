<?php
/**
 * @copyright
 * © 2011-2014 Goya Pty Ltd.
 *
 * @license
 * This file is subject to the Goya Software License contained in the LICENSE
 * file distributed with this package.
 *
 * @author
 *  Gavin Stewart
 */











abstract class RESTfmDataAbstract implements Iterator {

















abstract public function addSection ($vb81d8ef0, $v190c7e41 = 2);







abstract public function sectionExists ($vb81d8ef0);







abstract public function sectionIndexExists ($vb81d8ef0, $v5ae87d2c);







abstract public function getSectionNames ();









abstract public function getSection ($vb81d8ef0);








abstract public function getSectionDimensions ($vb81d8ef0);








abstract public function getSectionCount ($vb81d8ef0);











abstract public function getSectionCount2nd ($vb81d8ef0, $v5ae87d2c);












abstract public function setSectionData ($vb81d8ef0, $v5ae87d2c, $v65e79da0);













abstract public function setSectionData2nd ($vb81d8ef0, $v9f7dabb9, $v372f61c4, $v07c32dc0);











abstract public function getSectionData ($vb81d8ef0, $v5ae87d2c);











abstract public function getSectionData2nd ($vb81d8ef0, $v9f7dabb9, $v372f61c4);







abstract public function deleteSectionData ($vb81d8ef0, $v5ae87d2c);






abstract public function setIteratorSection ($vb81d8ef0);






abstract public function __toString ();

}
