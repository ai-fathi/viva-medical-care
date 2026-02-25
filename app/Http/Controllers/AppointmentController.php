<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AppointmentController extends Controller
{
    /**
     * عرض لوحة تحكم الموظفة مع جميع المواعيد
     */
    public function index() {
        $appointments = Appointment::latest()->get();
        return view('dashboard', compact('appointments'));
    }

    /**
     * استقبال وحفظ طلب الحجز من المريض
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:255', // إضافة البريد الإلكتروني
            'preferred_date' => 'required|date',
            'treatment_type' => 'required|string', // إضافة نوع العلاج
        ]);

        // الحالة الافتراضية هي 'pending' عند الحجز لأول مرة
        Appointment::create($validated);

        return back()->with('success', 'تم إرسال طلبك بنجاح!');
    }

    /**
     * تحديث الموعد من قبل الموظفة (تأكيد الوقت النهائي)
     */
    public function update(Request $request, $id) {
        $appointment = Appointment::findOrFail($id);
        
        $request->validate([
            'scheduled_at' => 'required|date',
        ]);

        $appointment->update([
            'scheduled_at' => $request->scheduled_at,
            'status'       => 'confirmed' // تغيير الحالة إلى مؤكد عند تحديد الموعد
        ]);

        return back()->with('status_updated', 'تم تأكيد الموعد بنجاح');
    }

    /**
     * التحقق من حالة الموعد للمريض عبر رقم الهاتف
     */
    public function checkStatus(Request $request) {
        $request->validate(['phone' => 'required']);

        $apt = Appointment::where('phone', $request->phone)->latest()->first();

        if (!$apt) {
            return back()->with('error', 'عذراً، لا يوجد موعد مسجل بهذا الرقم.');
        }

        // إرجاع بيانات الموعد للجلسة لعرضها في النافذة المنبثقة (Modal)
        return back()->with('appointment_data', $apt);
    }

    /**
     * تغيير لغة الموقع
     */
    public function changeLanguage($locale) {
        if (in_array($locale, ['ar', 'en', 'fr'])) {
            // تخزين اللغة في الجلسة ليقوم الميدل وير SetLocal بتطبيقها
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }
}