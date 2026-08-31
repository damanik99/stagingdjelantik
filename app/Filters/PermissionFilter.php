<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    ) {
        $usersId = (int) session()->get('users_id');

        if ($usersId <= 0) {

            session()->set(
                'redirect_url',
                current_url()
            );

            return redirect()->to(
                base_url('auth')
            );
        }

        /*
     * Permission parameter
     */
        if (
            !isset($arguments[0]) ||
            !isset($arguments[1])
        ) {
            return $this->forbidden(
                'Permission parameter tidak valid.'
            );
        }

        $pageId   = (int) $arguments[0];
        $actionId = (int) $arguments[1];

        if (
            $pageId <= 0 ||
            $actionId <= 0
        ) {
            return $this->forbidden(
                'Page atau action tidak valid.'
            );
        }

        /*
     * Check permission
     */
        $permission = service('permission');

        $allowed = $permission->can(
            $usersId,
            $pageId,
            $actionId
        );

        if (!$allowed) {
            return $this->forbidden(
                'Anda tidak memiliki permission untuk mengakses halaman ini.'
            );
        }

        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {}

    protected function forbidden(string $message)
    {
        return service('response')
            ->setStatusCode(403)
            ->setContentType('text/html')
            ->setBody(
                '<!DOCTYPE html>
                <html lang="id">
                <head>
                    <meta charset="UTF-8">
                    <title>403 Forbidden</title>
                </head>
                <body>
                    <h1>403 Forbidden</h1>
                    <p>' . esc($message) . '</p>
                </body>
                </html>'
            );
    }
}
