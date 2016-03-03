<?php
/**
 * @copyright 2016 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\ProductCatalogueBundle;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;

class ContentfulRouteProvider implements RouteProviderInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $collection = new RouteCollection();

        if ($request->getMethod() !== 'GET') {
            return $collection;
        }

        $path = $request->getPathInfo();
        $parts = explode('/', $path);
        array_shift($parts);
        if (count($parts) !== 2) {
            return $collection;
        }

        if ($parts[0] === 'product') {
            $query = (new Query())->setContentType('2PqfXUJwE8qSYKuM0U6w8M')->where('sys.id', $parts[1]);
            $results = $this->client->getEntries($query);

            if (!count($results)) {
                return $collection;
            }

            $entry = $results[0];
            $route = new Route($path, array(
                'document' => $entry
            ));

            $collection->add('product.' . $entry->getId(), $route);
        } elseif ($parts[0] === 'category') {

        }

        return $collection;
    }

    public function getRouteByName($name, $params = array())
    {

    }

    public function getRoutesByNames($names)
    {

    }
}
