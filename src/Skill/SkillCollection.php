<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:15
 */

namespace Skill;

/**
 * Class SkillCollection
 * @package Skill
 */
class SkillCollection implements \Iterator
{
    /**
     * Defence skill type
     */
    const DEFENCE_SKILL_SET = 'defence';

    /**
     * Offense skill type
     */
    const OFFENSE_SKILL_SET = 'offense';

    /**
     * Skills
     * @var array
     */
    private $skills = [];

    /**
     * Current skill type
     * @var string
     */
    private $currentSkillSet;

    /**
     * Iterration position
     * @var int
     */
    private $position = 0;

    /**
     * @param SkillInterface $skill
     * @throws \Exception
     */
    public function add(SkillInterface $skill)
    {
        if ($skill instanceof OffenceSkillInterface) {
            $this->skills[self::OFFENSE_SKILL_SET][] = $skill;
        } elseif ($skill instanceof DefenceSkillInterface) {
            $this->skills[self::DEFENCE_SKILL_SET][] = $skill;
        } else {
            throw new \Exception('Unsupported skill type!');
        }
    }

    /**
     * @param $skillSet
     * @return $this
     * @throws \Exception
     */
    public function setCurrentSkillSet($skillSet)
    {
        if (!in_array($skillSet, [self::DEFENCE_SKILL_SET, self::OFFENSE_SKILL_SET])) {
            throw new \Exception('Invalid skill set used!');
        }
        $this->currentSkillSet = $skillSet;
        $this->rewind();
        return $this;
    }

    /**
     * @return SkillInterface
     */
    public function current()
    {
        return $this->skills[$this->currentSkillSet][$this->position];
    }

    /**
     * Advance cursor position
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Get current key
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->skills[$this->currentSkillSet][$this->position]);
    }

    /**
     * Rewind collection
     */
    public function rewind()
    {
        $this->position = 0;
    }
}