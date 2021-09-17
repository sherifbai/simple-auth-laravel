<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try{
            $products = Product::all();

            return response()->json([
                'data' => $products,
                'success' => true
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try{
            $product = Product::query()->create($request->all());

            return response()->json([
                'data' => $product,
                'success' => true
            ]);
        }catch (Throwable $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        try{
            $product = Product::query()->findOrFail($id);

            return response()->json([
                'data' => $product,
                'success' => true
            ]);
        }catch (Throwable $error) {
           return response()->json([
               'data' => null,
               'success' => false,
               'message' => $error->getMessage()
           ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $product = Product::query()->findOrFail($id);
            $product->update($request->all());

            return response()->json([
                'data' => $product,
                'success' => true
            ]);

        } catch (Throwable $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $product = Product::query()->findOrFail($id);
            $product->destroy($id);

            return response()->json([
                'data' => null,
                'success' => true
            ]);
        } catch (Throwable  $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $name
     * @return JsonResponse
     */
    public function search(string $name): JsonResponse
    {
        try {
            $products = Product::query()->where('name', 'like', '%'.$name.'%')->get();

            return response()->json([
                'data' => $products,
                'success' => true
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $error->getMessage()
            ]);
        }
    }
}
