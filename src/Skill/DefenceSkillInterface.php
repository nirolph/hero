<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:38
 */

namespace Skill;

use Strike\StrikeInterface;
use Player\EntityInterface;

interface DefenceSkillInterface extends SkillInterface
{
    public function defend(StrikeInterface $strike);
    public function getDefenceEffectiveness(StrikeInterface $strike);
}