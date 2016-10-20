<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 19:40
 */

namespace Skill;


use Player\EntityInterface;

/**
 * Interface SkillInterface
 * @package Skill
 */
interface SkillInterface
{
    /**
     * Attach to an Entity
     * @param EntityInterface $entity
     * @return mixed
     */
    public static function attachTo(EntityInterface $entity);
}