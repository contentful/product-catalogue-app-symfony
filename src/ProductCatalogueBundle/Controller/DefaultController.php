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
    const CT_PRODUCT = '2PqfXUJwE8qSYKuM0U6w8M';
    const CT_CATEGORY = '6XwpTaSiiI2Ak2Ww0oi6qa';
    const CT_BRAND = 'sFzTZbSuM8coEwygeUYes';

    /**
     * @Route("/", name="product")
     */
    public function indexAction()
    {
        $client = $this->get('contentful.delivery');
        $query = (new Query())->setContentType(self::CT_PRODUCT);
        $products = $client->getEntries($query);

        return $this->render('default/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/{id}", name="product.item")
     */
    public function productAction($id)
    {
        $client = $this->get('contentful.delivery');
        $product = $client->getEntry($id);

        if (!$product) {
            throw new NotFoundHttpException;
        }

        if ($product->getContentType()->getId() !== self::CT_PRODUCT) {
            throw new NotFoundHttpException;
        }

        return $this->render('default/product.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/category", name="category")
     */
    public function categoriesAction()
    {
        $client = $this->get('contentful.delivery');
        $query = (new Query())->setContentType(self::CT_CATEGORY);
        $categories = $client->getEntries($query);

        return $this->render('default/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category.item")
     */
    public function categoryAction($id)
    {
        $client = $this->get('contentful.delivery');
        $category = $client->getEntry($id);

        if (!$category) {
            throw new NotFoundHttpException;
        }

        if ($category->getContentType()->getId() !== self::CT_CATEGORY) {
            throw new NotFoundHttpException;
        }

        $query = (new Query())
            ->setContentType(self::CT_PRODUCT)
            ->where('fields.categories.sys.id', $id);
        $products = $client->getEntries($query);

        return $this->render('default/category.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }

    /**
     * @Route("/brand", name="brand")
     */
    public function brandsAction()
    {
        $client = $this->get('contentful.delivery');
        $query = (new Query())->setContentType(self::CT_BRAND);
        $brands = $client->getEntries($query);

        return $this->render('default/brands.html.twig', [
            'brands' => $brands
        ]);
    }

    /**
     * @Route("/brand/{id}", name="brand.item")
     */
    public function brandAction($id)
    {
        $client = $this->get('contentful.delivery');
        $brand = $client->getEntry($id);

        if (!$brand) {
            throw new NotFoundHttpException;
        }

        if ($brand->getContentType()->getId() !== self::CT_BRAND) {
            throw new NotFoundHttpException;
        }

        $query = (new Query())
            ->setContentType(self::CT_PRODUCT)
            ->where('fields.brand.sys.id', $id);
        $products = $client->getEntries($query);

        return $this->render('default/brand.html.twig', [
            'brand' => $brand,
            'products' => $products
        ]);
    }
}
