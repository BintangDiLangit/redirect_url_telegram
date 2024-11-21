<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RedirectUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class RedirectUrlClickbait extends Controller
{
    public function index()
    {
        try {
            $redirectClickbait = RedirectUrl::where('type', 'CB')->latest()->paginate(10);
            return view('admin.redirect-clickbait', compact('redirectClickbait'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading short URLs.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'nullable|unique:redirect_urls,code',
                'url' => 'required|url',
                'title' => 'nullable|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $code = $request->code;

            // Generate unique code
            if (!$request->code) {
                do {
                    $code = Str::random(6);
                } while (RedirectUrl::where('code', $code)->exists());
            }

            $redirectUrl = new RedirectUrl();
            $redirectUrl->url = $validated['url'];
            $redirectUrl->code = $code;
            $redirectUrl->title = $validated['title'];
            $redirectUrl->type = 'CB';
            $redirectUrl->status = $validated['status'];

            if ($request->hasFile('banner_image')) {
                $filename = uniqid() . '.' . $request->file('banner_image')->getClientOriginalExtension();
                $path = $request->file('banner_image')->storeAs('redirectClickbait', $filename, 'public');
                $redirectUrl->banner_image = $path;
            }

            $redirectUrl->save();

            return redirect()->route('admin.redirect-clickbait.index')
                ->with('success', 'Short URL created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating short URL.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $url = RedirectUrl::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $url->id,
                    'code' => $url->code,
                    'url' => $url->url,
                    'status' => $url->status,
                    'banner_image' => $url->banner_image ? asset($url->banner_image) : null,
                    'hits' => $url->hits
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error loading redirect URL data'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|unique:redirect_urls,code,' . $id,
                'url' => 'required|url',
                'title' => 'nullable|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:active,inactive',
            ]);


            $redirectUrl = RedirectUrl::findOrFail($id);

            $redirectUrl->url = $validated['url'];
            $redirectUrl->status = $validated['status'];
            $redirectUrl->type = 'CB';
            $redirectUrl->title = $validated['title'];
            $redirectUrl->code = $validated['code'];

            if ($request->hasFile('banner_image')) {
                // Delete old image if exists
                if ($redirectUrl->banner_image) {
                    Storage::delete(str_replace('/storage/', 'public/', $redirectUrl->banner_image));
                }

                $path = $request->file('banner_image')->store('short-urls');
                $redirectUrl->banner_image = Storage::url($path);
            }
            if ($request->hasFile('banner_image')) {
                if ($redirectUrl->banner_image) {
                    Storage::disk('public')->delete($redirectUrl->banner_image);
                }
                $filename = uniqid() . '.' . $request->file('banner_image')->getClientOriginalExtension();

                $path = $request->file('banner_image')->storeAs('redirectClickbait', $filename, 'public');
                $redirectUrl->banner_image = $path;
            }

            $redirectUrl->save();

            return redirect()->route('admin.redirect-clickbait.index')
                ->with('success', 'Short URL updated successfully.');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating short URL.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $redirectUrl = RedirectUrl::findOrFail($id);
            if ($redirectUrl->banner_image) {
                Storage::disk('public')->delete($redirectUrl->banner_image);
            }

            $redirectUrl->delete();

            return redirect()->route('admin.redirect-clickbait.index')
                ->with('success', 'Short URL deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting short URL.');
        }
    }

    public function redirect($code)
    {
        $redirectUrl = RedirectUrl::where('code', $code)->firstOrFail();

        if (!$redirectUrl->isActive()) {
            abort(404);
        }

        $redirectUrl->incrementHits();

        return redirect($redirectUrl->url);
    }
}
