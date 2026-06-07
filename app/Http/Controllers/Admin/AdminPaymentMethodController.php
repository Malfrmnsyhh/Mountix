<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->get();
        return view('admin.payment_method.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_method.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:bank,qris',
            'name' => 'required|string|max:255',
            'account_number' => 'required_if:type,bank|nullable|string|max:255',
            'account_name' => 'required_if:type,bank|nullable|string|max:255',
            'qr_image' => 'required_if:type,qris|nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        try {
            if ($request->hasFile('qr_image')) {
                $validated['qr_image'] = $request->file('qr_image')->store('payment_methods', 'public');
            }

            PaymentMethod::create($validated);

            return redirect()->route('admin.payment-method.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_method.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'type' => 'required|in:bank,qris',
            'name' => 'required|string|max:255',
            'account_number' => 'required_if:type,bank|nullable|string|max:255',
            'account_name' => 'required_if:type,bank|nullable|string|max:255',
            'qr_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        try {
            if ($request->hasFile('qr_image')) {
                if ($paymentMethod->qr_image) {
                    Storage::disk('public')->delete($paymentMethod->qr_image);
                }
                $validated['qr_image'] = $request->file('qr_image')->store('payment_methods', 'public');
            }

            $paymentMethod->update($validated);

            return redirect()->route('admin.payment-method.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            if ($paymentMethod->qr_image) {
                Storage::disk('public')->delete($paymentMethod->qr_image);
            }
            $paymentMethod->delete();
            return redirect()->route('admin.payment-method.index')->with('success', 'Metode pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payment-method.index')->with('error', 'Gagal menghapus data.');
        }
    }
}
