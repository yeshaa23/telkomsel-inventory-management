<?php

use App\Models\Product;

uses(Tests\TestCase::class);

test('product status is out of stock when stock is zero', function () {
    $product = new Product([
        'stock' => 0,
        'condition' => 'Baik',
    ]);

    expect($product->stock_status)->toBe('out_of_stock');
    expect($product->stock_status_label)->toBe('Out of Stock');
});

test('product status is low stock when stock is between one and five', function () {
    $product = new Product([
        'stock' => 3,
        'condition' => 'Baik',
    ]);

    expect($product->stock_status)->toBe('low_stock');
    expect($product->stock_status_label)->toBe('Low Stock');
});

test('product status is damaged when stock is enough but condition is not good', function () {
    $product = new Product([
        'stock' => 10,
        'condition' => 'Rusak Ringan',
    ]);

    expect($product->stock_status)->toBe('damaged');
    expect($product->stock_status_label)->toBe('Needs Attention');
});

test('product status is available when stock is enough and condition is good', function () {
    $product = new Product([
        'stock' => 10,
        'condition' => 'Baik',
    ]);

    expect($product->stock_status)->toBe('available');
    expect($product->stock_status_label)->toBe('Available');
});
