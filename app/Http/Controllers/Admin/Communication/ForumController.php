<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
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
        $categories = \App\Models\ForumCategory::where('is_active', true)->get();
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

        $post = new ForumPost($validated);
        $post->user_id = auth()->id();
        $post->save();

        // Handle Poll Creation
        if ($request->has('has_poll') && $request->has_poll) {
            $poll = \App\Models\ForumPoll::create([
                'forum_post_id' => $post->id,
                'question' => $request->poll_question,
            ]);

            foreach ($request->poll_options as $optionText) {
                if (!empty($optionText)) {
                    \App\Models\ForumPollOption::create([
                        'forum_poll_id' => $poll->id,
                        'option_text' => $optionText,
                    ]);
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

        $poll = \App\Models\ForumPoll::findOrFail($pollId);

        if ($poll->hasVoted(auth()->id())) {
            return back()->with('error', 'You have already voted in this poll.');
        }

        // Record Vote
        \App\Models\ForumPollVote::create([
            'forum_poll_id' => $poll->id,
            'forum_poll_option_id' => $request->option_id,
            'user_id' => auth()->id(),
        ]);

        // Increment Count
        $option = \App\Models\ForumPollOption::find($request->option_id);
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
        $forumPost = ForumPost::with(['user', 'category', 'comments.user', 'likes'])->findOrFail($id);

        // Count views
        $forumPost->increment('view_count');

        return view('admin.communication.forum.show', compact('forumPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ForumPost $forumPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ForumPost $forumPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ForumPost $forumPost)
    {
        //
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'is_anonymous' => 'sometimes|boolean',
        ]);

        $comment = new \App\Models\ForumComment();
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $comment->is_anonymous = $request->has('is_anonymous');
        $comment->save();

        return back()->with('success', 'Comment posted successfully.');
    }

    public function toggleLike($postId)
    {
        $like = \App\Models\ForumLike::where('post_id', $postId)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Post unliked.';
        } else {
            \App\Models\ForumLike::create([
                'post_id' => $postId,
                'user_id' => auth()->id(),
            ]);
            $message = 'Post liked.';
        }

        return back()->with('success', $message);
    }
}
