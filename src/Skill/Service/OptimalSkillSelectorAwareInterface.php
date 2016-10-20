<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 21:43
 */

namespace Skill\Service;

/**
 * Interface OptimalSkillSelectorAwareInterface
 * @package Skill\Service
 */
interface OptimalSkillSelectorAwareInterface
{
    /**
     * @return OptimalSkillSelectorInterface
     */
    public function getOptimalSkillSelector();

    /**
     * @param OptimalSkillSelectorInterface $selector
     */
    public function setOptimalSkillSelector(OptimalSkillSelectorInterface $selector);
}