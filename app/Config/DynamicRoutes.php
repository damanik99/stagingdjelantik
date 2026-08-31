<?php

namespace Config;

use Config\Services;

class DynamicRoutes
{
    public static function load(): void
    {
        $routes = Services::routes();
        $db     = \Config\Database::connect();

        $builder = $db->table('route r');

        $builder->select([
            'r.route_id',
            'r.page_id',
            'r.action_id',
            'r.uri',
            'r.http_method',
            'r.controller',
            'r.method',
        ]);

        $builder->orderBy('r.route_id', 'ASC');

        $query = $builder->get();

        foreach ($query->getResult() as $row) {

            $uri        = trim($row->uri);
            $httpMethod = strtoupper(trim($row->http_method));
            $controller = trim($row->controller);
            $method     = trim($row->method);

            if (
                $uri === '' ||
                $controller === '' ||
                $method === ''
            ) {
                continue;
            }

            /*
             * =====================================================
             * BUILD CONTROLLER HANDLER
             * =====================================================
             *
             * Jika URI:
             * organization/detail/(:num)
             *
             * Maka handler:
             * Organization::detail/$1
             *
             * Jika URI:
             * organization
             *
             * Maka handler:
             * Organization::index
             */

            $parameters = [];

            preg_match_all(
                '/\(\:[a-zA-Z0-9_-]+\)/',
                $uri,
                $matches
            );

            if (!empty($matches[0])) {

                foreach ($matches[0] as $index => $parameter) {
                    $parameters[] = '$' . ($index + 1);
                }
            }

            $handler = $controller . '::' . $method;

            if (!empty($parameters)) {
                $handler .= '/' . implode('/', $parameters);
            }

            /*
             * =====================================================
             * PERMISSION
             * =====================================================
             */

            $filter = 'permission:' .
                $row->page_id . ',' .
                $row->action_id;

            $options = [
                'filter' => $filter,
            ];

            /*
             * =====================================================
             * REGISTER ROUTE
             * =====================================================
             */

            switch ($httpMethod) {

                case 'GET':

                    $routes->get(
                        $uri,
                        $handler,
                        $options
                    );

                    break;

                case 'POST':

                    $routes->post(
                        $uri,
                        $handler,
                        $options
                    );

                    break;

                case 'PUT':

                    $routes->put(
                        $uri,
                        $handler,
                        $options
                    );

                    break;

                case 'PATCH':

                    $routes->patch(
                        $uri,
                        $handler,
                        $options
                    );

                    break;

                case 'DELETE':

                    $routes->delete(
                        $uri,
                        $handler,
                        $options
                    );

                    break;

                default:

                    log_message(
                        'error',
                        'Invalid HTTP method on route_id: ' .
                            $row->route_id
                    );

                    break;
            }
        }
    }
}
