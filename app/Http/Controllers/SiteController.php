<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! Stonebore will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return [
            'residential-wells' => [
                'title' => 'Residential Water Wells',
                'summary' => 'Domestic wells sized for rural homes and acreages across Northeast Oklahoma.',
                'body' => 'Stonebore surveys access, estimates target depth for local aquifers, and drills residential wells with proper casing, grout, and development. We finish with submersible pumps and pressure systems matched to household fixtures so you get steady pressure without short-cycling the pump.',
                'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1600&q=80',
            ],
            'agricultural-wells' => [
                'title' => 'Agricultural & Livestock Wells',
                'summary' => 'High-demand wells for cattle, horses, poultry barns, and farmstead supply.',
                'body' => 'Ranch and farm wells need yield you can count on through dry summers. We size casing and pumps for livestock troughs, washdown, and limited irrigation feed, then document static and pumping water levels so you know what the aquifer is delivering.',
                'image' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=1600&q=80',
            ],
            'commercial-wells' => [
                'title' => 'Commercial & Community Wells',
                'summary' => 'Groundwater systems for campuses, light industrial sites, and small community supply.',
                'body' => 'We phase commercial drilling around site logistics, coordinate with facility managers, and deliver as-built logs, pump curves, and service packets. Flow sensors and backup pump options keep critical operations online.',
                'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1600&q=80',
            ],
            'pump-systems' => [
                'title' => 'Pump Installation & Repair',
                'summary' => 'Submersibles, pressure tanks, controls, and emergency pull-and-replace service.',
                'body' => 'Stonebore installs and services submersible pumps, jet pumps, pressure tanks, and control panels. When a pump fails, we diagnose amperage draw, check valves, and tank pre-charge before recommending a repair or full replacement.',
                'image' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1600&q=80',
            ],
            'hydrofracturing' => [
                'title' => 'Hydrofracturing & Yield Enhancement',
                'summary' => 'Stimulate low-yield wells by opening fractures in tight rock formations.',
                'body' => 'When a well underperforms after development, hydrofracturing can improve yield in suitable rock. We evaluate geology, packer depths, and risk before recommending stimulation — then retest yield so you can see the before-and-after numbers.',
                'image' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1600&q=80',
            ],
            'water-testing' => [
                'title' => 'Water Quality Testing & Treatment',
                'summary' => 'Lab sampling for bacteria, minerals, and treatment recommendations.',
                'body' => 'New wells and older private systems deserve verified water quality. We collect samples for bacteria and common minerals, explain results in plain language, and recommend filtration or disinfection when treatment is warranted.',
                'image' => 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}
