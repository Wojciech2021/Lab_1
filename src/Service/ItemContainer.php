<?php

namespace App\Service;

use App\Service\Item;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\Common\Collections\ArrayCollection;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class ItemContainer
{

    private ArrayCollection $itemList;

    public function __construct ()
    {
        $this->itemList = new ArrayCollection();
    }

    /**
     * Metoda tworząca kolekcję obiektów Item i wypełniająca go danymi z pliku excel
     * @return void
     */
    public function createItemCollection()
    {
        $spreadSheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $spreadSheet->load("sample-xlsx-file-for-testing.xlsx");
        $spreadSheetData = $spreadSheet->getActiveSheet()->toArray(null,true,false,true);

        foreach ($spreadSheetData as $key=>$row)
        {

            if($key !=1) {
                $segment = $row['A'];
                $country = $row['B'];
                $product = $row['C'];
                $unitSold =  $row['E'];
                $item = new Item();
                $item->setSegment($segment);
                $item->setCountry($country);
                $item->setProduct($product);
                $item->setUnitSold($unitSold);
                $this->add($item);
            }
        }
    }

    /**
     * Metoda dodająca kolejny obiekt typu item
     * @param \App\Service\Item $item
     * @return void
     */
    public function add (Item $item)
    {
        $this->itemList->add($item);
    }

    /**
     * Metoda zapisująca do pliku excel segment, kraj, produkt i ilość
     * @param string $segment
     * @param string $country
     * @param string $product
     * @param float $unitSold
     * @return \App\Service\Item
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function addItem (string $segment, string $country, string $product, float $unitSold)
    {
        $spreadSheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $spreadSheet->load("sample-xlsx-file-for-testing.xlsx");
        $sheet = $spreadSheet->getActiveSheet();
        $row = $sheet->getHighestRow() + 1;
        $sheet->setCellValue('A'.$row, $segment);
        $sheet->setCellValue('B'.$row, $country);
        $sheet->setCellValue('C'.$row, $product);
        $sheet->setCellValue('E'.$row, $unitSold);
        $item = new Item();
        $item->setSegment($segment);
        $item->setCountry($country);
        $item->setProduct($product);
        $item->setUnitSold($unitSold);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadSheet);
        $writer->save('sample-xlsx-file-for-testing.xlsx');

        return $item;
    }

    /**
     * Metoda kasująca wiersz o podanym numerze z pliku
     * @param int $id
     * @return \App\Service\Item
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function deleteItem (int $id)
    {
        $spreadSheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $spreadSheet->load("sample-xlsx-file-for-testing.xlsx");
        $sheet = $spreadSheet->getActiveSheet();
        $item = new Item();
        $item->setSegment($sheet->getCell('A'.$id)->getValue());
        $item->setCountry($sheet->getCell('B'.$id)->getValue());
        $item->setProduct($sheet->getCell('C'.$id)->getValue());
        $item->setUnitSold($sheet->getCell('E'.$id)->getValue());
        $sheet->removeRow($id);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadSheet);
        $writer->save('sample-xlsx-file-for-testing.xlsx');

        return $item;
    }

    /**
     * Metoda zwracająca wiersz o podanym numerze z pliku
     * @param int $id
     * @return \App\Service\Item
     */
    public function findItem (int $id)
    {
        $spreadSheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadSheet = $spreadSheet->load("sample-xlsx-file-for-testing.xlsx");
        $sheet = $spreadSheet->getActiveSheet();
        $item = new Item();
        $item->setSegment($sheet->getCell('A'.$id)->getValue());
        $item->setCountry($sheet->getCell('B'.$id)->getValue());
        $item->setProduct($sheet->getCell('C'.$id)->getValue());
        $item->setUnitSold($sheet->getCell('E'.$id)->getValue());

        return $item;
    }



    /**
     * Zwraca całą kolekcję
     * @return ArrayCollection
     */
    public function getItemList(): ArrayCollection
    {
        return $this->itemList;
    }

    /**
     * @param ArrayCollection $itemList
     */
    public function setItemList(ArrayCollection $itemList): void
    {
        $this->itemList = $itemList;
    }
}