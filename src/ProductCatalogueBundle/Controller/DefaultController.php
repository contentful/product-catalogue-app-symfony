<?php
/**
 * @copyright 2016 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\ProductCatalogueBundle\Controller;

use Contentful\Delivery\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $client = $this->get('contentful.delivery');
        $query = (new Query())->setContentType('2PqfXUJwE8qSYKuM0U6w8M');
        $products = $client->getEntries($query);

        return $this->render('default/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function productAction($id)
    {
        $client = $this->get('contentful.delivery');
        $product = $client->getEntry($id);

        if (!$product) {
            throw new NotFoundHttpException;
        }

        if ($product->getContentType()->getId() !== '2PqfXUJwE8qSYKuM0U6w8M') {
            throw new NotFoundHttpException;
        }

        return $this->render('default/product.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function categoryAction($id)
    {
        $client = $this->get('contentful.delivery');
        $category = $client->getEntry($id);

        if (!$category) {
            throw new NotFoundHttpException;
        }

        if ($category->getContentType()->getId() !== '6XwpTaSiiI2Ak2Ww0oi6qa') {
            throw new NotFoundHttpException;
        }

        return $this->render('default/category.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/brand/{id}", name="brand")
     */
    public function brandAction($id)
    {
        $client = $this->get('contentful.delivery');
        $brand = $client->getEntry($id);

        if (!$brand) {
            throw new NotFoundHttpException;
        }

        if ($brand->getContentType()->getId() !== 'sFzTZbSuM8coEwygeUYes') {
            throw new NotFoundHttpException;
        }

        return $this->render('default/brand.html.twig', [
            'brand' => $brand
        ]);
    }
}
