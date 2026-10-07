<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

$servicePrices = [
    'Fast Clean - Easy' => 20000,
    'Fast Clean - Hard' => 25000,
    'Deep Clean - Flat Shoes' => 15000,
    'Deep Clean - Reguler' => 30000,
    'Deep Clean - Express' => 40000,
    'Deep Clean - Express Half Day' => 50000,
    'Reglue' => 15000,
    'Unyellowing' => 15000,
    'Repaint/Custom' => 100000,
    'Bag/Tas - Small' => 20000,
    'Bag/Tas - Medium' => 25000,
    'Bag/Tas - Hard' => 35000,
    'Hat' => 20000,
];

$serviceEstimates = [
    'Fast Clean - Easy' => '1-2 hari',
    'Fast Clean - Hard' => '1-3 hari',
    'Deep Clean - Flat Shoes' => '1-2 hari',
    'Deep Clean - Reguler' => '1-3 hari',
    'Deep Clean - Express' => '1 hari',
    'Deep Clean - Express Half Day' => '7-8 jam',
    'Reglue' => '1-10 hari',
    'Unyellowing' => '1-3 hari',
    'Repaint/Custom' => '3-10 hari',
];

$resolveEstimatedPickup = static function (?string $service, $baseDate = null) use ($serviceEstimates): ?array {
    $estimateLabel = $serviceEstimates[$service ?? ''] ?? null;

    if (! $estimateLabel) {
        return null;
    }

    $pickupAt = $baseDate instanceof Carbon ? $baseDate->copy() : now();

    if (str_contains($estimateLabel, 'jam') && preg_match_all('/\d+/', $estimateLabel, $matches)) {
        $pickupAt->addHours((int) end($matches[0]));
    } elseif (str_contains($estimateLabel, 'hari') && preg_match_all('/\d+/', $estimateLabel, $matches)) {
        $pickupAt->addDays((int) end($matches[0]));
    }

    return [
        'label' => $estimateLabel,
        'date' => $pickupAt->translatedFormat('d M Y, H:i'),
    ];
};

$formatOrder = static function (Order $order): array {
    return [
        'id' => $order->order_code,
        'customer_name' => $order->customer_name,
        'phone' => $order->phone,
        'address' => $order->address,
        'item_type' => $order->item_type,
        'color' => $order->color,
        'condition' => $order->condition,
        'service_choice' => $order->service_choice,
        'brand' => $order->brand,
        'service' => $order->service,
        'service_price' => $order->service_price,
        'cash_paid' => $order->cash_paid,
        'cash_change' => $order->cash_change,
        'notes' => $order->notes,
        'payment_method' => $order->payment_method,
        'payment_status' => $order->payment_status ?? 'Belum dikonfirmasi',
        'status' => $order->status,
        'created_at' => optional($order->created_at)->format('d/m/Y H:i'),
        'uploaded_photo_url' => $order->photo_url,
        'uploaded_photo_name' => $order->photo_name,
    ];
};

$formatCustomer = static function (Customer $customer): array {
    if (! $customer->member_code) {
        $customer->forceFill([
            'member_code' => 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4)),
        ])->save();
    }

    $stampOrders = $customer->stampVisits()
        ->map(fn ($orders, $date) => [
            'date' => Carbon::parse($date)->format('d/m/Y'),
            'order_count' => $orders->count(),
            'orders' => $orders->map(fn (Order $order) => [
                'id' => $order->order_code,
                'service' => $order->service,
                'status' => $order->status,
            ])->values()->all(),
        ])->values()->all();

    return [
        'id' => $customer->customer_code,
        'member_code' => $customer->member_code,
        'name' => $customer->name,
        'phone' => $customer->phone,
        'address' => $customer->address,
        'completed_wash_orders_count' => $customer->completed_wash_orders_count,
        'earned_stamps_count' => $customer->earned_stamps_count,
        'current_stamp_progress' => $customer->current_stamp_progress,
        'stamp_target' => Customer::MEMBER_STAMP_TARGET,
        'available_rewards' => $customer->available_rewards,
        'reward_redemptions' => $customer->reward_redemptions,
        'stamp_orders' => $stampOrders,
        'created_at' => optional($customer->created_at)->format('d/m/Y H:i'),
    ];
};

$applyDateRange = static function ($query, string $dateFrom, string $dateTo) {
    if ($dateFrom !== '') {
        try {
            $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        } catch (\Throwable $e) {
        }
    }

    if ($dateTo !== '') {
        try {
            $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        } catch (\Throwable $e) {
        }
    }

    return $query;
};

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login', ['registrationOpen' => \App\Support\InitialAdminRegistration::isOpen()]);
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $identity = trim($credentials['email']);

    $user = User::query()
        ->where('email', $identity)
        ->orWhere('username', $identity)
        ->first();

    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
        return back()
            ->withInput($request->except('password'))
            ->with('error', 'Email/username atau password salah.');
    }

    $request->session()->regenerate();

    session([
        'social_auth' => [
            'provider' => 'local',
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'phone' => $user->phone,
            'role' => $user->role,
            'avatar' => null,
        ],
    ]);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Berhasil login.');
})->name('login.attempt');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {

    $validated = $request->validate([
        'identity' => ['required', 'string'],
    ], [
        'identity.required' => 'Email atau username wajib diisi.',
    ]);

    $identity = trim($validated['identity']);
    $user = User::query()
        ->where('email', $identity)
        ->orWhere('username', $identity)
        ->first();

    if (! $user) {
        return back()
            ->withInput()
            ->with('error', 'Akun tidak ditemukan. Cek lagi email atau username.');
    }

    session([
        'password_reset_user_id' => $user->id,
        'password_reset_identity' => $identity,
    ]);

    return redirect()
        ->route('password.reset')
        ->with('success', 'Akun ditemukan. Silakan buat password baru.');
})->name('password.email');

Route::get('/reset-password', function () {
    if (! session('password_reset_user_id')) {
        return redirect()
            ->route('password.request')
            ->with('error', 'Isi email atau username terlebih dahulu.');
    }

    return view('auth.reset-password', [
        'identity' => session('password_reset_identity'),
    ]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $userId = session('password_reset_user_id');

    if (! $userId) {
        return redirect()
            ->route('password.request')
            ->with('error', 'Sesi reset password sudah habis. Ulangi dari awal.');
    }

    $validated = $request->validate([
        'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
    ], [
        'password.required' => 'Password baru wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.max' => 'Password maksimal 16 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sama.',
    ]);

    $user = User::query()->find($userId);

    if (! $user) {
        $request->session()->forget(['password_reset_user_id', 'password_reset_identity']);

        return redirect()
            ->route('password.request')
            ->with('error', 'Akun tidak ditemukan. Ulangi reset password.');
    }

    $user->update([
        'password' => $validated['password'],
    ]);

    $request->session()->forget(['password_reset_user_id', 'password_reset_identity']);

    return redirect()
        ->route('login')
        ->with('success', 'Password berhasil diganti. Silakan login dengan password baru.');
})->name('password.update');

Route::get('/auth/{provider}/redirect', function (string $provider) {
    $providers = [
        'google' => 'Google',
        'facebook' => 'Facebook',
        'apple' => 'Apple',
    ];

    abort_unless(array_key_exists($provider, $providers), 404);

    if ($provider !== 'google') {
        return redirect()
            ->route('login')
            ->with('error', $providers[$provider] . ' login belum dikonfigurasi. Google sudah siap dipakai lebih dulu.');
    }

    if (! config('services.google.client_id') || ! config('services.google.client_secret') || ! config('services.google.redirect')) {
        return redirect()
            ->route('login')
            ->with('error', 'Google login belum aktif. Isi GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI di file .env terlebih dulu.');
    }

    return Socialite::driver('google')->redirect();
})->name('social.redirect');

Route::get('/auth/google/callback', function () {
    if (! config('services.google.client_id') || ! config('services.google.client_secret') || ! config('services.google.redirect')) {
        return redirect()
            ->route('login')
            ->with('error', 'Google login belum aktif. Konfigurasi .env masih belum lengkap.');
    }

    try {
        $googleUser = Socialite::driver('google')->user();
    } catch (\Throwable $e) {
        return redirect()
            ->route('login')
            ->with('error', 'Login Google gagal. Cek callback URL Google Cloud dan coba lagi.');
    }

    session([
        'social_auth' => [
            'provider' => 'google',
            'user_id' => null,
            'name' => $googleUser->getName() ?: 'Google User',
            'email' => $googleUser->getEmail(),
            'username' => Str::before($googleUser->getEmail() ?: 'google-user', '@'),
            'phone' => null,
            'role' => 'admin',
            'avatar' => $googleUser->getAvatar(),
        ],
    ]);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Berhasil login dengan Google.');
})->name('google.callback');

Route::get('/register', function () {
    return view('auth.register', [
        'registrationOpen' => \App\Support\InitialAdminRegistration::isOpen(),
    ]);
})->name('register');

Route::post('/register', function (Request $request) {
    if (! \App\Support\InitialAdminRegistration::isOpen()) {
        return redirect()->route('register')->with('error', 'Registrasi Admin pertama sudah ditutup. Akun pegawai dibuat oleh Admin melalui Pengaturan.');
    }

    $request->merge([
        'username' => Str::lower(trim((string) $request->input('username'))),
        'email' => Str::lower(trim((string) $request->input('email'))),
    ]);
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_-]+$/', 'unique:users,username'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['required', 'string', 'max:30'],
        'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
    ], [
        'required' => ':attribute wajib diisi.',
        'username.regex' => 'Username hanya boleh berisi huruf, angka, tanda minus, atau underscore.',
        'unique' => ':attribute sudah digunakan.',
        'email.email' => 'Format email tidak valid.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.max' => 'Password maksimal 16 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sama.',
    ]);

    if (! \App\Support\InitialAdminRegistration::register($validated)) {
        return redirect()->route('register')->with('error', 'Registrasi Admin pertama sudah ditutup.');
    }

    return redirect()->route('login')->with('success', 'Akun Admin berhasil dibuat. Silakan login menggunakan akun Anda.');
})->name('register.store');

Route::post('/logout', function (Request $request) {
    $request->session()->forget([
        'social_auth',
        'submitted_order',
        'uploaded_photo_name',
        'uploaded_photo_url',
    ]);

    return redirect()
        ->route('login')
        ->with('success', 'Anda berhasil keluar.');
})->name('logout');

Route::get('/dashboard', function () use ($servicePrices) {
    $orders = Order::query()->latest()->get();
    $today = now()->format('d/m/Y');
    $todayOrders = 0;
    $todayRevenue = 0;
    $inProgress = 0;
    $completed = 0;
    $readyPickup = 0;
    $serviceCounts = [];

    foreach ($orders as $order) {
        $service = $order->service ?? '';
        $price = $servicePrices[$service] ?? 0;
        $createdAt = optional($order->created_at)->format('d/m/Y H:i');

        if ($createdAt && str_starts_with($createdAt, $today)) {
            $todayOrders++;
            $todayRevenue += $price;
        }

        if ($order->status === 'Diproses') {
            $inProgress++;
        }

        if ($order->status === 'Siap Diambil' || $order->status === 'Diambil') {
            $completed++;
        }

        if ($order->status === 'Siap Diambil') {
            $readyPickup++;
        }

        if ($service !== '') {
            $serviceCounts[$service] = ($serviceCounts[$service] ?? 0) + 1;
        }
    }

    arsort($serviceCounts);
    $topServices = array_slice($serviceCounts, 0, 4, true);

    $monthLabels = [];
    $thisYearSeries = [];
    $prevYearSeries = [];

    for ($i = 6; $i >= 0; $i--) {
        $month = now()->startOfMonth()->subMonths($i);
        $monthLabels[] = $month->translatedFormat('M');
        $currentMonthKey = $month->format('Y-m');
        $previousYearKey = $month->copy()->subYear()->format('Y-m');

        $currentTotal = 0;
        $previousTotal = 0;

        foreach ($orders as $order) {
            if (! $order->created_at) {
                continue;
            }

            $price = $servicePrices[$order->service ?? ''] ?? 0;
            $orderMonthKey = $order->created_at->format('Y-m');

            if ($orderMonthKey === $currentMonthKey) {
                $currentTotal += $price;
            }

            if ($orderMonthKey === $previousYearKey) {
                $previousTotal += $price;
            }
        }

        $thisYearSeries[] = $currentTotal;
        $prevYearSeries[] = $previousTotal;
    }

    return view('dashboard.index', [
        'todayOrders' => $todayOrders,
        'todayRevenue' => $todayRevenue,
        'inProgress' => $inProgress,
        'completed' => $completed,
        'readyPickup' => $readyPickup,
        'totalCustomers' => Customer::query()->count(),
        'topServices' => $topServices,
        'readyCount' => $readyPickup,
        'newOrderCount' => $todayOrders,
        'chartLabels' => $monthLabels,
        'chartThisYear' => $thisYearSeries,
        'chartPrevYear' => $prevYearSeries,
    ]);
})->name('dashboard');

Route::get('/orders', function (Request $request) use ($formatOrder) {
    $statusOptions = ['Semua Status', 'Baru', 'Diproses', 'Siap Diambil', 'Diambil'];
    $activeStatus = $request->query('status', 'Semua Status');
    $search = trim((string) $request->query('search', ''));

    if (! in_array($activeStatus, $statusOptions, true)) {
        $activeStatus = 'Semua Status';
    }

    $query = Order::query()->latest();

    if ($activeStatus !== 'Semua Status') {
        $query->where('status', $activeStatus);
    }

    if ($search !== '') {
        $query->where(function ($builder) use ($search) {
            $builder
                ->where('order_code', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }

    return view('orders.index', [
        'orders' => $query->get()->map($formatOrder)->all(),
        'activeStatus' => $activeStatus,
        'statusOptions' => $statusOptions,
        'search' => $search,
    ]);
})->name('orders.index');

Route::get('/orders/create', function () {
    return view('orders.create', [
        'customerOptions' => Customer::query()
            ->latest()
            ->get(['id', 'name', 'phone', 'address'])
            ->map(fn (Customer $customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ])
            ->all(),
    ]);
})->name('orders.create');

Route::post('/orders', function (Request $request) use ($servicePrices) {
    $validated = $request->validate([
        'phone' => ['required', 'string', 'max:30'],
        'customer_name' => ['required', 'string', 'max:255'],
        'address' => ['nullable', 'string', 'max:255'],
        'color' => ['nullable', 'string', 'max:255'],
        'condition' => ['nullable', 'string', 'max:255'],
        'service_choice' => ['required', 'string', 'max:255'],
        'brand' => ['nullable', 'string', 'max:255'],
        'service' => ['required', 'string', 'max:255'],
        'item_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        'notes' => ['nullable', 'string'],
        'payment_method' => ['nullable', 'in:Cash (Tunai),Transfer Bank,QRIS'],
        'payment_status' => ['required', 'in:Belum Lunas,Lunas'],
        'cash_paid' => ['nullable', 'string', 'max:50'],
    ]);

    $servicePrice = $servicePrices[$validated['service']] ?? 0;
    $payment = \App\Support\OrderPayment::resolve($validated, $servicePrice);
    $validated['payment_method'] = $payment['payment_method'];
    $cashPaid = $payment['cash_paid'];
    $cashChange = $payment['cash_change'];

    $photo = $request->file('item_photo');
    $directory = public_path('uploads/order-photos');

    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $filename = Str::uuid()->toString() . '.' . $photo->getClientOriginalExtension();
    $originalPhotoName = $photo->getClientOriginalName();
    $photo->move($directory, $filename);

    DB::transaction(function () use ($validated, $filename, $originalPhotoName, $servicePrice, $cashPaid, $cashChange) {
        $customer = Customer::query()->firstOrNew([
            'phone' => $validated['phone'],
        ]);

        if (! $customer->exists) {
            $customer->customer_code = 'CUS-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
            $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } elseif (! $customer->member_code) {
            $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        }

        $customer->fill([
            'name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
        ]);
        $customer->save();

        $order = new Order();
        $order->order_code = 'ORD-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        $order->customer_id = $customer->id;
        $order->customer_name = $validated['customer_name'];
        $order->phone = $validated['phone'];
        $order->address = $validated['address'] ?? null;
        $order->item_type = $validated['service_choice'];
        $order->color = $validated['color'] ?? null;
        $order->condition = $validated['condition'] ?? null;
        $order->service_choice = $validated['service_choice'];
        $order->brand = $validated['brand'] ?? null;
        $order->service = $validated['service'];
        $order->service_price = $servicePrice;
        $order->cash_paid = $cashPaid;
        $order->cash_change = $cashChange;
        $order->photo_path = 'uploads/order-photos/' . $filename;
        $order->photo_name = $originalPhotoName;
        $order->notes = $validated['notes'] ?? null;
        $order->payment_method = $validated['payment_method'] ?? null;
        $order->payment_status = $validated['payment_status'];
        $order->status = 'Baru';
        $order->save();
        // The database ID keeps short receipt numbers unique, including concurrent orders.
        $order->order_code = 'RS' . str_pad((string) $order->id, 4, '0', STR_PAD_LEFT);
        $order->save();
    });

    $request->session()->increment('order_draft_revision');

    return redirect()
        ->route('orders.index')
        ->with('success', 'Order berhasil disimpan.')
        ->with('order_saved', true);
})->name('orders.store');

Route::delete('/orders/{id}', function (Request $request, string $id) {
    if (! is_array($request->session()->get('social_auth'))) {
        return redirect()->route('login');
    }

    $validated = $request->validate([
        'redirect_status' => ['nullable', 'string', 'in:Semua Status,Baru,Diproses,Siap Diambil,Diambil'],
        'search' => ['nullable', 'string', 'max:255'],
    ]);

    $order = Order::query()->where('order_code', $id)->firstOrFail();
    $order->delete();

    return redirect()->route('orders.index', array_filter([
        'status' => $validated['redirect_status'] ?? null,
        'search' => $validated['search'] ?? null,
    ]))->with('success', 'Order ' . $id . ' berhasil dihapus.');
})->name('orders.destroy');

Route::post('/orders/{id}', function (Request $request, string $id) use ($servicePrices) {
    $validated = $request->validate([
        'phone' => ['required', 'string', 'max:30'],
        'customer_name' => ['required', 'string', 'max:255'],
        'address' => ['nullable', 'string', 'max:255'],
        'color' => ['nullable', 'string', 'max:255'],
        'condition' => ['nullable', 'string', 'max:255'],
        'service_choice' => ['required', 'string', 'max:255'],
        'brand' => ['nullable', 'string', 'max:255'],
        'service' => ['required', 'string', 'max:255'],
        'notes' => ['nullable', 'string'],
        'payment_method' => ['nullable', 'in:Cash (Tunai),Transfer Bank,QRIS'],
        'payment_status' => ['required', 'in:Belum Lunas,Lunas'],
        'cash_paid' => ['nullable', 'string', 'max:50'],
        'status' => ['required', 'string', 'in:Baru,Diproses,Siap Diambil,Diambil'],
    ]);

    $servicePrice = $servicePrices[$validated['service']] ?? 0;
    $payment = \App\Support\OrderPayment::resolve($validated, $servicePrice);
    $validated['payment_method'] = $payment['payment_method'];
    $cashPaid = $payment['cash_paid'];
    $cashChange = $payment['cash_change'];

    DB::transaction(function () use ($id, $validated, $servicePrice, $cashPaid, $cashChange) {
        $order = Order::query()->where('order_code', $id)->firstOrFail();
        $customer = Customer::query()->firstOrNew([
            'phone' => $validated['phone'],
        ]);

        if (! $customer->exists) {
            $customer->customer_code = 'CUS-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
            $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        } elseif (! $customer->member_code) {
            $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        }

        $customer->fill([
            'name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
        ]);
        $customer->save();

        $order->update([
            'customer_id' => $customer->id,
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'item_type' => $validated['service_choice'],
            'color' => $validated['color'] ?? null,
            'condition' => $validated['condition'] ?? null,
            'service_choice' => $validated['service_choice'],
            'brand' => $validated['brand'] ?? null,
            'service' => $validated['service'],
            'service_price' => $servicePrice,
            'cash_paid' => $cashPaid,
            'cash_change' => $cashChange,
            'notes' => $validated['notes'] ?? null,
            'payment_method' => $validated['payment_method'] ?? null,
            'payment_status' => $validated['payment_status'],
            'status' => $validated['status'],
        ]);
    });

    return redirect()
        ->route('orders.index', $request->filled('redirect_status') ? ['status' => $request->input('redirect_status')] : [])
        ->with('success', 'Order berhasil diperbarui.');
})->name('orders.update');

Route::post('/orders/{id}/status', function (Request $request, string $id) {
    $validated = $request->validate([
        'status' => ['required', 'string', 'in:Baru,Diproses,Siap Diambil,Diambil'],
    ]);

    $order = Order::query()->where('order_code', $id)->firstOrFail();
    $order->update([
        'status' => $validated['status'],
    ]);

    return redirect()
        ->route('orders.index', $request->filled('redirect_status') ? ['status' => $request->input('redirect_status')] : [])
        ->with('success', 'Status order berhasil diperbarui.');
})->name('orders.status');

Route::post('/orders/{id}/payment-status', function (Request $request, string $id) {
    if (! is_array($request->session()->get('social_auth'))) {
        return redirect()->route('login');
    }
    $validated = $request->validate([
        'payment_status' => ['required', 'in:Belum Lunas,Lunas'],
        'redirect_status' => ['nullable', 'in:Semua Status,Baru,Diproses,Siap Diambil,Diambil'],
        'search' => ['nullable', 'string', 'max:255'],
    ]);
    $order = Order::where('order_code', $id)->firstOrFail();
    $changes = ['payment_status' => $validated['payment_status']];
    if ($validated['payment_status'] === 'Belum Lunas') {
        $changes += ['payment_method' => null, 'cash_paid' => null, 'cash_change' => null];
    }
    $order->update($changes);

    return redirect()->route('orders.index', array_filter([
        'status' => $validated['redirect_status'] ?? null,
        'search' => $validated['search'] ?? null,
    ]))->with('success', "Pembayaran {$id} berhasil diubah menjadi {$validated['payment_status']}.");
})->name('orders.payment-status');

Route::get('/orders/{id}/whatsapp', function (Request $request, string $id) use ($formatOrder, $resolveEstimatedPickup) {
    $orderModel = Order::query()->where('order_code', $id)->first();

    if (! $orderModel) {
        return redirect()
            ->route('orders.index')
            ->with('success', 'Order tidak ditemukan.');
    }

    $order = $formatOrder($orderModel);
    $digits = preg_replace('/\D+/', '', $order['phone'] ?? '');
    $whatsAppNumber = str_starts_with($digits, '0')
        ? '62' . substr($digits, 1)
        : $digits;

    if (! $whatsAppNumber) {
        return redirect()
            ->route('orders.index')
            ->with('success', 'Nomor WhatsApp pelanggan tidak valid.');
    }

    $estimatedPickup = $resolveEstimatedPickup($orderModel->service, $orderModel->created_at);
    $messageBody = \App\Support\WhatsAppReceipt::make($orderModel, $estimatedPickup);

    $message = rawurlencode($messageBody);

    $mobile = preg_match('/Android|iPhone|iPad|iPod|Mobile/i', $request->userAgent() ?? '');
    $destination = $mobile
        ? "https://wa.me/{$whatsAppNumber}?text={$message}"
        : "https://web.whatsapp.com/send?phone={$whatsAppNumber}&text={$message}";

    return redirect()->away($destination)
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
})->name('orders.whatsapp');

Route::get('/customers', function () use ($formatCustomer) {
    return view('customers.index', [
        'customers' => Customer::query()->latest()->with('orders')->get()->map($formatCustomer)->all(),
    ]);
})->name('customers.index');

Route::post('/customers', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:30'],
        'address' => ['nullable', 'string', 'max:255'],
    ]);

    $customer = Customer::query()->firstOrNew([
        'phone' => $validated['phone'],
    ]);

    if (! $customer->exists) {
        $customer->customer_code = 'CUS-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
        $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
    } elseif (! $customer->member_code) {
        $customer->member_code = 'MEM-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
    }

    $customer->fill([
        'name' => $validated['name'],
        'phone' => $validated['phone'],
        'address' => $validated['address'] ?? null,
    ]);
    $customer->save();

    return redirect()
        ->route('customers.index')
        ->with('success', 'Pelanggan berhasil disimpan.');
})->name('customers.store');

Route::post('/customers/{id}/redeem', function (string $id) {
    $customer = Customer::query()->where('customer_code', $id)->firstOrFail();

    if ($customer->available_rewards < 1) {
        return redirect()
            ->route('customers.index')
            ->with('success', 'Stempel pelanggan belum cukup untuk klaim reward gratis.');
    }

    $customer->increment('reward_redemptions');

    return redirect()
        ->route('customers.index')
        ->with('success', 'Reward member berhasil diklaim. Pelanggan mendapat 1 layanan gratis.');
})->name('customers.redeem');

Route::get('/services', function () {
    return view('services.index');
})->name('services.index');

Route::get('/reports', function (Request $request) use ($servicePrices, $applyDateRange, $formatOrder) {
    $dateFrom = trim((string) $request->query('date_from', ''));
    $dateTo = trim((string) $request->query('date_to', ''));
    $query = Order::query()->latest();

    $applyDateRange($query, $dateFrom, $dateTo);
    $orders = $query->get();

    $totalOrders = $orders->count();
    $totalRevenue = 0;
    $serviceCounts = [];
    $dailyRevenue = [];

    foreach ($orders as $order) {
        $serviceName = $order->service ?? '';
        $price = $servicePrices[$serviceName] ?? 0;
        $totalRevenue += $price;

        if ($serviceName !== '') {
            $serviceCounts[$serviceName] = ($serviceCounts[$serviceName] ?? 0) + 1;
        }

        if ($order->created_at) {
            $dayKey = $order->created_at->format('d/m/Y');
            $dailyRevenue[$dayKey] = ($dailyRevenue[$dayKey] ?? 0) + $price;
        }
    }

    arsort($serviceCounts);
    ksort($dailyRevenue);

    return view('reports.index', [
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo,
        'totalOrders' => $totalOrders,
        'totalRevenue' => $totalRevenue,
        'averageOrder' => $totalOrders > 0 ? (int) round($totalRevenue / $totalOrders) : 0,
        'topServices' => $serviceCounts,
        'dailyRevenue' => $dailyRevenue,
        'filteredOrders' => $orders->map($formatOrder)->all(),
    ]);
})->name('reports.index');

Route::get('/reports/export', function (Request $request) use ($servicePrices, $applyDateRange, $formatOrder) {
    $dateFrom = trim((string) $request->query('date_from', ''));
    $dateTo = trim((string) $request->query('date_to', ''));
    $query = Order::query()->latest();

    $applyDateRange($query, $dateFrom, $dateTo);
    $orders = $query->get()->map($formatOrder)->all();

    $totalRevenue = 0;
    foreach ($orders as $order) {
        $totalRevenue += $servicePrices[$order['service'] ?? ''] ?? 0;
    }

    return response()
        ->view('reports.export', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'orders' => $orders,
            'totalOrders' => count($orders),
            'totalRevenue' => $totalRevenue,
            'averageOrder' => count($orders) > 0 ? (int) round($totalRevenue / count($orders)) : 0,
        ])
        ->header('Content-Type', 'text/html; charset=UTF-8');
})->name('reports.export');

Route::get('/transaction-history', function (Request $request) use ($applyDateRange, $formatOrder) {
    $statusOptions = ['Semua Status', 'Baru', 'Diproses', 'Siap Diambil', 'Diambil'];
    $activeStatus = $request->query('status', 'Semua Status');
    $search = trim((string) $request->query('search', ''));
    $dateFrom = trim((string) $request->query('date_from', ''));
    $dateTo = trim((string) $request->query('date_to', ''));

    if (! in_array($activeStatus, $statusOptions, true)) {
        $activeStatus = 'Semua Status';
    }

    $query = Order::query()->latest();

    if ($activeStatus !== 'Semua Status') {
        $query->where('status', $activeStatus);
    }

    if ($search !== '') {
        $query->where(function ($builder) use ($search) {
            $builder
                ->where('order_code', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }

    $applyDateRange($query, $dateFrom, $dateTo);

    return view('transaction-history.index', [
        'orders' => $query->get()->map($formatOrder)->all(),
        'activeStatus' => $activeStatus,
        'statusOptions' => $statusOptions,
        'search' => $search,
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo,
    ]);
})->name('transaction-history.index');

Route::get('/settings', function () {
    abort_unless(User::accountManager(), 403);


    $users = User::query()
        ->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
        ->orderBy('name')
        ->get()
        ->map(fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'phone' => $user->phone,
            'role' => $user->role,
        ])
        ->all();

    return view('settings.index', [
        'users' => $users,
    ]);
})->name('settings.index');

Route::post('/settings/users', function (Request $request) {
    abort_unless(User::accountManager(), 403);


    $normalizedUsername = Str::of((string) $request->input('username'))
        ->trim()
        ->lower()
        ->replaceMatches('/[^a-z0-9]+/i', '-')
        ->trim('-')
        ->value();

    $request->merge([
        'username' => $normalizedUsername,
    ]);

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:users,username'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['nullable', 'string', 'max:30'],
        'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
    ], [
        'username.required' => 'Username wajib diisi.',
        'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda minus (-), atau underscore (_).',
        'username.unique' => 'Username ini sudah dipakai.',
    ]);

    User::create([
        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?: null,
        'role' => 'pegawai',
        'password' => $validated['password'],
    ]);

    return redirect()
        ->route('settings.index')
        ->with('success', 'Akun pegawai berhasil ditambahkan.');
})->name('settings.users.store');

Route::delete('/settings/users/{user}', function (Request $request, User $user) {
    $actor = User::accountManager();
    abort_unless($actor, 403);

    if ($actor->is($user)) {
        return back()->with('error', 'Akun yang sedang Anda gunakan tidak bisa dihapus.');
    }

    $user->delete();

    return redirect()->route('settings.index')->with('success', 'Akun berhasil dihapus.');
})->name('settings.users.destroy');

Route::get('/settings/password', function () {
    abort_unless(User::sessionUser(), 403);

    return view('settings.password');
})->name('settings.password');


Route::post('/settings/password', function (Request $request) {
    $user = User::sessionUser();
    abort_unless($user, 403);

    $validated = $request->validate([
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
    ]);

    if (! Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
    }

    $user->update(['password' => $validated['password']]);

    return redirect()->route('settings.password')->with('success', 'Password Anda berhasil diperbarui.');
})->name('settings.password.update');
