<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Trait\Voucher\VoucherValidationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    use VoucherValidationsTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $voucher = Voucher::all();
            return generateResponse('Voucher retrieved successfully.', $voucher);
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validationRequest = $request->validate([
                'code' => 'required|string|max:255',
                'discount' => 'required|numeric',
                'expiry_date' => 'required',
                'activation_date' => 'required',
            ]);

            $createVoucher = Voucher::create($validationRequest);
            return generateResponse('voucher created successfully.', $createVoucher);
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $fetchVoucher = Voucher::find($id);
            if (!is_null($fetchVoucher)) {
                return generateResponse('Voucher retrieved successfully.', $fetchVoucher);
            }

            return generateResponse('Voucher not found.', [], 404, 'error');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $fetchVoucher = Voucher::find($id);
            if (!is_null($fetchVoucher)) {
                $validationRequest = $request->validate([
                    'code' => 'required|string|max:255',
                    'discount' => 'required|numeric',
                    'expiry_date' => 'required|date',
                    'activation_date' => 'required|date',
                ]);

                $fetchVoucher->update($validationRequest);
                return generateResponse('Voucher updated successfully.', $request->all());
            }

            return generateResponse('Voucher not found.', [], 404, 'error');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500,  'error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $fetchVoucher = Voucher::findOrFail($id);
            $fetchVoucher->delete();
            return generateResponse('Voucher deleted successfully.');
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    public function ApplyVoucher(Request $request)
    {
        try {
            $current_user = Auth::user();
            $fetchVoucher = Voucher::byCode($request->code)->first();

            if (!is_null($fetchVoucher)) {
                $this->validationApplyVoucher($fetchVoucher);
                $userVoucher = VoucherUsage::voucherAlreadyUsedByUser($current_user->id, $fetchVoucher->id)->first();
                if ($userVoucher) {
                    return generateResponse('You have already used this voucher.', [], 400, 'error');
                } else {
                    $data_voucher_usage = VoucherUsage::applyVoucer($current_user->id, $fetchVoucher->id);
                    return  generateResponse('Voucher applied successfully.', $data_voucher_usage, 200, 'success');
                }
            }
        } catch (\Throwable $th) {
            return generateResponse($th->getMessage(), [], 500, 'error');
        }
    }

    public function runVoucherActivation()
    {
        Voucher::where([
            'activation_date' => now(),
            'status'          => 'deactive',
        ])->take(4)->update([
            'status'    => 'active'
        ]);
    }
}
