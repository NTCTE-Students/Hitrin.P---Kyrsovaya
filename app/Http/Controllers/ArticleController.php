<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $query = Article::with('categories')->latest();
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
        $articles = $query->paginate(10);
        $categories = Category::all();

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
            'content' => 'required|string',
            'categories' => 'nullable|array|exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        if ($request->categories) {
            $article->categories()->sync($request->categories);
        }

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
            'content' => 'required|string',
            'categories' => 'nullable|array|exists:categories,id',
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->categories) {
            $article->categories()->sync($request->categories);
        }

        return redirect()->route('articles.index')->with('success', 'Статья обновлена!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Статья удалена!');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->query('q');
        $articles = Article::where('title', 'LIKE', "%{$searchQuery}%")
            ->orWhere('content', 'LIKE', "%{$searchQuery}%")
            ->paginate(10);
        $categories = Category::all();
        return view('articles.index', compact('articles', 'categories'));
    }
}
