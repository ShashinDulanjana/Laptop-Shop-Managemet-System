<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Laptop - Modern Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #0f172a; font-family: 'Figtree', sans-serif; color: #f8fafc; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 2rem; }
        .input-field { background-color: #0f172a; border: 1px solid #334155; border-radius: 0.75rem; padding: 1rem; color: #f8fafc; width: 100%; outline: none; transition: 0.3s; }
        .input-field:focus { border-color: #10b981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10 px-4">

    <div class="w-full max-w-2xl">
        <div class="text-center mb-8">
            <a href="{{ route('dashboard') }}" class="inline-block border border-emerald-500/30 text-emerald-400 font-bold py-2 px-8 rounded-full text-xs uppercase tracking-widest hover:bg-emerald-500/10 transition">
                ← Back to Inventory
            </a>
        </div>

        <div class="glass-card p-10 shadow-2xl">
            <h2 class="text-2xl font-black text-emerald-400 text-center uppercase tracking-widest mb-10 flex items-center justify-center gap-3">
                🚀 Add New Laptop
            </h2>

            <form action="{{ route('laptops.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Brand</label>
                    <input type="text" name="brand" class="input-field" placeholder="ASUS, HP, Dell..." required>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Model</label>
                    <input type="text" name="model" class="input-field" placeholder="Vivobook, Victus..." required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Price (LKR)</label>
                        <input type="number" name="price" min="0" class="input-field" placeholder="0.00" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Stock</label>
                        <input type="number" name="stock" min="1" class="input-field" placeholder="10" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Specifications</label>
                    <textarea name="specifications" rows="3" class="input-field" placeholder="i5 13th Gen, 16GB RAM, 512GB SSD..."></textarea>
                </div>

                <div class="p-6 bg-slate-900/50 rounded-2xl border border-slate-700">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-center">Laptop Image</label>
                    <input type="file" name="image" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-500/20 file:text-emerald-400 hover:file:bg-emerald-500/30 cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all uppercase tracking-widest text-sm mt-4">
                    Add Laptop & Image
                </button>
            </form>
        </div>
    </div>

</body>
</html>