<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:18
 */

namespace Match\Observer;


use Match\Broadcaster\BroadcasterInterface;

/**
 * A message observer implementation
 * Class MatchObserver
 * @package Match\Observer
 */
class MatchObserver implements ObserverInterface
{
    /**
     * @var array
     */
    private $messages = [];

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * MatchObserver constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Listen to incoming message
     * @param $message
     */
    public function listen($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Subscribe to a message broadcaster
     * @param BroadcasterInterface $subject
     */
    public function subscribe(BroadcasterInterface $subject)
    {
        $subject->addObserver($this);
    }

    /**
     * Output gathered messages using the injected renderer
     */
    public function outputRoundStats()
    {
        $this->renderer->render($this->messages);
        $this->messages = [];
    }

}