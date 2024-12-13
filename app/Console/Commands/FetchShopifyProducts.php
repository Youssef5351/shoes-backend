<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ShopifyService;
class FetchShopifyProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-shopify-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $shopifyService = new ShopifyService();
        $success = $shopifyService->fetchProducts();
    
        if ($success) {
            $this->info('Shopify products fetched and updated successfully.');
        } else {
            $this->error('Failed to fetch products from Shopify.');
        }
    }
}
