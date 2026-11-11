<?php

// Esteban Alvarez Garcia

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Cart;
use App\Services\PartnerApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerProductController extends Controller
{
    private PartnerApiService $partnerService;

    private Cart $cart;

    public function __construct(PartnerApiService $partnerService, Cart $cart)
    {
        $this->partnerService = $partnerService;
        $this->cart = $cart;
    }

    public function index(): View
    {
        $result = $this->partnerService->getProducts();

        $viewData = [];
        $viewData['title'] = __('messages.partner_store_title');
        $viewData['partnerProducts'] = $result['products'];
        $viewData['partnerSource'] = $result['source'];
        $viewData['isFallback'] = $result['is_fallback'];

        return view('partner.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $product = $this->partnerService->getProduct($id);

        abort_if(! $product, 404, __('messages.partner_product_not_found'));

        $viewData = [];
        $viewData['title'] = $product['name'].' - '.__('messages.partner_store_title');
        $viewData['product'] = $product;

        return view('partner.show')->with('viewData', $viewData);
    }

    public function addToCart(Request $request, string $id): RedirectResponse
    {
        $partnerProduct = $this->partnerService->getProduct($id);

        if (! $partnerProduct) {
            return redirect()->route('partner.index')->with('error', __('messages.partner_product_not_found'));
        }

        $categoryName = $partnerProduct['category'] ?? __('messages.partner_default_category');
        $category = Category::firstOrCreate(['name' => $categoryName]);

        $product = Product::firstOrCreate(
            ['name' => $partnerProduct['name']],
            [
                'description' => $partnerProduct['description'] ?? __('messages.partner_default_description'),
                'price' => (float) ($partnerProduct['final_price'] ?? $partnerProduct['price']),
                'discount' => (float) ($partnerProduct['discount'] ?? 0),
                'size' => __('messages.partner_one_size'),
                'color' => __('messages.partner_default_value'),
                'material' => __('messages.partner_default_category'),
                'stock' => max(1, (int) ($partnerProduct['stock'] ?? 10)),
                'image' => $partnerProduct['image'] ?? 'products/default.png',
                'category_id' => $category->getId(),
            ]
        );

        $quantity = max(1, (int) $request->input('quantity', 1));
        $this->cart->addProduct($product->getId(), $quantity);

        return redirect()->route('cart.index')->with('success', __('messages.cart_add_success'));
    }
}
