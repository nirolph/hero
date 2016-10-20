<?php
/**
 * Created by PhpStorm.
 * User: florin
 * Date: 18.10.2016
 * Time: 23:18
 */

namespace Match\Observer;


use Match\Broadcaster\BroadcasterInterface;

class MatchObserver implements ObserverInterface
{
    private $messages = [];
    private $renderer;

    /**
     * MatchObserver constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function listen($message)
    {
        $this->messages[] = $message;
    }

    public function subscribe(BroadcasterInterface $subject)
    {
        $subject->addObserver($this);
    }

    public function outputRoundStats()
    {
        $this->renderer->render($this->messages);
        $this->messages = [];
    }

}