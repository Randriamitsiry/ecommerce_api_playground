<?php
/**
 * File: AbstractPostingAction.php
 * User: Jess Gabriel <tsiryjessgabriel@gmail.com>
 */

namespace App\Core;


abstract class AbstractPostingAction extends AbstractAction
{
    /**
     * @param $data
     * @throws \Exception
     */
    protected function validatePayload($data)
    {
        if (!is_array($data)) {
            throw new \Exception('Payload is not valid json');
        }

        foreach ($this->getRequiredPayload() as $payload) {
            if (empty($data[$payload])) {
                throw new \Exception(sprintf('Payload %s is required', $payload));
            }
        }
    }

    protected abstract function getRequiredPayload(): array;
}