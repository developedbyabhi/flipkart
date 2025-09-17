@extends('layouts.app')

@section('title', 'Product Dashboard - Flipkart Price Tracker')

@section('content')
<h1 class="page-title">
    <i class="fas fa-shopping-cart me-3"></i>
    Product Price Dashboard
</h1>

<!-- Add Product Form -->
<div class="add-product-form">
    <h3 class="text-white mb-4">
        <i class="fas fa-plus-circle me-2"></i>
        Add New Product
    </h3>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-10">
                <input type="url" 
                       name="flipkart_url" 
                       class="form-control" 
                       placeholder="Enter Flipkart product URL..." 
                       required>
                @error('flipkart_url')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-plus me-2"></i>
                    Add Product
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="product-grid">
        @foreach($products as $product)
            <div class="card product-card">
                <div class="card-body">
                    <!-- Delete Button -->
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger delete-btn"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                    <!-- Product Header -->
                    <div class="product-header">
                        @if($product->image)
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center product-image"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="product-info">
                            <h5 class="product-name">{{ Str::limit($product->name, 50) }}</h5>
                            <div class="price-tag">
                                <i class="fas fa-rupee-sign me-1"></i>
                                {{ number_format($product->current_price, 2) }}
                            </div>
                            <div class="last-updated mt-2">
                                <i class="fas fa-clock me-1"></i>
                                Last updated: {{ $product->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- Price History Chart -->
                    @if($product->priceHistories->count() > 1)
                        <div class="chart-container">
                            <canvas id="chart-{{ $product->id }}"></canvas>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <p>Price history will appear after multiple price checks</p>
                        </div>
                    @endif

                    <!-- Product Link -->
                    <div class="mt-3">
                        <a href="{{ $product->flipkart_url }}" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>
                            View on Flipkart
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="card" style="max-width: 500px; margin: 0 auto;">
            <div class="card-body py-5">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">No Products Added Yet</h3>
                <p class="text-muted">Start tracking prices by adding your first Flipkart product URL above.</p>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($products as $product)
        @if($product->priceHistories->count() > 1)
            const ctx{{ $product->id }} = document.getElementById('chart-{{ $product->id }}').getContext('2d');
            
            const priceData{{ $product->id }} = {
                labels: [
                    @foreach($product->priceHistories as $history)
                        '{{ $history->created_at->format("M d, H:i") }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Price (₹)',
                    data: [
                        @foreach($product->priceHistories as $history)
                            {{ $history->price }},
                        @endforeach
                    ],
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            };

            new Chart(ctx{{ $product->id }}, {
                type: 'line',
                data: priceData{{ $product->id }},
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBackgroundColor: 'rgb(102, 126, 234)',
                            hoverBorderColor: '#fff'
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        @endif
    @endforeach
});
</script>
@endsection

