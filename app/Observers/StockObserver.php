<?php

namespace App\Observers;

use App\Models\Stock;
use App\Service\CategoryService;
use App\Notifications\StockNotification;

class StockObserver
{


    protected $stockNotification;
    protected $categoryService;

    public function __construct(StockNotification $stockNotification, CategoryService $categoryService)
    {
        $this->stockNotification = $stockNotification;
        $this->categoryService = $categoryService;
    }

    /**
     * Handle the Stock "created" event.
     */
    public function created(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "updated" event.
     */
    public function updated(Stock $stock): void
    {
        if ($stock->stock <= 5) {
            $product_name = $stock->product_name;
            $product_stock = $stock->stock;
            $category_id = $stock->category_id;
            $category_name = $this->categoryService->findById($category_id);
            $stock->notify(new StockNotification($product_stock, $product_name, $category_name));
        }
    }

    /**
     * Handle the Stock "deleted" event.
     */
    public function deleted(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "restored" event.
     */
    public function restored(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "force deleted" event.
     */
    public function forceDeleted(Stock $stock): void
    {
        //
    }
}
