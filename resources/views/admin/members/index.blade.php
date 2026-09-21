<x-admin-layout>
    <div class="admin-page-header">
        <div>
            <p class="section-label">مدیریت</p>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">اعضا</h1>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn-primary !text-sm w-full sm:w-auto justify-center">کاربر جدید</a>
    </div>

    <p class="table-scroll-hint">برای مشاهده کامل جدول، به چپ بکشید ←</p>
    <div class="card admin-table-card">
        <div class="table-scroll">
            <table class="w-full text-sm text-right">
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>onboarding</th>
                        <th>هدف</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td class="font-medium text-slate-900">{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                @if ($member->onboarding_completed)
                                    <span class="text-gym-600">تکمیل شده</span>
                                @else
                                    <span class="text-slate-400">در انتظار</span>
                                @endif
                            </td>
                            <td>{{ $member->profile?->goal?->label() ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-10 text-center text-slate-500">هنوز عضوی ثبت‌نام نکرده است.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $members->links('vendor.pagination.admin') }}</div>
</x-admin-layout>
