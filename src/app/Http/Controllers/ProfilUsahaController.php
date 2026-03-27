<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilUsahaRequest;
use App\Models\ProfilUsaha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilUsahaController extends Controller
{
    /**
     * Show the business profile edit form.
     *
     * Creates a blank profile record if one doesn't exist yet for the tenant.
     * This uses firstOrCreate so the form always has a model to bind to.
     */
    public function edit(): View
    {
        if (! auth()->user()->tenant_id) {
            abort(403, 'Akun Super Admin tidak memiliki profil usaha.');
        }

        $profil = ProfilUsaha::firstOrCreate(
            ['tenant_id' => auth()->user()->tenant_id],
            [
                'nama_usaha' => auth()->user()->tenant->nama_tenant ?? '',
                'deskripsi' => '',
                'alamat' => '',
                'no_hp' => '',
            ]
        );

        return view('profil-usaha.edit', compact('profil'));
    }

    /**
     * Update the business profile.
     *
     * TENANCY RULE: Only updates the profile belonging to the user's tenant.
     */
    public function update(UpdateProfilUsahaRequest $request): RedirectResponse
    {
        $profil = ProfilUsaha::where('tenant_id', auth()->user()->tenant_id)->firstOrFail();

        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }

            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $profil->update($data);

        return redirect()
            ->route('profil-usaha.edit')
            ->with('success', 'Profil usaha berhasil diperbarui!');
    }
}
