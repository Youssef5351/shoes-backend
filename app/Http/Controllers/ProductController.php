<?php

// namespace App\Http\Controllers;

// use App\Models\Product;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

// class ProductController extends Controller
// {
//     // Fetch all products
//     public function index()
//     {
//         $products = Product::where('is_featured', false)->get();
//         return response()->json($products);
//     }

//     public function getFeaturedProducts()
//     {
//         $featuredProducts = Product::where('is_featured', true)->get();
//         return response()->json($featuredProducts);
//     }

//     public function setFeaturedProduct(Request $request, Product $product)
//     {
//         $product->is_featured = $request->is_featured;
//         $product->save();
//         return response()->json($product);
//     }

//     public function update(Request $request, $id)
//     {
//         // Log the incoming request data for debugging
//         \Log::info('Updating product with ID: ' . $id);
//         \Log::info('Request Data: ', $request->all());
    
//         // Validate the incoming request data
//         $validatedData = $request->validate([
//             'name' => 'sometimes|string|max:255',
//             'price' => 'sometimes|numeric|min:0',
//             'description' => 'sometimes|string',
//             'image_url' => 'sometimes|url',
//             'stock_quantity' => 'sometimes|integer|min:0',
//             'category_id' => 'sometimes|integer|exists:categories,id',
//             'brand' => 'sometimes|string',
//             'fragrance_family' => 'sometimes|string',
//             'lemon_squeezy_product_id' => 'sometimes|string' 
//         ]);
    
//         try {
//             // Find the product by ID or fail if not found
//             $product = Product::findOrFail($id);
    
//             // Update the product with validated data
//             $product->update($validatedData);
    
//             // Return the updated product in the response
//             return response()->json($product, 200);
//         } catch (\Exception $e) {
//             // Log any errors that occur
//             \Log::error('Error updating product: ' . $e->getMessage());
    
//             // Return a 500 error response
//             return response()->json(['error' => 'An error occurred while updating the product.'], 500);
//         }
//     }    

//     public function show($id)
// {
//     // Find the product by its ID
//     $product = Product::find($id);

//     // If the product doesn't exist, return a 404 error
//     if (!$product) {
//         return response()->json(['message' => 'Product not found'], 404);
//     }

//     // Return the product as JSON
//     return response()->json($product);
// }

    
// }

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Services\ShopifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    public function getShopifyProducts(): JsonResponse
    {
        try {
            $shopDomain = env('SHOPIFY_SHOP_DOMAIN'); // Shopify store domain
            $accessToken = env('SHOPIFY_ACCESS_TOKEN'); // Shopify access token
    
            // Shopify Admin API URL
            $apiUrl = "https://{$shopDomain}/admin/api/2024-10/products.json";
    
            // Make an API call to Shopify with correct headers
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken,
            ])->get($apiUrl);
    
            // Check if the response is successful
            if ($response->successful()) {
                $products = $response->json()['products']; // Get products from the response
    
                // Filter products that have no tags
                $productsWithNoTags = array_filter($products, function ($product) {
                    // Check if the product has no tags (empty string or null)
                    return empty($product['tags']) || $product['tags'] === null;
                });
    
                Log::info('Found ' . count($productsWithNoTags) . ' products with no tags from Shopify');
                
                // Return the filtered products with no tags
                return response()->json(array_values($productsWithNoTags), 200);
            } else {
                // Log error details if the API call is not successful
                Log::error('Shopify API error: ' . $response->body());
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to fetch products from Shopify',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log exception details
            Log::error('Exception occurred: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching products.',
            ], 500);
        }
    }
    
    public function getFeaturedProducts(): JsonResponse
    {
        try {
            Log::info('Starting featured products fetch from Shopify');
            
            // Shopify store credentials
            $shopDomain = env('SHOPIFY_SHOP_DOMAIN'); // Your Shopify store domain (e.g., 'your-shop-name.myshopify.com')
            $accessToken = env('SHOPIFY_ACCESS_TOKEN'); // Your Shopify store access token
            
            // Shopify Admin API URL for fetching products
            $apiUrl = "https://{$shopDomain}/admin/api/2024-10/products.json";
            
            // Make an API call to Shopify to fetch all products
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken,
            ])->get($apiUrl);
            
            // Check if the response is successful
            if ($response->successful()) {
                $products = $response->json()['products']; // Get products from the response
                
                // Filter products based on the 'featured' tag
                $featuredProducts = array_filter($products, function ($product) {
                    // Check if 'featured' is part of the tags string (convert tags to an array first)
                    $tags = explode(',', $product['tags']);
                    return in_array('featured', array_map('trim', $tags)); // 'featured' should match a tag after trimming spaces
                });
                
                Log::info('Found ' . count($featuredProducts) . ' featured products from Shopify');
                
                // Return the filtered featured products
                return response()->json(array_values($featuredProducts), 200);
            } else {
                // Log error details if the API call is not successful
                Log::error('Shopify API error: ' . $response->body());
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to fetch featured products from Shopify',
                ], 500);
            }
        } catch (\Exception $e) {
            // Log exception details
            Log::error('Exception occurred while fetching featured products: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching featured products.',
            ], 500);
        }
    }
    
    public function getShopifyProductDetails($id): JsonResponse
    {
        try {
            $shopDomain = env('SHOPIFY_SHOP_DOMAIN'); // Shopify store domain
            $accessToken = env('SHOPIFY_ACCESS_TOKEN'); // Shopify access token
    
            // Shopify Admin API URL for a specific product
            $apiUrl = "https://{$shopDomain}/admin/api/2024-10/products/{$id}.json";
    
            // Make an API call to Shopify with correct headers
            $response = Http::withHeaders([
                'X-Shopify-Access-Token' => $accessToken, // Ensure this is passed correctly
            ])->get($apiUrl);

            // Check if the response is successful
            if ($response->successful()) {
                $product = $response->json()['product']; // Assuming 'product' is the key in the response
                return response()->json($product, 200);
            } else {
                // Log error details
                Log::error('Shopify API error: ' . $response->body());
                return response()->json([
                    'error' => true,
                    'message' => 'Failed to fetch product details from Shopify. Status: ' . $response->status(),
                ], 500);
            }
        } catch (\Exception $e) {
            // Log exception details
            Log::error('Exception occurred while fetching Shopify product details: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while fetching product details.',
            ], 500);
        }
    }
}