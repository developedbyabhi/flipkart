<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\PriceHistory;
use App\Services\ScraperService;
use App\Mail\PriceDropNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check current prices for all tracked products and send notifications for price drops';

    protected $scraperService;

    public function __construct(ScraperService $scraperService)
    {
        parent::__construct();
        $this->scraperService = $scraperService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting price check for all products...');
        
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->info('No products to check.');
            return;
        }

        $checkedCount = 0;
        $notificationsSent = 0;

        foreach ($products as $product) {
            try {
                $this->info("Checking price for: {$product->name}");
                
                $scrapedData = $this->scraperService->scrape($product->flipkart_url);
                $newPrice = $scrapedData['price'];
                $oldPrice = $product->current_price;

                // Update product's current price
                $product->update([
                    'current_price' => $newPrice,
                    'name' => $scrapedData['title'], // Update name in case it changed
                    'image' => $scrapedData['image'], // Update image in case it changed
                ]);

                // Add new price history record
                $product->priceHistories()->create([
                    'price' => $newPrice,
                ]);

                $checkedCount++;

                // Check if price dropped
                if ($newPrice < $oldPrice) {
                    $this->info("Price drop detected! Old: ₹{$oldPrice}, New: ₹{$newPrice}");
                    
                    // Send email notification
                    $notificationEmail = env('NOTIFICATION_EMAIL');
                    if ($notificationEmail) {
                        Mail::to($notificationEmail)->send(
                            new PriceDropNotification($product, $oldPrice, $newPrice)
                        );
                        $notificationsSent++;
                        $this->info("Notification sent to {$notificationEmail}");
                    }
                } else {
                    $this->info("No price change detected. Current price: ₹{$newPrice}");
                }

            } catch (\Exception $e) {
                $this->error("Failed to check price for {$product->name}: " . $e->getMessage());
            }
        }

        $this->info("Price check completed!");
        $this->info("Products checked: {$checkedCount}");
        $this->info("Notifications sent: {$notificationsSent}");
    }
}
