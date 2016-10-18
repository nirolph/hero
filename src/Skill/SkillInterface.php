<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:40
 */

namespace Skill;


use Player\EntityInterface;

interface SkillInterface
{
    public static function attachTo(EntityInterface $entity);
}