<?php

namespace App\Controller;

use App\Service\ItemContainer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Lab1ApiController extends AbstractController
{
    /**
     * Endpoint zwracający listę wszystkich obiektów
     * @param ItemContainer $itemContainer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/lab1_api', name: 'app_lab1_api')]
    public function index(ItemContainer $itemContainer)
    {
        $itemContainer->createItemCollection();
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($itemContainer, 'json');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * Endpoint zwracający listę obiektów dla danego segmentu
     * @param $segmentName
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/get/segment/{segmentName}', name: 'getSegment', methods: ['GET', 'HEAD'])]
    public function getSegments ($segmentName, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();

        $itemList = $itemContainer->getItemList();

        $expr = new Comparison('segment', '=', $segmentName);
        $criteria = new Criteria();
        $criteria->where($expr);
        $matched = $itemList->matching($criteria);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($matched, 'json');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * Endpoint zwracający listę obiektów dla danego kraju
     * @param $countryName
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/get/country/{countryName}', name: 'getCountry', methods: ['GET', 'HEAD'])]
    public function getCountry ($countryName, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();

        $itemList = $itemContainer->getItemList();

        $expr = new Comparison('country', '=', $countryName);
        $criteria = new Criteria();
        $criteria->where($expr);
        $matched = $itemList->matching($criteria);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($matched, 'json');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * Endpoint zwracający listę obiektów dla danego produktu
     * @param $productName
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/get/product/{productName}', name: 'getProduct', methods: ['GET', 'HEAD'])]
    public function getProduct ($productName, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();

        $itemList = $itemContainer->getItemList();

        $expr = new Comparison('product', '=', $productName);
        $criteria = new Criteria();
        $criteria->where($expr);
        $matched = $itemList->matching($criteria);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($matched, 'json');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * Endpoint zwracający listę obiektów dla danego parametru (segment|country|product)
     * @param $param
     * @param $paramName
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/get/param/{param}/{paramName}', name: 'getUniversal', methods: ['GET', 'HEAD'])]
    public function getUniversal ($param, $paramName, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();

        $itemList = $itemContainer->getItemList();

        $expr = new Comparison($param, '=', $paramName);
        $criteria = new Criteria();
        $criteria->where($expr);
        $matched = $itemList->matching($criteria);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($matched, 'json');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * Endpoint zwracający sumę wartości Unit sold dla segmentu i kraju
     * @param $param
     * @param $paramName
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/sum/{segment}/{country}', name: 'getSumCountrySegment', methods: ['GET', 'HEAD'])]
    public function getSumCountrySegment ($segment, $country, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();
        $sumUnitSold = 0;
        $itemList = $itemContainer->getItemList();

        $exprSegment = new Comparison('segment', '=', $segment);
        $exprCountry = new Comparison('country', '=', $country);
        $criteria = new Criteria();
        $criteria->where($exprSegment);
        $criteria->andWhere($exprCountry);
        $matched = $itemList->matching($criteria);

        foreach ($matched as $element)
        {
            $sumUnitSold += $element->getUnitSold();
        }

        return $this->json([
            'segment' => $segment,
            'country' => $country,
            'sumUnitSold' => $sumUnitSold
        ]);
    }

    /**
     * Endpoint zapisujący do pliku excel segment, kraj, produkt i ilość
     * @param $segment
     * @param $country
     * @param $product
     * @param $unitSold
     * @param ItemContainer $itemContainer
     * @return Response
     */
    #[Route('/add/{segment}/{country}/{product}/{unitSold}', name: 'addItem', methods: ['GET', 'HEAD'])]
    public function addItem ($segment, $country, $product, $unitSold, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();
        $item = $itemContainer->addItem($segment, $country, $product, $unitSold);

        return $this->json([
            'segment' => $item->getSegment(),
            'country' => $item->getCountry(),
            'product' => $item->getProduct(),
            'unitSold' => $item->getUnitSold()
        ]);
    }

    /**
     * Endpoid kasujący z pliku excel wiersz o podanym numerze
     * @param $id
     * @param ItemContainer $itemContainer
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    #[Route('/delete/{id}', name: 'deleteItem', methods: ['GET', 'HEAD'])]
    public function deleteItem ($id, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();
        $item = $itemContainer->deleteItem($id);

        return $this->json([
            'segment' => $item->getSegment(),
            'country' => $item->getCountry(),
            'product' => $item->getProduct(),
            'unitSold' => $item->getUnitSold()
        ]);
    }


    #[Route('/find/{id}', name: 'findItem', methods: ['GET', 'HEAD'])]
    public function findItem ($id, ItemContainer $itemContainer): Response
    {
        $itemContainer->createItemCollection();
        $item = $itemContainer->findItem($id);

        return $this->json([
            'segment' => $item->getSegment(),
            'country' => $item->getCountry(),
            'product' => $item->getProduct(),
            'unitSold' => $item->getUnitSold()
        ]);
    }
}
