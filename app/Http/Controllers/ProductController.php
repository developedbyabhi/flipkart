<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PriceHistory;
use App\Services\ScraperService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $scraperService;

    public function __construct(ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function index()
    {
        $products = Product::with('priceHistories')->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flipkart_url' => 'required|url|unique:products',
        ]);

        try {
            $scrapedData = $this->scraperService->scrape($request->flipkart_url);

            $product = Product::create([
                'flipkart_url'   => $request->flipkart_url,
                'name'           => $scrapedData['title'],
                'image'          => $scrapedData['image'],
                'current_price'  => $scrapedData['price'],
            ]);

            $product->priceHistories()->create([
                'price' => $scrapedData['price'],
            ]);

            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
