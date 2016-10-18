<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:37
 */

namespace Player;


use Skill\SkillCollection;

interface SkilledInterface
{
    public function setSkills(SkillCollection $skills);
    public function getSkills();
}