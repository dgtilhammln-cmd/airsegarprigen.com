<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updates all phone and WhatsApp settings to 08989999899 / 628989999899.
     */
    public function up(): void
    {
        $waNum = '628989999899';
        $phoneNum = '08989999899';

        // Update settings table
        $waKeys = ['whatsapp', 'footer_wa', 'wa', 'wa1', 'contact_wa', 'phone_wa'];
        foreach ($waKeys as $k) {
            DB::table('settings')->updateOrInsert(
                ['key' => $k],
                ['value' => $waNum, 'type' => 'text', 'group' => 'contact', 'label' => 'WhatsApp']
            );
        }

        $phoneKeys = ['phone', 'footer_phone', 'telephone'];
        foreach ($phoneKeys as $pk) {
            DB::table('settings')->updateOrInsert(
                ['key' => $pk],
                ['value' => $phoneNum, 'type' => 'text', 'group' => 'contact', 'label' => 'Telepon']
            );
        }

        // Update wa_settings table
        if (\Illuminate\Support\Facades\Schema::hasTable('wa_settings')) {
            DB::table('wa_settings')->update(['nomor_wa' => $waNum]);
        }

        Cache::flush();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed
    }
};
