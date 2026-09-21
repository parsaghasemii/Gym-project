<x-admin-layout>
    <div class="admin-page-header !mb-0">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">اعضا</h1>
        </div>
    </div>

    <p class="table-scroll-hint mt-6">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card table-scroll">
        <table class="w-full text-sm text-right">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="py-2 font-medium">نام</th>
                    <th class="py-2 font-medium">ایمیل</th>
                    <th class="py-2 font-medium">onboarding</th>
                    <th class="py-2 font-medium">هدف</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr class="border-b border-slate-100">
                        <td class="py-3 font-medium">{{ $member->name }}</td>
                        <td class="py-3">{{ $member->email }}</td>
                        <td class="py-3">
                            @if ($member->onboarding_completed)
                                <span class="text-gym-600">تکمیل شده</span>
                            @else
                                <span class="text-slate-400">در انتظار</span>
                            @endif
                        </td>
                        <td class="py-3">{{ $member->profile?->goal?->label() ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-8 text-center text-slate-500">هنوز عضوی ثبت‌نام نکرده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $members->links() }}</div>
</x-admin-layout>
