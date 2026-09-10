<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Laptop Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <!-- Simple Navigation Link Back to Dashboard -->
    <nav class="bg-slate-900 text-white px-8 py-4 flex justify-between items-center shadow-md">
        <span class="font-black tracking-wider text-xl text-sky-400">LAPTOP SHOP <span class="text-white text-sm font-medium">| ADMIN</span></span>
        <a href="{{ route('dashboard') }}" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition">
            ⬅️ Back to Dashboard
        </a>
    </nav>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="border-b border-gray-200 pb-3 mb-6 px-4">
            <h2 class="font-black text-3xl text-slate-800 tracking-tight">👥 User Accounts Management</h2>
            <p class="text-gray-500 text-sm mt-1">View, manage, and monitor system access privileges.</p>
        </div>

        <!-- Success & Error Messages Handling -->
        @if(session('success'))
            <div class="mb-4 mx-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl font-bold text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 mx-4 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-xl font-bold text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Users Data Table Container -->
        <div class="mx-4 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100 text-slate-700 font-extrabold text-xs uppercase tracking-wider">
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">User Name</th>
                        <th class="py-4 px-6">Email Address</th>
                        <th class="py-4 px-6">Assigned Role</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm text-slate-600 font-medium">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-gray-400">#{{ $user->id }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 px-6 text-gray-500">{{ $user->email }}</td>
                            <td class="py-4 px-6">
                                @if($user->role === 'admin')
                                    <span class="bg-purple-100 text-purple-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">🛠️ Admin</span>
                                @elseif($user->role === 'sales_assistant')
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">🛒 Sales Staff</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">👤 Customer</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($user->id === auth()->id())
                                    <!-- Logged-in Super Admin visual protection block -->
                                    <span class="bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-extrabold px-3 py-1.5 rounded-xl">
                                        🔒 Active Super Admin (You)
                                    </span>
                                @else
                                    <!-- Delete option for other profiles -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="delete-user-form inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-user-btn bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs uppercase px-4 py-2 rounded-xl border border-red-200 transition">
                                            Delete Account
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- SweetAlert2 Confirmation Script Integration -->
    <script>
        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-user-form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This account will be permanently removed from the system registry!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ef4444",
                    cancelButtonColor: "#64748b",
                    confirmButtonText: "Yes, delete user!",
                    cancelButtonText: "Cancel",
                    borderRadius: "15px"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>