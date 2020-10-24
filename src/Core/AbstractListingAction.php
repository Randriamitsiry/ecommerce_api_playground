<?php
/**
 * File: AbstractListingAction.php
 * User: Jess Gabriel <tsiryjessgabriel@gmail.com>
 */

namespace App\Core;


use Symfony\Component\HttpFoundation\Request;

abstract class AbstractListingAction extends AbstractAction
{
    /**
     * Get criteria available for action.
     *
     * @return array
     */
    abstract protected function getPossibleCriteria(): array;

    /**
     * Map http request params to criteria.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function getCriteria(Request $request): array
    {
        $criteria = [];
        foreach ($this->getPossibleCriteria() as $inputName) {
            if ('' !== $request->get($inputName, '')) {
                $criteria[$inputName] = $request->get($inputName);
            }
        }

        return $criteria;
    }
}