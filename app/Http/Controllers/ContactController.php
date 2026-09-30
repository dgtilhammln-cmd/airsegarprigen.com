<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\WaSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllAsArray();
        $wa       = WaSetting::primary();

        $seo = [
            'title'       => $settings['meta_title_contact'] ?? 'Hubungi Kami | CV. Bintang Energy Surabaya - Spesialis Cat Industri',
            'description' => $settings['meta_desc_contact'] ?? 'Hubungi CV. Bintang Energy Surabaya untuk konsultasi dan pemasangan Cat Industri & Sistem Ventilasi. Respon cepat, survei gratis, dan garansi resmi pabrik.',
            'keywords'    => $settings['meta_keywords_contact'] ?? 'kontak ptbiner, hubungi ptbiner, pasang cat industri',
            'og_image'    => !empty($settings['og_image_default']) ? asset('storage/'.$settings['og_image_default']) : (!empty($settings['logo']) ? asset('storage/'.$settings['logo']) : asset('images/og-default.jpg')),
            'canonical'   => route('contact'),
        ];

        $faq = [
            ['q' => 'Di mana lokasi utama CV. Bintang Energy Surabaya?', 'a' => 'Kami berlokasi di Surabaya, namun melayani pengiriman dan pemasangan Cat Industri ke seluruh wilayah Indonesia.'],
            ['q' => 'Apakah konsultasi ventilasi gratis?', 'a' => 'Ya, kami menyediakan konsultasi gratis. Tim ahli kami akan membantu menghitung kebutuhan sirkulasi udara untuk bangunan Anda.'],
            ['q' => 'Apakah ada layanan survei lokasi?', 'a' => 'Ya, kami melayani survei lokasi secara langsung untuk menentukan jumlah dan tipe ventilator yang paling optimal untuk bangunan Anda.'],
            ['q' => 'Berapa lama proses pemasangan ventilator?', 'a' => 'Proses instalasi sangat bergantung pada jumlah unit dan tingkat kesulitan atap. Namun, tim teknisi kami sangat berpengalaman untuk menyelesaikan dengan cepat dan rapi.'],
        ];

        $schema = json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'FAQPage',
            'mainEntity' => collect($faq)->map(fn($f) => [
                '@type'          => 'Question',
                'name'           => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ])->toArray(),
        ]);

        return view('contact.index', compact('settings', 'wa', 'seo', 'faq', 'schema'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|min:2|max:100',
            'company'   => 'nullable|max:100',
            'email'     => 'required|email|max:100',
            'phone'     => 'required|min:8|max:20',
            'product'   => 'nullable|max:100',
            'message'   => 'required|min:10|max:2000',
        ]);

        // Log to database (analytics)
        \App\Models\AnalyticsEvent::record('contact_form', route('contact'), [
            'page_title' => 'Contact Form - ' . $validated['name'],
        ]);

        return back()->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan menghubungi Anda segera. Atau langsung chat via WhatsApp untuk respon lebih cepat.');
    }
}
