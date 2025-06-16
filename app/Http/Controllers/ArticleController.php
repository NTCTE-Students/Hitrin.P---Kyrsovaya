<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    public function index(Request $request)
{
    $categoryId = $request->query('category_id');
    $articles = Cache::remember('articles_page_' . request()->page . '_' . $categoryId, 60, function () use ($categoryId) {
        $query = Article::with('categories')->latest();
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
        return $query->paginate(10);
    });

    $categories = Cache::remember('categories', 60, fn() => Category::all());

    // Проверяем текущий маршрут
    if ($request->route()->named('welcome')) {
        return view('welcome', compact('articles', 'categories'));
    }

    return view('articles.index', compact('articles', 'categories'));
}

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'categories' => 'array',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        $article->categories()->sync($request->categories);
        Cache::forget('articles_page_1');
        return redirect()->route('articles.index')->with('success', 'Статья создана!');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'categories' => 'array',
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $article->categories()->sync($request->categories);
        Cache::forget('articles_page_1');
        return redirect()->route('articles.index')->with('success', 'Статья обновлена!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        Cache::forget('articles_page_1');
        return redirect()->route('articles.index')->with('success', 'Статья удалена!');
    }

    public function search(Request $request)
    {
        $query = $request->query('q');
        $articles = Article::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->paginate(10);
        $categories = Category::all();
        return view('articles.index', compact('articles', 'categories'));
    }
}