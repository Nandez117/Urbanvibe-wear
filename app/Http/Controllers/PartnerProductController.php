<?php

// Esteban Alvarez Garcia

namespace App\Http\Controllers;

use App\Services\PartnerApiService;
use Illuminate\View\View;

class PartnerProductController extends Controller
{
    private PartnerApiService $partnerService;

    public function __construct(PartnerApiService $partnerService)
    {
        $this->partnerService = $partnerService;
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
}
