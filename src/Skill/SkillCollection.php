<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 22:15
 */

namespace Skill;


class SkillCollection implements \Iterator
{
    const DEFENCE_SKILL_SET = 'defence';
    const OFFENSE_SKILL_SET = 'offense';

    private $skills = [];
    private $currentSkillSet;
    private $position = 0;

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

    public function setCurrentSkillSet($skillSet)
    {
        if (!in_array($skillSet, [self::DEFENCE_SKILL_SET, self::OFFENSE_SKILL_SET])) {
            throw new \Exception('Invalid skill set used!');
        }
        $this->currentSkillSet = $skillSet;
        $this->rewind();
        return $this;
    }

    public function current()
    {
        return $this->skills[$this->currentSkillSet][$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->skills[$this->currentSkillSet][$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}