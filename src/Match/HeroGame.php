<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 19.10.2016
 * Time: 16:36
 */

namespace Match;


use Match\Broadcaster\BroadcasterInterface;
use Match\Broadcaster\MessageBroadcaster;
use Match\Observer\JsonRenderer;
use Match\Observer\MatchObserver;
use Match\Observer\ObserverInterface;
use Match\Observer\SymfonyDumpRenderer;
use Player\EntityInterface;

/**
 * Orderus fight a best named Hellfire game
 * Class HeroGame
 * @package Match
 */
class HeroGame implements GameEngineInterface
{
    /**
     * Maximum number of rounds after which the winne is the player with most health left
     */
    const MAX_ROUNDS = 20;

    /**
     * The hero
     * @var EntityInterface
     */
    private $hero;

    /**
     * The beast
     * @var EntityInterface
     */
    private $beast;

    /**
     * Round count
     * @var int
     */
    private $round = 1;

    /**
     * Is it the hero's turn to attack?
     * @var null
     */
    private $heroAttacks = null;

    /**
     * The match observer
     * @var ObserverInterface
     */
    private $matchObserver;

    /**
     * The message broadcaster
     * @var BroadcasterInterface
     */
    private $messageBroadcaster;

    /**
     * Let the game begin
     */
    public function run()
    {
        $this->setup();
        $this->outputPlayersStats();

        do {
            $this->messageBroadcaster->broadcast(
                sprintf('---------- Round %s ----------', $this->round)
            );

            $attacker = $this->getAttacker();
            $defender = $this->getDefender();
            $this->engage($attacker, $defender);
            if ($defender->isDead()) {
                $this->messageBroadcaster->broadcast(
                    sprintf('We have a victor! %s has slain %s.', $attacker->getName(), $defender->getName())
                );
                $this->printStats();
                return;
            }

            $this->messageBroadcaster->broadcast(
                sprintf('%s HP: %s', $this->hero->getName(), $this->hero->getStats()->getHealth())
            );

            $this->messageBroadcaster->broadcast(
                sprintf('%s HP: %s', $this->beast->getName(), $this->beast->getStats()->getHealth())
            );

            $this->printStats();
            $this->endTurn();
        } while ($this->round <= self::MAX_ROUNDS);

        $this->determineVictor();
        $this->printStats();
    }

    /**
     *  Output player stats before game starts
     */
    private function outputPlayersStats()
    {
        $this->messageBroadcaster->broadcast(sprintf('Name: %s', $this->hero->getName()));
        $this->messageBroadcaster->broadcast(sprintf('Health: %s', $this->hero->getStats()->getHealth()));
        $this->messageBroadcaster->broadcast(sprintf('Strength: %s', $this->hero->getStats()->getStrength()));
        $this->messageBroadcaster->broadcast(sprintf('Defence: %s', $this->hero->getStats()->getDefence()));
        $this->messageBroadcaster->broadcast(sprintf('Speed: %s', $this->hero->getStats()->getSpeed()));
        $this->messageBroadcaster->broadcast(sprintf('Luck: %s', $this->hero->getStats()->getLuck()));

        $this->printStats();

        $this->messageBroadcaster->broadcast(sprintf('Name: %s', $this->beast->getName()));
        $this->messageBroadcaster->broadcast(sprintf('Health: %s', $this->beast->getStats()->getHealth()));
        $this->messageBroadcaster->broadcast(sprintf('Strength: %s', $this->beast->getStats()->getStrength()));
        $this->messageBroadcaster->broadcast(sprintf('Defence: %s', $this->beast->getStats()->getDefence()));
        $this->messageBroadcaster->broadcast(sprintf('Speed: %s', $this->beast->getStats()->getSpeed()));
        $this->messageBroadcaster->broadcast(sprintf('Luck: %s', $this->beast->getStats()->getLuck()));

        $this->printStats();
    }

    /**
     * Engage in battle
     * @param EntityInterface $attacker
     * @param EntityInterface $defender
     */
    private function engage(EntityInterface $attacker, EntityInterface $defender)
    {
        $defender->defend($attacker->attack());
    }

    /**
     * Initial game setup
     * @throws \Exception
     */
    private function setup()
    {
        $this->messageBroadcaster = new MessageBroadcaster();
        $this->matchObserver = new MatchObserver(new SymfonyDumpRenderer());
        $this->matchObserver->subscribe($this->messageBroadcaster);

        $this->spawnPlayers();
        $this->decideWhoGetsFirstBlood();
    }

    /**
     * Spawn the players
     */
    private function spawnPlayers()
    {
        $heroFactory = new \Player\Factory\OrderusHeroFactory();
        $heroFactory->addBroadcaster($this->messageBroadcaster);
        $beastFactory = new \Player\Factory\BeastFactory();
        $beastFactory->addBroadcaster($this->messageBroadcaster);

        $this->hero = $heroFactory->create();
        $this->beast = $beastFactory->create();
    }

    /**
     * Decide who draws first boold (who goes first)
     * @throws \Exception
     */
    private function decideWhoGetsFirstBlood()
    {
        if (!$this->decideBySpeed()) {
            $this->decideByLuck();
        }
        if (is_null($this->heroAttacks)) {
            throw new \Exception('Can\'t decide who get\'s first blood.');
        }
    }

    /**
     * Decide who has higher speed
     * @return bool
     */
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

    /**
     * Decide who has better luck
     * @return bool
     */
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

    /**
     * Get the current round's attacker
     * @return EntityInterface
     */
    private function getAttacker()
    {
        return $this->heroAttacks ? $this->hero : $this->beast;
    }

    /**
     * Get the current round's defender
     * @return EntityInterface
     */
    private function getDefender()
    {
        return $this->heroAttacks ? $this->beast : $this->hero;
    }

    /**
     * End the round
     */
    private function endTurn()
    {
        $this->heroAttacks = !$this->heroAttacks;
        ++$this->round;
    }

    /**
     * Determine who is victorious in battle
     */
    private function determineVictor()
    {
        $heroHealth = $this->hero->getStats()->getHealth();
        $beastHealth = $this->beast->getStats()->getHealth();

        if ($heroHealth > $beastHealth) {
            $this->messageBroadcaster->broadcast(
                sprintf('%s is the victor!', $this->hero->getName())
            );
        } elseif ($heroHealth < $beastHealth) {
            $this->messageBroadcaster->broadcast(
                sprintf('%s is the victor!', $this->beast->getName())
            );
        } else {
            $this->messageBroadcaster->broadcast(
                sprintf('It\'s a draw')
            );
        }
    }

    /**
     * Output current round statistics
     */
    private function printStats()
    {
        $this->matchObserver->outputRoundStats();
    }
}