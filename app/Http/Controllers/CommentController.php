<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|min:5|max:1000',
        ]);

        Comment::create([
            'article_id' => $article->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('articles.show', $article)->with('success', 'Комментарий добавлен!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $article = $comment->article;
        $comment->delete();

        return redirect()->route('articles.show', $article)->with('success', 'Комментарий удалён!');
    }
}