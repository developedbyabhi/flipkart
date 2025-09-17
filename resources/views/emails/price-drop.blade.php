<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Drop Alert</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .product-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            border-left: 5px solid #667eea;
        }
        
        .product-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }
        
        .price-comparison {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 20px;
            background: linear-gradient(45deg, #e8f5e8, #f0f8f0);
            border-radius: 10px;
        }
        
        .old-price {
            text-decoration: line-through;
            color: #dc3545;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .new-price {
            color: #28a745;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .savings {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }
        
        .alert-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        @media (max-width: 600px) {
            .price-comparison {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="alert-icon">🎉</div>
            <h1>Price Drop Alert!</h1>
            <p>Great news! The price has dropped on a product you're tracking.</p>
        </div>
        
        <div class="content">
            <div class="product-info">
                <div class="product-name">{{ $product->name }}</div>
                
                <div class="price-comparison">
                    <div>
                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">Previous Price</div>
                        <div class="old-price">₹{{ number_format($oldPrice, 2) }}</div>
                    </div>
                    
                    <div style="font-size: 2rem; color: #667eea;">→</div>
                    
                    <div>
                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">New Price</div>
                        <div class="new-price">₹{{ number_format($newPrice, 2) }}</div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <div class="savings">
                        You Save: ₹{{ number_format($savings, 2) }}
                    </div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $product->flipkart_url }}" class="cta-button">
                    🛒 Buy Now on Flipkart
                </a>
            </div>
            
            <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border-left: 5px solid #ffc107;">
                <strong>💡 Pro Tip:</strong> Prices can change frequently. Don't wait too long if you're interested in this product!
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent by Flipkart Price Tracker because you're monitoring this product.</p>
            <p>Happy shopping! 🛍️</p>
        </div>
    </div>
</body>
</html>

