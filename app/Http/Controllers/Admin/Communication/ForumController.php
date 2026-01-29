<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumCategory;
use App\Models\ForumPoll;
use App\Models\ForumPollOption;
use App\Models\ForumPollVote;
use App\Models\ForumLike;
use App\Models\ForumPostView;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = ForumPost::latest()->paginate(10);
        return view('admin.communication.forum.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ForumCategory::where('is_active', true)->get();
        return view('admin.communication.forum.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
            'is_anonymous' => 'sometimes|boolean',
            'has_poll' => 'sometimes|boolean',
            'poll_question' => 'required_if:has_poll,true|nullable|string|max:255',
            'poll_options' => 'required_if:has_poll,true|array|min:2',
            'poll_options.*' => 'required_with:poll_options|string|max:255',
        ]);

        $post = new ForumPost([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);
        $post->user_id = auth()->id();
        $post->save();

        // Handle Poll Creation
        if ($request->boolean('has_poll')) {
            $poll = ForumPoll::create([
                'forum_post_id' => $post->id,
                'question' => $validated['poll_question'],
            ]);

            if (isset($validated['poll_options'])) {
                foreach ($validated['poll_options'] as $optionText) {
                    if (!empty($optionText)) {
                        ForumPollOption::create([
                            'forum_poll_id' => $poll->id,
                            'option_text' => $optionText,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('forum.index')->with('success', 'Discussion started successfully.');
    }

    public function vote(Request $request, $pollId)
    {
        $request->validate([
            'option_id' => 'required|exists:forum_poll_options,id',
        ]);

        $poll = ForumPoll::findOrFail($pollId);

        if ($poll->hasVoted(auth()->id())) {
            return back()->with('error', 'You have already voted in this poll.');
        }

        // Record Vote
        ForumPollVote::create([
            'forum_poll_id' => $poll->id,
            'forum_poll_option_id' => $request->option_id,
            'user_id' => auth()->id(),
        ]);

        // Increment Count
        $option = ForumPollOption::find($request->option_id);
        $option->increment('vote_count');

        return back()->with('success', 'Vote recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $forumPost = ForumPost::with(['user', 'category', 'comments.user', 'likes', 'poll.options'])->findOrFail($id);

        // Track unique view
        $viewExists = ForumPostView::where('forum_post_id', $forumPost->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$viewExists) {
            ForumPostView::create([
                'forum_post_id' => $forumPost->id,
                'user_id' => auth()->id(),
            ]);
            $forumPost->increment('view_count');
        }

        return view('admin.communication.forum.show', compact('forumPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumPost $forum)
    {
        if (auth()->id() !== $forum->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $categories = ForumCategory::where('is_active', true)->get();
        return view('admin.communication.forum.edit', compact('forum', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumPost $forum)
    {
        if (auth()->id() !== $forum->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
            'is_anonymous' => 'sometimes|boolean',
            'poll_question' => 'nullable|string|max:255',
            'has_poll' => 'sometimes|boolean',
            'poll_options' => 'required_with:has_poll|array|min:2',
            'poll_options.*' => 'required_with:poll_options|string|max:255',
        ]);

        $forum->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        // Handle Poll Update/Creation
        if ($forum->poll) {
            if (!empty($validated['poll_question'])) {
                $forum->poll->update(['question' => $validated['poll_question']]);
            }
        } elseif ($request->boolean('has_poll')) {
            $poll = ForumPoll::create([
                'forum_post_id' => $forum->id,
                'question' => $validated['poll_question'],
            ]);

            foreach ($validated['poll_options'] as $optionText) {
                if (!empty($optionText)) {
                    ForumPollOption::create([
                        'forum_poll_id' => $poll->id,
                        'option_text' => $optionText,
                    ]);
                }
            }
        }

        return redirect()->route('forum.show', $forum->id)->with('success', 'Discussion updated successfully.');
    }

    public function confirmDelete(ForumPost $forum)
    {
        if (auth()->id() !== $forum->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.communication.forum.delete_post', compact('forum'));
    }

    public function confirmDeleteComment($commentId)
    {
        $comment = ForumComment::with('post')->findOrFail($commentId);

        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.communication.forum.delete_comment', compact('comment'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumPost $forum)
    {
        if (auth()->id() !== $forum->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $forum->delete();
        return redirect()->route('forum.index')->with('success', 'Post deleted successfully.');
    }

    public function destroyComment($commentId)
    {
        $comment = ForumComment::findOrFail($commentId);

        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $postId = $comment->post_id;
        $comment->delete();
        return redirect()->route('forum.show', $postId)->with('success', 'Comment deleted successfully.');
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'is_anonymous' => 'sometimes|boolean',
        ]);

        $comment = new ForumComment();
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->is_anonymous = $request->boolean('is_anonymous');
        $comment->save();

        return back()->with('success', 'Comment posted successfully.');
    }

    public function toggleLike($postId)
    {
        $like = ForumLike::where('post_id', $postId)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Post unliked.';
        } else {
            ForumLike::create([
                'post_id' => $postId,
                'user_id' => auth()->id(),
            ]);
            $message = 'Post liked.';
        }

        return back()->with('success', $message);
    }
}
