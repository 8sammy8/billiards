<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Models\Category;
use App\Domain\Products\Models\Product;
use App\Domain\Products\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Services\ProductImageService;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function productsList()
    {
        $model = Product::with('category');

        return datatables($model)
            ->addColumn('category',  function(Product $product) {
                return $product->category->name;
            })
            ->editColumn('status',  function(Product $product) {
                return trans_choice('admin.product_status', $product->status);
            })
            ->editColumn('img',  function(Product $product) {
                return view('admin.products.datatable._image', compact('product'));
            })
            ->addColumn('actions',  function(Product $product) {
                return view('admin.products.datatable._actions', compact('product'));
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function index()
    {
        if(request()->ajax()){
            return $this->productsList();
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $categories = Category::all();
        if($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('info', 'Please, First create Category');
        }

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request, Product $product)
    {
        if (request()->has('img')) {
            $imageService = new ProductImageService($product);
            $imageService->upload(request()->file('img'));
        }

        $this->fill($request, $product)->save();

        return redirect()->route('admin.products.index')->with('success', 'Product added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        if (request()->has('img')) {
            $imageService = new ProductImageService($product);
            $file = request()->file('img');
            $product->img ?  $imageService->reUpload($file) : $imageService->upload($file);
        }

        $this->fill($request, $product)->update();

        return redirect()->route('admin.products.index')->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        if($product->img){
            $imageService = new ProductImageService($product);
            $imageService->remove();
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function imageDelete(int $id)
    {
        $product = Product::findOrFail($id);

        $imageService = new ProductImageService($product);
        $imageService->remove();

        $product::withoutEvents(function () use($product){
            $product->img = '';
            return $product->update();
        });

        return response()->noContent();
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return Product
     */
    protected function fill(ProductRequest $request, Product $product) :Product
    {
        $product->name            = $request->get('name');
        $product->code            = $request->get('code');
        //$product->unit          = $request->get('unit');
        $product->price           = $request->get('price');
        $product->purchase_price  = $request->get('purchase_price');
        $product->remainder       = $request->get('remainder');
        $product->status          = $request->get('status', Product::PRODUCT_STATUS_HIDE);
        $product->category_id     = $request->get('category_id');

        return $product;
    }
}
