<?php
   namespace App\Http\Controllers;

   use App\Models\Category;
   use Illuminate\Http\Request;

   class CategoryController extends Controller
   {
       public function index()
       {
           $categories = Category::all();
           return view('categories.index', compact('categories'));
       }

       public function create()
       {
           return view('categories.create');
       }

       public function store(Request $request)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'description' => 'nullable|string',
           ]);

           Category::create($request->all());
           return redirect()->route('categories.index')->with('success', 'Категория создана!');
       }

       public function show(Category $category)
       {
           $articles = $category->articles()->paginate(10);
           return view('categories.show', compact('category', 'articles'));
       }

       public function edit(Category $category)
       {
           return view('categories.edit', compact('category'));
       }

       public function update(Request $request, Category $category)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'description' => 'nullable|string',
           ]);

           $category->update($request->all());
           return redirect()->route('categories.index')->with('success', 'Категория обновлена!');
       }

       public function destroy(Category $category)
       {
           $category->delete();
           return redirect()->route('categories.index')->with('success', 'Категория удалена!');
       }
   }