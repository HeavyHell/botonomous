<?php

namespace Slackbot\Tests;

use Slackbot\Config;
use Slackbot\Slackbot;

class PhpunitHelper
{
    public function getSlackbot()
    {
        $config = new Config();
        $commandPrefix = $config->get('commandPrefix');

        /**
         * Form the request.
         */
        $botUsername = '@'.$config->get('botUsername');
        $request = [
            'token' => $config->get('outgoingWebhookToken'),
            'text'  => "{$botUsername} {$commandPrefix}ping",
        ];

        $slackbot = new Slackbot();

        // get listener
        $listener = $slackbot->getListener();

        // set request
        $listener->setRequest($request);

        return $slackbot;
    }
}
