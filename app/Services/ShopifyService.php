<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyService
{
    protected $shopDomain;
    protected $accessToken;

    public function __construct()
    {
        $this->shopDomain = env('SHOPIFY_SHOP_DOMAIN');
        $this->accessToken = env('SHOPIFY_ACCESS_TOKEN');
    }

    public function fetchProducts()
    {
        try {
            $url = "https://{$this->shopDomain}/admin/api/2023-07/products.json";
            
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $this->accessToken,
            ])->get($url);

            if ($response->failed()) {
                Log::error('Failed to fetch products from Shopify: ' . $response->body());
                return false;
            }

            $shopifyProducts = $response->json('products');
            
            foreach ($shopifyProducts as $shopifyProduct) {
                Product::updateOrCreate(
                    ['shopify_id' => $shopifyProduct['id']],
                    [
                        'title' => $shopifyProduct['title'],
                        'description' => $shopifyProduct['body_html'],
                        'price' => $shopifyProduct['variants'][0]['price'] ?? 0,
                        'image' => $shopifyProduct['images'][0]['src'] ?? null,
                        'is_featured' => false,
                    ]
                );
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Error in ShopifyService@fetchProducts: ' . $e->getMessage());
            return false;
        }
    }
}
