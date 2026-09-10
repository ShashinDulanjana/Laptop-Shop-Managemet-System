<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laptop;
use Illuminate\Support\Facades\File; // පින්තූර මැකීමට මෙය අත්‍යවශ්‍යයි

class LaptopController extends Controller
{
    // 1. Dashboard එකට දත්ත යවන, Search කරන සහ Sort කරන කොටස
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort'); // Sorting සඳහා අගය ලබා ගැනීම

        $query = Laptop::query();

        // සෙවුම් පදය (Search Term) අනුව පෙරීම
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        // පිළිවෙළකට පෙළගැස්වීම (Sorting Logic)
        if ($sort == 'price_low') {
            $query->orderBy('price', 'asc'); // මිල අඩුම සිට වැඩිම
        } elseif ($sort == 'price_high') {
            $query->orderBy('price', 'desc'); // මිල වැඩිම සිට අඩුම
        } elseif ($sort == 'newest') {
            $query->orderBy('created_at', 'desc'); // අලුතින්ම ඇතුළත් කළ දේවල් මුලට
        } else {
            // Default එක පරණ පිළිවෙළට (ID එක පිළිවෙළට) සකස් කළා
            $query->orderBy('id', 'asc'); 
        }

        $laptops = $query->paginate(6)->withQueryString();

        return view('dashboard', compact('laptops'));
    }

    // 2. Form එක පෙන්වන කොටස
    public function create()
    {
        return view('laptops.create');
    }

    // 3. දත්ත Save කරන කොටස
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'specifications' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        Laptop::create($data);

        return redirect()->route('dashboard')->with('success', 'Laptop added successfully!');
    }

    // Edit කිරීමට අවශ්‍ය Form එක පෙන්වීම
    public function edit($id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('laptops.edit', compact('laptop'));
    }

    // වෙනස් කළ දත්ත Update කිරීම සහ පරණ පින්තූරය මැකීම
    public function update(Request $request, $id)
    {
        $laptop = Laptop::findOrFail($id);
        
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'specifications' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if (File::exists(public_path('images/' . $laptop->image))) {
                File::delete(public_path('images/' . $laptop->image));
            }

            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $laptop->update($data);
        return redirect()->route('dashboard')->with('success', 'Laptop updated successfully!');
    }

    // දත්තය සහ පින්තූරය සම්පූර්ණයෙන්ම මකා දැමීම
    public function destroy($id)
    {
        $laptop = Laptop::findOrFail($id);
        
        if (File::exists(public_path('images/' . $laptop->image))) {
            File::delete(public_path('images/' . $laptop->image));
        }

        $laptop->delete();
        return redirect()->route('dashboard')->with('success', 'Laptop and its image deleted successfully!');
    }

    // පාරිභෝගිකයාට ලැප්ටොප් පෙන්වන method එක (Search, Sort, Pagination සහිතව)
    public function shop(Request $request)
    {
        $query = Laptop::query();

        // 1. Search (සෙවීමේ ක්‍රියාවලිය)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
        }

        // 2. Sort Logic
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort == 'newest') {
                $query->latest(); 
            } elseif ($request->sort == 'oldest') {
                $query->orderBy('id', 'asc'); 
            }
        } else {
            $query->orderBy('id', 'asc'); 
        }

        // 3. Pagination (එක් පිටුවකට ලැප්ටොප් 6ක් පෙන්වීම)
        $laptops = $query->paginate(6);

        return view('customer.shop', compact('laptops'));
    }

    public function show($id)
    {
        $laptop = Laptop::findOrFail($id);
        return view('customer.show', compact('laptop')); 
    }

    // 🛠️ සුපිරියටම සකස් කළ Unified Checkout Method එක
    public function checkout(Request $request, $id = null)
    {
        $checkoutItems = [];
        $isDirectBuy = false;
        $singleLaptopPrice = 0;
        $laptopId = null;
        $laptop = null; // බ්ලේඩ් එකේ error එක එන නිසා හැමවිටම මෙය නිර්මාණය කරයි

        // 1. "Buy Now" හරහා තනි ලැප්ටොප් එකක ID එකක් එක්ක ආවොත්
        if ($id) {
            $laptop = Laptop::find($id);
            if (!$laptop) {
                return redirect()->back()->with('error', 'Laptop not found!');
            }

            $checkoutItems[$laptop->id] = [
                'brand'    => $laptop->brand,
                'model'    => $laptop->model,
                'price'    => $laptop->price,
                'image'    => $laptop->image,
                'quantity' => 1, 
            ];
            
            $isDirectBuy = true;
            $singleLaptopPrice = $laptop->price;
            $laptopId = $laptop->id;

        } else {
            // 2. Cart එකේ "Proceed to Checkout" බටන් එකෙන් ආවොත්
            $cart = session()->get('cart', []);
            
            if (empty($cart)) {
                return redirect()->route('customer.shop')->with('error', 'Your cart is empty!');
            }
            
            $checkoutItems = $cart;
            
            // Cart එකෙන් එද්දී බ්ලේඩ් එකේ තියෙන $laptop->brand, $laptop->id වැඩ කරන්න 
            // කාර්ට් එකේ තියෙන පළමු ලැප්ටොප් එකේ ID එක අරන් Object එකක් හදනවා.
            $laptopId = array_key_first($cart);
            $laptop = Laptop::find($laptopId);
        }

        // $laptop කියන variable එකත් ඇතුළුව ඔක්කොම දත්ත ටික View එකට යවනවා
        return view('customer.checkout', compact('checkoutItems', 'isDirectBuy', 'singleLaptopPrice', 'laptopId', 'laptop'));
    }

    public function updateStatus(\Illuminate\Http\Request $request, $id)
{
    // ඔයාගේ Model එක Order වුණත් Sale වුණත් මේ කෝඩ් එකෙන් ඔටෝම අල්ලගන්නවා!
    $order = \App\Models\Order::find($id) ?? \App\Models\Sale::find($id);
    
    if ($order) {
        $order->status = $request->status;
        $order->save();
        return back()->with('success', 'Status updated successfully!');
    }

    return back()->with('error', 'Order not found!');
}
}