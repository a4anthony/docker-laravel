<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Categories\CategoryRepositoryInterface;

class CategoriesController extends Controller
{
    protected $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        dd('sjnfjnfd');
    }
}
