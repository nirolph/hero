<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 19.10.2016
 * Time: 16:36
 */

namespace Match;


use Player\EntityInterface;

class HeroGame implements GameEngineInterface
{
    const MAX_ROUNDS = 20;

    private $hero;
    private $beast;
    private $round = 1;
    private $heroAttacks = null;

    public function run()
    {
        $this->setup();

        do {
            dump(sprintf('---------- ROUND %s ----------', $this->round));
            $attacker = $this->getAttacker();
            $defender = $this->getDefender();
            $this->engage($attacker, $defender);
            if ($defender->isDead()) {
                dump(sprintf('We have a victor! %s has slain %s.', $attacker->getName(), $defender->getName()));
                return;
            }
            $this->printStats();
            $this->endTurn();
        } while ($this->round <= self::MAX_ROUNDS);
        $this->determineVictor();
    }

    private function engage(EntityInterface $attacker, EntityInterface $defender)
    {
        $defender->defend($attacker->attack());
    }

    private function setup()
    {
        $this->spawnPlayers();
        $this->decideWhoGetsFirstBlood();
    }

    private function spawnPlayers()
    {
        $heroFactory = new \Player\Factory\OrderusHeroFactory();
        $beastFactory = new \Player\Factory\BeastFactory();

        $this->hero = $heroFactory->create();
        $this->beast = $beastFactory->create();
    }

    private function decideWhoGetsFirstBlood()
    {
        if (!$this->decideBySpeed()) {
            $this->decideByLuck();
        }
        if (is_null($this->heroAttacks)) {
            throw new \Exception('Can\'t decide who get\'s first blood.');
        }
    }

    private function decideBySpeed()
    {
        $heroSpeed = $this->hero->getStats()->getSpeed();
        $beastSpeed = $this->beast->getStats()->getSpeed();
        if ($heroSpeed > $beastSpeed) {
            $this->heroAttacks = true;
            return true;
        }

        if ($heroSpeed < $beastSpeed) {
            $this->heroAttacks = false;
            return true;
        }
        return false;
    }

    private function decideByLuck()
    {
        $heroLuck = $this->hero->getStats()->getLuck();
        $beastLuck = $this->beast->getStats()->getLuck();
        if ($heroLuck > $beastLuck) {
            $this->heroAttacks = true;
            return true;
        }

        if ($heroLuck < $beastLuck) {
            $this->heroAttacks = false;
            return true;
        }
        return false;
    }

    private function getAttacker()
    {
        return $this->heroAttacks ? $this->hero : $this->beast;
    }

    private function getDefender()
    {
        return $this->heroAttacks ? $this->beast : $this->hero;
    }

    private function endTurn()
    {
        $this->heroAttacks = !$this->heroAttacks;
        ++$this->round;
    }

    private function determineVictor()
    {
        $heroHealth = $this->hero->getStats()->getHealth();
        $beastHealth = $this->beast->getStats()->getHealth();

        if ($heroHealth > $beastHealth) {
            dump(sprintf('%s is the victor!', $this->hero->getName()));
        } elseif ($heroHealth < $beastHealth) {
            dump(sprintf('%s is the victor!', $this->beast->getName()));
        } else {
            dump('It\'s a draw');
        }
    }

    private function printStats()
    {
        dump(sprintf('Orderus HP: %s', $this->hero->getStats()->getHealth()));
        dump(sprintf('Beast HP: %s', $this->beast->getStats()->getHealth()));
    }
}