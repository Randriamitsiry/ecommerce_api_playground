<?php
/**
 * File: AbstractAction.php
 * User: Jess Gabriel <tsiryjessgabriel@gmail.com>
 */

namespace App\Core;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractAction
{
    const SUCCESS = 'success';
    const ERROR = 'error';

    /**
     * Check if request is POST or PUT
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function isPosting(Request $request): bool
    {
        return in_array($request->getMethod(), [
            Request::METHOD_POST,
            Request::METHOD_PUT,
        ]);
    }
    public function renderSuccess(array $data, array $meta = [])
    {
        //set response status to success just in case there is no provided custom status
        if (!isset($data['status'])) {
            $data['status'] = [
                'status' => self::SUCCESS,
            ];
        }
        $data['meta'] = $meta;

        return new JsonResponse($data);
    }

    public function renderError(int $errorCode, array $data = [], array $meta = [])
    {
        //set response status to error just in case there is no provided custom status
        if (!isset($data['status'])) {
            $data['status'] = [
                'status' => self::ERROR,
            ];
        }
        $data['meta'] = $meta;

        return new JsonResponse($data, $errorCode);
    }
}