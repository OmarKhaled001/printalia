<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['id' => 1, 'key' => 'site_title', 'value' => 'Printalia - برنتاليا', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 2, 'key' => 'site_keywords', 'value' =>  'Printalia, برنتاليا, منصة يمنية, تصميم منتجات, طباعة, تسويق إلكتروني, مصانع يمنية, طلبات جماعية, أرباح من التصميم, عمولة تسويقية, طباعة التيشيرتات, طباعة الأكواب, منتجات مخصصة, مشاريع رقمية, فرص عمل يمنية, تمكين الشباب, ريادة أعمال, دخل إضافي, تسويق بالعمولة, طباعة حسب الطلب, Dropshipping يمني, print on demand', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 3, 'key' => 'site_description', 'value' => 'منصة **Printalia** (برنتاليا) - أول منصة يمنية متخصصة في **تصميم وبيع المنتجات المطبوعة حسب الطلب**. ساعد المصانع المحلية واربح عمولات من خلال تسويق التيشيرتات، الأكواب، الهدايا، والمزيد. انضم الآن وابدأ رحلتك في عالم ريادة الأعمال الرقمية!', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 4, 'key' => 'logo', 'value' => 'settings/01JWBB3MGQVXBHJWTAGVRGGCE2.png', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 5, 'key' => 'icon', 'value' => 'settings/01JWBB3MHHESPY32YEJVDGS0B4.png', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 6, 'key' => 'bank_code', 'value' => '951248792975785', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 7, 'key' => 'present_earn', 'value' => '50', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 8, 'key' => 'hero_section_title', 'value' => 'أطلق براندك وابدأ تجارتك من بيتك', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 9, 'key' => 'hero_section_description', 'value' => 'أول منصة يمنية للطباعة عند الطلب .صمم، اعرض، وخلّينا ننتج ونوصل لعملاءك  بدون رأس مال، بدون مخزون، وبدون مخاطرة', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 10, 'key' => 'hero_section_image', 'value' => 'settings/01JWBFB5Y7Y099TS6G6PKJVCJR.png', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 09:54:43'],
            ['id' => 11, 'key' => 'about_section_title', 'value' => 'من نحن ؟', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 12, 'key' => 'about_section_description', 'value' => 'نحن فريق يمني شغوف بالتقنية وريادة الأعمال، أطلقنا منصة برنتاليا كحل مبتكر في مجال التجارة الالكترونية لصناعة براند خاص فيك بدون مخاطرة وراس مال . مهمتنا هي تمكين كل مبدع أو رائد أعمال طموح من دخول عالم التجارة الإلكترونية بوسائل ذكية وآمنة', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:41'],
            ['id' => 13, 'key' => 'about_section_image', 'value' => 'settings/01JWBB3MHTVRN1B5QV8GXBWC3G.png', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:42'],
            ['id' => 14, 'key' => 'vision_section_title', 'value' => 'رؤيتنا', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:42'],
            ['id' => 15, 'key' => 'vision_section_description', 'value' => 'أن نفتح آفاق التجارة الإلكترونية في اليمن، ونمكّن المبدعين من تحويل أفكارهم إلى علامات تجارية ناجحة بدون تعقيدات أو تكاليف عالية.\n', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:40:42'],
            ['id' => 16, 'key' => 'vision_section_image', 'value' => 'settings/01JWBJ7W6CT7XETX4TV73QCTJG.png', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 10:45:20'],
            ['id' => 17, 'key' => 'contact_phone', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 18, 'key' => 'contact_email', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 19, 'key' => 'contact_address', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 20, 'key' => 'contact_zip_code', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 21, 'key' => 'facebook_link', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
            ['id' => 22, 'key' => 'insta_link', 'value' => '', 'created_at' => '2025-05-28 08:29:47', 'updated_at' => '2025-05-28 08:29:47'],
        ]);
    }
}
