<?php

namespace App\Acme\Controllers;

use App\Acme\Services\CategoryService;

class CategoryController extends ApiController
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth:api');
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->getCategories();
    }
}