<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:43
 */

namespace Skill\Service;


interface OptimalSkillSelectorAwareInterface
{
    public function getOptimalSkillSelector();
    public function setOptimalSkillSelector(OptimalSkillSelectorInterface $selector);
}