<?php

declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna\Message;

use Money\Money;
use Dalholm\Omnipay\Klarna\ItemBag;

trait ItemDataTrait
{
    /**
     * @param ItemBag $items
     *
     * @return array[]
     */
    public function getItemData(ItemBag $items): array
    {
        $orderLines = [];

        foreach ($items as $item) {
            $totalAmount = ($item->getQuantity() * $item->getPrice()) - $item->getTotalDiscountAmount();
            $orderLines[] = [
                'type' => $item->getType(),
                'reference' => $item->getReference(),
                'name' => $item->getName(),
                'image_url' => $item->getImageUrl(),
                'quantity' => $item->getQuantity(),
                'tax_rate' => (int) $item->getTaxRate(),
                'total_amount' => (int) $totalAmount,
                'total_tax_amount' => (int) $item->getTotalTaxAmount(),
                'total_discount_amount' => (int) $item->getTotalDiscountAmount(),
                'unit_price' => (int) $item->getPrice(),
                'merchant_data' => $item->getMerchantData(),
            ];
        }
        return $orderLines;
    }

    abstract protected function convertToMoney($amount): Money;
}
