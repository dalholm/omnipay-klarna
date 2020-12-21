<?php
declare(strict_types=1);

namespace Dalholm\Omnipay\Klarna;

/**
 * @final
 *
 * @method ItemInterface[] getIterator()
 */
class ItemBag extends \Omnipay\Common\ItemBag
{
    /**
     * @inheritDoc
     */
    public function add($item)
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new Item($item);
        }
    }
}
