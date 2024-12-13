<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function createCheckout(Request $request)
    {
        try {
            $shopDomain = env('SHOPIFY_SHOP_DOMAIN');
            $storefrontToken = env('SHOPIFY_ACCESS_TOKEN');
    
            if (!$shopDomain || !$storefrontToken) {
                Log::error('Missing Shopify credentials', [
                    'shopDomain' => $shopDomain,
                    'storefrontToken' => $storefrontToken,
                ]);
                return response()->json(['error' => 'Shopify credentials missing'], 500);
            }
    
            $response = Http::withHeaders([
                'X-Shopify-Storefront-Access-Token' => $storefrontToken,
                'Content-Type' => 'application/json',
            ])->post("https://{$shopDomain}/api/2024-01/graphql.json", [
                'query' => '
                    mutation checkoutCreate($input: CheckoutCreateInput!) {
                        checkoutCreate(input: $input) {
                            checkout {
                                id
                                webUrl
                            }
                            checkoutUserErrors {
                                code
                                field
                                message
                            }
                        }
                    }
                ',
                'variables' => [
                    'input' => [
                        'lineItems' => array_map(function ($item) {
                            return [
                                'variantId' => 'gid://shopify/ProductVariant/' . $item['variant_id'],
                                'quantity' => $item['quantity']
                            ];
                        }, $request->input('cartItems', []))
                    ]
                ]
            ]);
    
            if (!$response->successful()) {
                Log::error('Shopify API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return response()->json(['error' => 'Failed to create checkout'], 400);
            }
    
            $responseData = $response->json();
    
            if (isset($responseData['data']['checkoutCreate']['checkout']['webUrl'])) {
                return response()->json([
                    'error' => false,
                    'checkout_url' => $responseData['data']['checkoutCreate']['checkout']['webUrl']
                ]);
            } else {
                Log::error('No checkout URL in response', ['response' => $responseData]);
                return response()->json(['error' => 'No checkout URL in response'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Checkout Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }    
}