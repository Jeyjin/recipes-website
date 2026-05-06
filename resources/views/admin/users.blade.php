@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-rose-800">Управление пользователями</h1>
        <a href="{{ route('admin') }}" class="text-rose-500 hover:text-rose-600">← Назад</a>
    </div>
    
    <div class="bg-white/80 rounded-2xl border border-rose-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-rose-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-rose-700">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-rose-700">Логин</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-rose-700">Роль</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-rose-700">Дата регистрации</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-rose-700">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-100">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->id }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-rose-700">{{ $user->login }}</td>
                    <td class="px-6 py-4 text-sm">
                        <select onchange="changeRole({{ $user->id }}, this.value)" class="px-2 py-1 border border-rose-200 rounded-lg text-sm">
                            <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Пользователь</option>
                            <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Администратор</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <button onclick="deleteUser({{ $user->id }})" class="text-red-500 hover:text-red-700">Удалить</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function changeRole(userId, isAdmin) {
    fetch('/admin/users/' + userId + '/role', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_admin: parseInt(isAdmin) })
    }).then(() => location.reload());
}

function deleteUser(userId) {
    if (confirm('Удалить пользователя?')) {
        fetch('/admin/users/' + userId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection