<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flipkart Price Tracker')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            border: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }
        
        .form-control {
            border-radius: 15px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .price-tag {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }
        
        .product-image {
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .product-image:hover {
            transform: scale(1.05);
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
        }
        
        .container-fluid {
            padding: 30px;
        }
        
        .page-title {
            color: white;
            text-align: center;
            margin-bottom: 40px;
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .add-product-form {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 30px;
        }
        
        .product-card {
            position: relative;
            overflow: hidden;
        }
        
        .product-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        
        .last-updated {
            color: #666;
            font-size: 0.9rem;
        }
        
        .delete-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
                <i class="fas fa-chart-line me-2"></i>
                Flipkart Price Tracker
            </a>
        </div>
    </nav>

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

