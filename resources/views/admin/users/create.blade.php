<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased flex items-center justify-center py-12 px-4">

    <div class="max-w-md w-full bg-white rounded-3xl p-8 shadow-md border border-gray-100">
        
        <div class="mb-6 text-center">
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">👤 Add New Staff Member</h2>
            <p class="text-gray-500 text-sm mt-1">Create accounts for Sales Assistants or Admins</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-xl p-3 text-xs font-bold mb-4">
                <ul class="m-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <div>
    <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Full Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Kamal Perera"
           oninput="this.value = this.value.replace(/[^a-zA-Z\s.]/g, '')"
           style="width: 100%; background-color: white; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-size: 14px; outline: none; color: #334155;">
</div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="kamal@laptopshop.com"
                       style="width: 100%; background-color: white; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-size: 14px; outline: none; color: #334155;">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Assign Role</label>
                <select name="role" required
                        style="width: 100%; background-color: white; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-size: 14px; outline: none; color: #334155; cursor: pointer;">
                    <option value="sales_assistant">🛒 Sales Assistant</option>
                    <option value="admin">🔑 Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Password</label>
                <input type="password" name="password" required placeholder="Minimum 8 characters"
                       style="width: 100%; background-color: white; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-size: 14px; outline: none; color: #334155;">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required placeholder="Re-type password"
                       style="width: 100%; background-color: white; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-size: 14px; outline: none; color: #334155;">
            </div>

            <div class="flex gap-3 mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-light" style="flex: 1; padding: 12px 0; border-radius: 12px; font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                    Cancel
                </a>
                <button type="submit" style="flex: 1; background-color: #10b981; color: white; font-weight: 800; padding: 12px 0; border-radius: 12px; border: none; cursor: pointer; transition: 0.3s; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;">
                    Create User
                </button>
            </div>

        </form>
    </div>

</body>
</html>